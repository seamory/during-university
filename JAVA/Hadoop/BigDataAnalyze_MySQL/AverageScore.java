package SCUJCC;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.DoubleWritable;
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

public class AverageScore {
    private static class StudentTable implements DBWritable, Writable{
        protected String XH;
        protected String XZB;
        protected String DOSZJ;
        protected String ZYMC;
        protected String KCMC;
        protected String CJ;
        protected String BKCJ;
        protected String CXCJ;
        protected String CXBJ;

        //    Writable
        public void write(DataOutput dataOutput) throws IOException{
            Text.writeString(dataOutput, this.XH);
            Text.writeString(dataOutput, this.XZB);
            Text.writeString(dataOutput, this.DOSZJ);
            Text.writeString(dataOutput, this.ZYMC);
            Text.writeString(dataOutput, this.KCMC);
            Text.writeString(dataOutput, this.CJ);
            Text.writeString(dataOutput, this.BKCJ);
            Text.writeString(dataOutput, this.CXCJ);
            Text.writeString(dataOutput, this.CXBJ);

        }

        public void readFields(DataInput dataInput) throws IOException{
            this.XH=Text.readString(dataInput);
            this.XZB=Text.readString(dataInput);
            this.DOSZJ=Text.readString(dataInput);
            this.ZYMC=Text.readString(dataInput);
            this.KCMC=Text.readString(dataInput);
            this.CJ=Text.readString(dataInput);
            this.BKCJ=Text.readString(dataInput);
            this.CXCJ=Text.readString(dataInput);
            this.CXBJ=Text.readString(dataInput);
        }

        //    DBWritable
        public void write(PreparedStatement preparedStatement) throws SQLException {
            preparedStatement.setString(1,this.XH);
            preparedStatement.setString(2,this.XZB);
            preparedStatement.setString(3,this.DOSZJ);
            preparedStatement.setString(4,this.ZYMC);
            preparedStatement.setString(5,this.KCMC);
            preparedStatement.setString(6,this.CJ);
            preparedStatement.setString(7,this.BKCJ);
            preparedStatement.setString(8,this.CXCJ);
            preparedStatement.setString(9,this.CXBJ);

        }

        public void readFields(ResultSet resultSet) throws SQLException{
            this.XH=resultSet.getString(1);
            this.XZB=resultSet.getString(2);
            this.DOSZJ=resultSet.getString(3);
            this.ZYMC=resultSet.getString(4);
            this.KCMC=resultSet.getString(5);
            this.CJ=resultSet.getString(6);
            this.BKCJ=resultSet.getString(7);
            this.CXCJ=resultSet.getString(8);
            this.CXBJ=resultSet.getString(9);
        }
    }

    public static class SQLMapper
        extends Mapper<LongWritable, StudentTable, Text, DoubleWritable>{

        @Override
        protected void map(LongWritable key, StudentTable value, Context context)
                throws IOException, InterruptedException {
            String XHNX;
            Double CJ;
            if(!value.CJ.equals("优秀") &&
                    !value.CJ.equals("中等") &&
                    !value.CJ.equals("良好") &&
                    !value.CJ.equals("及格") &&
                    !value.CJ.equals("不及格") &&
                    !value.CJ.equals("缓考") &&
                    !value.CJ.equals("通过") &&
                    !value.CJ.equals("缺考") &&
                    !value.CJ.equals("不通过")){
                if(value.CJ.equals("") || value.CJ == null){
                    System.out.println(value.KCMC);
                    XHNX = value.XH+'\t'+value.DOSZJ;
                    CJ = 0.0;
                } else {
                    System.out.println(value.KCMC);
                    XHNX = value.XH+'\t'+value.DOSZJ;
                    CJ = Double.parseDouble(value.CJ);
                }
                context.write(new Text(XHNX), new DoubleWritable(CJ));
            }
        }
    }

    public static class SQLReducer
            extends Reducer<Text, DoubleWritable, Text, DoubleWritable>{
        @Override
        protected void reduce(Text key, Iterable<DoubleWritable> values, Context context)
                throws IOException, InterruptedException {
            int count = 0;
            double sum = 0.0;
            Iterator<DoubleWritable> iterator = values.iterator();
            while (iterator.hasNext()) {
                sum += iterator.next().get();
                count++;
            }
            double average = sum / count;
            context.write(new Text(key), new DoubleWritable(average));
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
        Job job = Job.getInstance(conf, "Count Student Score");
        FileSystem hdfs=FileSystem.get(conf);
        Path delef=new Path("/output_sc");
        boolean isDeleted=hdfs.delete(delef,true);
        job.setJarByClass(AverageScore.class);
        job.setMapperClass(SQLMapper.class);
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(DoubleWritable.class);
        job.setReducerClass(SQLReducer.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(DoubleWritable.class);
        job.setInputFormatClass(DBInputFormat.class);
        String[] fields = {"XH","XZB","DOSZJ","ZYMC","KCMC","CJ","BKCJ","CXCJ","CXBJ"};
        DBInputFormat.setInput(
                job,
                StudentTable.class,
                "xscjxxb",
                null,
                "XH",
                fields
        );
        FileOutputFormat.setOutputPath(job, new Path(args[0]));
        job.waitForCompletion(true);
    }
}
