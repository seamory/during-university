package SCUJCC;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.io.Writable;
import org.apache.hadoop.mapred.lib.db.DBConfiguration;
import org.apache.hadoop.mapred.lib.db.DBInputFormat;
import org.apache.hadoop.mapred.lib.db.DBWritable;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

import java.io.DataInput;
import java.io.DataOutput;
import java.io.IOException;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Iterator;

public class EntranceGuard {
    private static class EntranceGuardTable implements DBWritable, Writable{
//        USER_ID, SBBH, SBMC, SBLXBH, SBLX, SKRQ, SKSJ
        protected String USER_ID;
        protected String SBBH;
        protected String SBMC;
        protected String SBLXBH;
        protected String SBLX;
        protected String SKRQ;
        protected String SKSJ;

        public void write(PreparedStatement preparedStatement) throws SQLException{
            preparedStatement.setString(1,this.USER_ID);
            preparedStatement.setString(2,this.SBBH);
            preparedStatement.setString(3,this.SBMC);
            preparedStatement.setString(4,this.SBLXBH);
            preparedStatement.setString(5,this.SBLX);
            preparedStatement.setString(6,this.SKRQ);
            preparedStatement.setString(7,this.SKSJ);
        }

        public void readFields(ResultSet resultSet) throws SQLException{
            this.USER_ID = resultSet.getString(1);
            this.SBBH = resultSet.getString(2);
            this.SBMC = resultSet.getString(3);
            this.SBLXBH = resultSet.getString(4);
            this.SBLX = resultSet.getString(5);
            this.SKRQ = resultSet.getString(6);
            this.SKSJ = resultSet.getString(7);
        }

        public void write(DataOutput dataOutput) throws IOException{
            Text.writeString(dataOutput, this.USER_ID);
            Text.writeString(dataOutput, this.SBBH);
            Text.writeString(dataOutput, this.SBMC);
            Text.writeString(dataOutput, this.SBLXBH);
            Text.writeString(dataOutput, this.SBLX);
            Text.writeString(dataOutput, this.SKRQ);
            Text.writeString(dataOutput, this.SKSJ);

        }

        public void readFields(DataInput dataInput) throws IOException{
            this.USER_ID = Text.readString(dataInput);
            this.SBBH = Text.readString(dataInput);
            this.SBMC = Text.readString(dataInput);
            this.SBLXBH = Text.readString(dataInput);
            this.SBLX = Text.readString(dataInput);
            this.SKRQ = Text.readString(dataInput);
            this.SKSJ = Text.readString(dataInput);
        }
    }

    public static class SQLMapper
        extends Mapper<LongWritable, EntranceGuardTable, Text, IntWritable>{
        @Override
        protected void map(LongWritable key, EntranceGuardTable value, Context context)
                throws IOException, InterruptedException {
            String USER_ID = value.USER_ID;
            String YEAR = value.SKRQ.substring(0,4);
            int HOUR = Integer.parseInt(value.SKSJ.split(":")[0]);
            context.write(new Text(USER_ID + "\t" + YEAR), new IntWritable(HOUR));
        }
    }

    public static class SQLReducer
        extends Reducer<Text, IntWritable, Text, Text>{
        @Override
        protected void reduce(Text key, Iterable<IntWritable> values, Context context)
                throws IOException, InterruptedException {
            int countNine = 0;
            int countEleven = 0;
            Iterator<IntWritable> iterator = values.iterator();
            while (iterator.hasNext()){
                int HOUR = iterator.next().get();
                if(HOUR < 23 && HOUR > 20){
                    countNine++;
                } else if ( (HOUR < 7 && HOUR >-1) ||
                        HOUR==23 ){
                    countEleven++;
                }
            }
            String Result = Integer.toString(countNine) + "\t" + Integer.toString(countEleven);
            context.write(key, new Text(Result));
        }
    }

    public static void main(String[] args) throws Exception{
        Configuration conf = new Configuration();
        DBConfiguration.configureDB(
                conf,
                "com.mysql.jdbc.Driver",
                "jdbc:mysql://localhost:3306/scujcc",
                "root",
                "");
        Job job = Job.getInstance(conf, "EntranceGuard");
        FileSystem hdfs= FileSystem.get(conf);
        Path delef=new Path("/output_eg");
        boolean isDeleted=hdfs.delete(delef,true);
        job.setJarByClass(EntranceGuard.class);

        job.setMapperClass(SQLMapper.class);
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(IntWritable.class);

        job.setReducerClass(SQLReducer.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(Text.class);

        job.setInputFormatClass(DBInputFormat.class);
        String[] fields = {"USER_ID", "SBBH", "SBMC", "SBLXBH", "SBLX", "SKRQ", "SKSJ"};
        DBInputFormat.setInput(
                job,
                EntranceGuardTable.class,
                "mjxxb",
                null,
                "USER_ID",
                fields
        );
        FileOutputFormat.setOutputPath(job, new Path(args[0]));
        job.waitForCompletion(true);
    }
}
