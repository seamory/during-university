package ComputData;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

import java.io.IOException;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Iterator;

public class Main {
    public static HashMap<String, String> Grade = new HashMap<String, String>(){
        {
            put("优秀", "90");put("中等", "80");put("良好", "70");
            put("及格", "60");put("不及格", "50");
            put("通过", "60");put("不通过", "50");
            put("缓考", "0");put("缺考", "0");
            put("","0");
        }
    };

    public static HashMap<String, Boolean> CostType = new HashMap<String, Boolean>(){
        {
            put("0",false);put("null",false);put("交行转入",false);put("修改密码",false);
            put("修改限额",false);put("单改资料",false);put("卡片挂失",false);put("原卡重写",false);
            put("取消挂失",false);put("帐户停用",false);put("帐户冻结",false);put("帐户启用",false);
            put("帐户解冻",false);put("开户发卡",false);put("开资金户",false);put("批改资料",false);
            put("支付宝转入",false);put("旧卡重写",false);put("结帐退卡",false);put("联网售票",false);
            put("补助联网退票",false);put("补发新卡",false);put("退票",false);put("银行转入",false);put("销资金户",false);
            put("医疗收费",true);put("可能消费",true);put("商场消费",true);put("图书收费",true);
            put("独立医疗",true);put("独立售饭",true);put("独立商场",true);put("独立图书",true);put("联网售饭",true);
        }
    };

    public static HashMap<String, Integer>  LibraryType = new HashMap<String, Integer>(){
        {
            put("丢书赔款", 5);put("续借", 3);
            put("并且超期天书大于0 图书超期罚款", 4);
            //  存在还书,保留本的地方为逗号,所以,使用awk","替换会导致数据结果出现问题
            //  存在逗号,修改数据格式
            put("还书",2);put("还书,保留本/保留本", 2);
            put("借书", 1);
        }
    };

    public static class DataMapper
            extends Mapper<LongWritable, Text, Text, Text>{
        @Override
        protected void map(LongWritable key, Text value, Context context)
                throws IOException, InterruptedException {
            //  0    1      2       3           4       5           6
            // BB    姓名    学号    操作类型    图书索引  图书价格    操作日期
            // EG    姓名    学号    刷卡日期    刷卡时间
            // SS    姓名    学号    正考成绩    补考成绩    学年
            // MC    姓名    学号    余额        充值额     操作类型    时间
            System.out.println(value);
            String[] line = value.toString().split("\t");
            if( line.length <= 3 || line[2].equals("NULL") || line[2].equals("") ){
                return;
            }
            if( line[0].equals("BB")){
                if( line[4].equals("") ) line[4]=" ";
                if( line[5].equals("") ) line[5]="0.0";
                context.write(new Text(line[1] + "\t" + line[2] + "\t" + line[6].substring(0, 4)),
                        new Text(line[0] + "\t" + line[4].substring(0, 1) + "\t" + line[5] + "\t" + line[3]));
            } else if ( line[0].equals("EG") ){
                context.write(new Text(line[1] + "\t" + line[2] + "\t" + line[3].substring(0,4)),
                        new Text(line[0] + "\t" + line[4].substring(0,2)));
            } else if ( line[0].equals("SS")){
                if ( Grade.containsKey(line[3]) ) line[3] = Grade.get(line[3]);
                if ( Grade.containsKey(line[4]) ) line[4] = Grade.get(line[4]);
                context.write(new Text(line[1] + "\t" + line[2] + "\t" + line[5]),
                        new Text(line[0] + "\t" + line[3] + "\t" + line[4]));
            } else if ( line[0].equals("MC")){
                context.write(new Text(line[1] + "\t" + line[2] + "\t" + line[6].substring(0,4)),
                        new Text(line[0] + "\t" + line[3] + "\t" + line[4] + "\t" + line[5]));
            }
        }
    }

