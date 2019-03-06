package SCUJCC;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.*;
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

public class CountCost {

    private static class CountCostTable implements DBWritable, Writable{
//        protected String YKTYHXFSJZL_ID;
//        protected String SOURCETABLE;
//        protected String ID;
//        protected String ECODE;
//        protected String NOTECASE;
//        protected String CUSTOMERID;
//        protected String OUTID;
//        protected String CARDSN;
//        protected String SAVEOPCOUNT;
//        protected String OPCOUNT;
        protected String CZSJ;
//        protected String YE;
        protected String CZE;
//        protected String MNGFARE;
//        protected String ACCCODE;
//        protected String DSCRP;
//        protected String CZLX;
//        protected String JYLSH;
        protected String XH;
//        protected String JYLXBM;
        protected String JYLXBMMC;
//        protected String XFDD;

        public void write(PreparedStatement preparedStatement) throws SQLException{
//            preparedStatement.setString(1,this.YKTYHXFSJZL_ID);
//            preparedStatement.setString(2,this.SOURCETABLE);
//            preparedStatement.setString(3,this.ID);
//            preparedStatement.setString(4,this.ECODE);
//            preparedStatement.setString(5,this.NOTECASE);
//            preparedStatement.setString(6,this.CUSTOMERID);
//            preparedStatement.setString(7,this.OUTID);
//            preparedStatement.setString(8,this.CARDSN);
//            preparedStatement.setString(9,this.SAVEOPCOUNT);
//            preparedStatement.setString(10,this.OPCOUNT);
            preparedStatement.setString(1,this.CZSJ);
//            preparedStatement.setString(12,this.YE);
            preparedStatement.setString(2,this.CZE);
//            preparedStatement.setString(14,this.MNGFARE);
//            preparedStatement.setString(15,this.ACCCODE);
//            preparedStatement.setString(16,this.DSCRP);
//            preparedStatement.setString(17,this.CZLX);
//            preparedStatement.setString(18,this.JYLSH);
            preparedStatement.setString(3,this.XH);
//            preparedStatement.setString(20,this.JYLXBM);
            preparedStatement.setString(4,this.JYLXBMMC);
//            preparedStatement.setString(22,this.XFDD);
        }

        public void readFields(ResultSet resultSet) throws SQLException{
//            this.YKTYHXFSJZL_ID=resultSet.getString(1);
//            this.SOURCETABLE=resultSet.getString(2);
//            this.ID=resultSet.getString(3);
//            this.ECODE=resultSet.getString(4);
//            this.NOTECASE=resultSet.getString(5);
//            this.CUSTOMERID=resultSet.getString(6);
//            this.OUTID=resultSet.getString(7);
//            this.CARDSN=resultSet.getString(8);
//            this.SAVEOPCOUNT=resultSet.getString(9);
//            this.OPCOUNT=resultSet.getString(10);
            this.CZSJ=resultSet.getString(1);
//            this.YE=resultSet.getString(12);
            this.CZE=resultSet.getString(2);
//            this.MNGFARE=resultSet.getString(14);
//            this.ACCCODE=resultSet.getString(15);
//            this.DSCRP=resultSet.getString(16);
//            this.CZLX=resultSet.getString(17);
//            this.JYLSH=resultSet.getString(18);
            this.XH=resultSet.getString(3);
//            this.JYLXBM=resultSet.getString(20);
            this.JYLXBMMC=resultSet.getString(4);
//            this.XFDD=resultSet.getString(22);
        }

        public void write(DataOutput dataOutput) throws IOException{
//            Text.writeString(dataOutput, this.YKTYHXFSJZL_ID);
//            Text.writeString(dataOutput, this.SOURCETABLE);
//            Text.writeString(dataOutput, this.ID);
//            Text.writeString(dataOutput, this.ECODE);
//            Text.writeString(dataOutput, this.NOTECASE);
//            Text.writeString(dataOutput, this.CUSTOMERID);
//            Text.writeString(dataOutput, this.OUTID);
//            Text.writeString(dataOutput, this.CARDSN);
//            Text.writeString(dataOutput, this.SAVEOPCOUNT);
//            Text.writeString(dataOutput, this.OPCOUNT);
            Text.writeString(dataOutput, this.CZSJ);
//            Text.writeString(dataOutput, this.YE);
            Text.writeString(dataOutput, this.CZE);
//            Text.writeString(dataOutput, this.MNGFARE);
//            Text.writeString(dataOutput, this.ACCCODE);
//            Text.writeString(dataOutput, this.DSCRP);
//            Text.writeString(dataOutput, this.CZLX);
//            Text.writeString(dataOutput, this.JYLSH);
            Text.writeString(dataOutput, this.XH);
//            Text.writeString(dataOutput, this.JYLXBM);
            Text.writeString(dataOutput, this.JYLXBMMC);
//            Text.writeString(dataOutput, this.XFDD);
        }

