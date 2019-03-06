package SCUJCC;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
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
import java.util.HashSet;
import java.util.Iterator;
import java.util.Set;

public class BorrowData {
    private static class BorrowTable implements DBWritable, Writable{
        protected String ID;
        protected String CZLX;
        protected String JYSJ;
        protected String SSH;

        public void write(PreparedStatement preparedStatement) throws SQLException{
            preparedStatement.setString(1,this.ID);
            preparedStatement.setString(2,this.CZLX);
            preparedStatement.setString(3,this.JYSJ);
            preparedStatement.setString(4,this.SSH);
        }

        public void readFields(ResultSet resultSet) throws SQLException{
            this.ID = resultSet.getString(1);
            this.CZLX = resultSet.getString(2);
            this.JYSJ = resultSet.getString(3);
            this.SSH = resultSet.getString(4);

        }

        public void write(DataOutput dataOutput) throws IOException{
            Text.writeString(dataOutput, this.ID);
            Text.writeString(dataOutput, this.CZLX);
            Text.writeString(dataOutput, this.JYSJ);
            Text.writeString(dataOutput, this.SSH);
        }

        public void readFields(DataInput dataInput) throws IOException{
            this.ID = Text.readString(dataInput);
            this.CZLX = Text.readString(dataInput);
            this.JYSJ = Text.readString(dataInput);
            this.SSH = Text.readString(dataInput);
        }
    }

    public static class SQLMapper
            extends Mapper<LongWritable, BorrowTable, Text, Text> {
        @Override
        protected void map(LongWritable key, BorrowTable value, Context context) throws IOException, InterruptedException {
            if(value.CZLX.equals("借书")) {
                context.write(new Text(value.ID + "\t" +
                                value.JYSJ.substring(0,4)),
                        new Text(value.SSH.substring(0,1)));
            }
        }
    }

    public static class SQLReducer
            extends Reducer<Text, Text, Text, Text> {
        @Override
        protected void reduce(Text key, Iterable<Text> values, Context context)
                throws IOException, InterruptedException {
            Set<String> Type = new HashSet<String>();
            int countBorrow = 0;
            Iterator<Text> iterator = values.iterator();
            while (iterator.hasNext()){
                countBorrow++;
                Type.add(iterator.next().toString());
            }
            context.write(key, new Text(Type.toArray().toString() + "\t" + countBorrow));
        }
    }

    public static void main(String[] args) throws Exception {
        Configuration conf = new Configuration();
        DBConfiguration.configureDB(
                conf,
                "com.mysql.jdbc.Driver",
                "jdbc:mysql://localhost:3306/scujcc",
                "root",
                "");
        Job job = Job.getInstance(conf, "EntranceGuard");
        FileSystem hdfs = FileSystem.get(conf);
        Path delef = new Path("/output_bb");
        boolean isDeleted = hdfs.delete(delef, true);
        job.setJarByClass(EntranceGuard.class);

        job.setMapperClass(EntranceGuard.SQLMapper.class);
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(Text.class);

        job.setReducerClass(EntranceGuard.SQLReducer.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(Text.class);

        job.setInputFormatClass(DBInputFormat.class);

        String[] fields = {"ID","CZLX","JYSJ","SSH"};
        DBInputFormat.setInput(
                job,
                BorrowTable.class,
                "borrowbook",
                null,
                "ID",
                fields
        );
        FileOutputFormat.setOutputPath(job, new Path(args[0]));
        job.waitForCompletion(true);
    }
}