    public static class DataReducer
        extends Reducer<Text, Text, Text, Text>{
        @Override
        protected void reduce(Text key, Iterable<Text> values, Context context) throws IOException, InterruptedException {
            Iterator<Text> iterator = values.iterator();

            double bookPrice = 0.0;
            int countBook = 0;
            int countRollOver = 0;
            int countLose = 0;
            int countOverdue = 0;
            HashSet<String> bookType = new HashSet<String>();
            StringBuffer bookTypes = new StringBuffer();
            int countNine = 0;
            int countEleven = 0;
            int countMakeUp = 0;
            int countRebuild = 0;
            int countObject = 0;
            double sumObject = 0;
            double average = 0;
            double payMax = 0;
            double topUp = 0;
            double sumPay = 0;

            while ( iterator.hasNext() ){
                String[] line = iterator.next().toString().split("\t");
                //  BB  类型  价格
                //
                if( line[0].equals("BB") ) {
                    if(  Double.parseDouble(line[2]) > bookPrice ) bookPrice = Double.parseDouble(line[2]);
                    if( LibraryType.containsKey(line[3]) ) {
                        if (LibraryType.get(line[3]) == 1) {
                            bookType.add(line[1]);
                            countBook++;
                        }
                        if (LibraryType.get(line[3]) == 3) countRollOver++;
                        if (LibraryType.get(line[3]) == 4) countOverdue++;
                        if (LibraryType.get(line[3]) == 5) countLose++;
                    }
                } else if ( line[0].equals("EG") ) {
                    int hour = Integer.parseInt(line[1]);
                    if( hour > 21 && hour < 23 ) countNine++;
                    else if (hour == 23 || ( hour > -1 && hour < 6 )) countEleven++;
                } else if ( line[0].equals("SS") ) {
                    if ( Double.parseDouble(line[1]) < 60 && Double.parseDouble(line[2]) < 60 ) countRebuild++;
                    if ( Double.parseDouble(line[1]) < 60 && Double.parseDouble(line[2]) >= 60 ) countMakeUp++;
                    sumObject += Double.parseDouble(line[1]);
                    countObject++;
                } else if ( line[0].equals("MC") ) {
                    if ( CostType.containsKey(line[3]) && CostType.get(line[3]) ){
                        sumPay += Double.parseDouble(line[2]);
                        if( Double.parseDouble(line[2]) > payMax ) payMax = Double.parseDouble(line[2]);
                    } else {
                        if( Double.parseDouble(line[1]) > topUp ) topUp = Double.parseDouble(line[1]);
                    }
                }
            }
            for(String value : bookType){
                bookTypes.append(value);
            }
            average = sumObject/countObject;
            String data = Integer.toString(countNine) + "\t" +  // 九点门禁数据
                    Integer.toString(countEleven) + "\t" +      // 十一点门禁数据
                    String.format("%.2f", sumPay) + "\t" +      // 饭卡消费总额
                    String.format("%.2f", payMax) + "\t" +      // 饭卡最大消费额
                    String.format("%.2f", topUp) + "\t" +       // 饭卡最大充值额
                    String.format("%.2f", average) + "\t" +     // 平均分
                    Integer.toString(countMakeUp) + "\t" +      // 补考次数
                    Integer.toString(countRebuild) + "\t" +     // 重修次数
                    Integer.toString(countBook) + "\t" +        // 借阅次数
                    bookTypes.toString().replaceAll(" ","") + "\t" +    // 图书类型
                    String.format("%.2f", bookPrice) + "\t" +   // 借阅图书中最贵多少钱
                    Integer.toString(countRollOver) + "\t" +    // 续借次数
                    Integer.toString(countOverdue) + "\t" +     // 逾期次数
                    Integer.toString(countLose);                // 丢失次数
            System.out.println(key.toString() + "\t" + data);
            context.write(key, new Text(data));
        }
    }

    public static void main(String[] args) throws Exception{
        long start = System.currentTimeMillis();
        Configuration conf = new Configuration();
        FileSystem hdfs= FileSystem.get(conf);
        Path delef=new Path("/output_scujcc");
        boolean isDeleted=hdfs.delete(delef,true);
        Job job = Job.getInstance(conf, "big data count");
        job.setJarByClass(Main.class);
        job.setMapperClass(DataMapper.class);
        job.setReducerClass(DataReducer.class);
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(Text.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(Text.class);
        FileInputFormat.addInputPath(job, new Path(args[0]));
        FileOutputFormat.setOutputPath(job, new Path(args[1]));
        System.out.println(job.waitForCompletion(true) ? 0 : 1);
        long end = System.currentTimeMillis();
        System.out.println("Finished Time : " + (end-start) + "ms");
    }

}