        public void readFields(DataInput dataInput) throws IOException{
//            this.YKTYHXFSJZL_ID=Text.readString(dataInput);
//            this.SOURCETABLE=Text.readString(dataInput);
//            this.ID=Text.readString(dataInput);
//            this.ECODE=Text.readString(dataInput);
//            this.NOTECASE=Text.readString(dataInput);
//            this.CUSTOMERID=Text.readString(dataInput);
//            this.OUTID=Text.readString(dataInput);
//            this.CARDSN=Text.readString(dataInput);
//            this.SAVEOPCOUNT=Text.readString(dataInput);
//            this.OPCOUNT=Text.readString(dataInput);
            this.CZSJ=Text.readString(dataInput);
//            this.YE=Text.readString(dataInput);
            this.CZE=Text.readString(dataInput);
//            this.MNGFARE=Text.readString(dataInput);
//            this.ACCCODE=Text.readString(dataInput);
//            this.DSCRP=Text.readString(dataInput);
//            this.CZLX=Text.readString(dataInput);
//            this.JYLSH=Text.readString(dataInput);
            this.XH=Text.readString(dataInput);
//            this.JYLXBM=Text.readString(dataInput);
            this.JYLXBMMC=Text.readString(dataInput);
//            this.XFDD=Text.readString(dataInput);
        }
    }

    private static class SQLMapper
            extends Mapper<LongWritable, CountCostTable, Text, DoubleWritable>{
        @Override
        protected void map(LongWritable key, CountCostTable value, Context context) throws IOException, InterruptedException {
            String XH = value.XH;
            Double CZE = Double.parseDouble(value.CZE);
            String YEAR = value.CZSJ.substring(0,4);
            String JYLXBMMC = value.JYLXBMMC;
            if( !(JYLXBMMC.equals("NULL") || JYLXBMMC.equals("") ||
                    JYLXBMMC.equals("0") || JYLXBMMC == null) && (
                        JYLXBMMC.equals("医疗收费") || JYLXBMMC.equals("可能消费") ||
                        JYLXBMMC.equals("商场消费") || JYLXBMMC.equals("图书收费") ||
                        JYLXBMMC.equals("独立医疗") || JYLXBMMC.equals("独立售饭") ||
                        JYLXBMMC.equals("独立商场") || JYLXBMMC.equals("独立图书") ||
                        JYLXBMMC.equals("联网售饭")
                    )) {
                context.write(new Text(XH + "\t" + YEAR),
                        new DoubleWritable(CZE));
            }
        }
    }

    private static class SQLReducer
        extends Reducer<Text, DoubleWritable, Text, DoubleWritable>{
        @Override
        protected void reduce(Text key, Iterable<DoubleWritable> values, Context context) throws IOException, InterruptedException {
            double sum = 0.0;
            Iterator<DoubleWritable> iterator = values.iterator();
            while(iterator.hasNext()){
                sum += iterator.next().get();
            }
            context.write(key, new DoubleWritable(sum));
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
        Path delef=new Path("/output_cc");
        boolean isDeleted=hdfs.delete(delef,true);
        job.setJarByClass(CountCost.class);

        job.setMapperClass(SQLMapper.class);
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(DoubleWritable.class);

        job.setReducerClass(SQLReducer.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(DoubleWritable.class);

        job.setInputFormatClass(DBInputFormat.class);
//        String[] fields = {"YKTYHXFSJZL_ID", "SOURCETABLE",
//                "ID", "ECODE", "NOTECASE", "CUSTOMERID",
//                "OUTID", "CARDSN", "SAVEOPCOUNT", "OPCOUNT",
//                "CZSJ", "YE", "CZE", "MNGFARE", "ACCCODE",
//                "DSCRP", "CZLX", "JYLSH", "XH", "JYLXBM",
//                "JYLXBMMC", "XFDD"};
        String[] fields = {"CZSJ","CZE","XH","JYLXBMMC"};
         DBInputFormat.setInput(
                job,
                CountCostTable.class,
                "yktyhxfsjzl_new",
                null,
                "XH",
                fields
        );
        FileOutputFormat.setOutputPath(job, new Path(args[0]));
        job.waitForCompletion(true);
    }
}
