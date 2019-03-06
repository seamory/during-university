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

public class DataAnalysis {
    public static HashMap<String, String> Grade = new HashMap<String, String>(){
        {
            put("优秀", "90");put("中等", "80");put("良好", "70");
            put("及格", "60");put("不及格", "50");
            put("通过", "60");put("不通过", "50");
            put("缓考", "0");put("缺考", "0");
            put("","0");
        }
    };

    public static HashMap<String, Integer> CostType = new HashMap<String, Integer>(){
        {
//            账户消费类
            put("医疗收费",0);put("可能消费",0);put("商场消费",0);put("图书收费",0);
            put("独立医疗",0);put("独立售饭",0);put("独立商场",0);put("独立图书",0);
            put("联网售饭",0);
//            账户充值类
            put("交行转入",1);put("银行转入",1);put("支付宝转入",1);put("联网售票",1);
            put("补助联网退票",1);put("退票",1);
//            账户挂失类
            put("卡片挂失",2);
//            账户操作类
            put("修改密码",3);put("修改限额",3);put("单改资料",3);put("批改资料",3);
            put("原卡重写",3);put("帐户停用",3);put("开户发卡",3);put("开资金户",3);
            put("帐户解冻",3);put("旧卡重写",3);put("结帐退卡",3);put("补发新卡",3);
            put("销资金户",3);put("帐户冻结",3);put("帐户启用",3);
//            未知类
            put("0",-1);put("null",-1);

        }
    };

    public static HashMap<String, Integer>  LibraryType = new HashMap<String, Integer>(){
        {
            put("借书", 1);put("预约", 1);
            //  存在还书,保留本的地方为逗号,所以,使用awk","替换会导致数据结果出现问题
            put("还书",2);put("取消预约",2);put("还书,保留本/保留本", 2);
            put("续借", 3);
            put("并且超期天书大于0 图书超期罚款", 4);put("退赔", 4);
            put("赔书", 5);put("丢书赔款", 5);
            put("", 6);
        }
    };

    public static Boolean hasNoTitle = true;

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
                context.write(new Text(line[2] + "\t" + line[1] + "\t" + line[6].substring(0, 4)),
                        new Text(line[0] + "\t" + line[4].substring(0, 1) + "\t" + line[5] + "\t" + line[3]));
            } else if ( line[0].equals("EG") ){
                context.write(new Text(line[2] + "\t" + line[1] + "\t" + line[3].substring(0,4)),
                        new Text(line[0] + "\t" + line[4].substring(0,2)));
            } else if ( line[0].equals("SS")){
                if ( Grade.containsKey(line[3]) ) line[3] = Grade.get(line[3]);
                if ( Grade.containsKey(line[4]) ) line[4] = Grade.get(line[4]);
                context.write(new Text(line[2] + "\t" + line[1] + "\t" + line[5]),
                        new Text(line[0] + "\t" + line[3] + "\t" + line[4]));
            } else if ( line[0].equals("MC")){
                context.write(new Text(line[2] + "\t" + line[1] + "\t" + line[6].substring(0,4)),
                        new Text(line[0] + "\t" + line[3] + "\t" + line[4] + "\t" + line[5]));
            }
        }
    }

    public static class DataReducer
        extends Reducer<Text, Text, Text, Text>{
        @Override
        protected void reduce(Text key, Iterable<Text> values, Context context) throws IOException, InterruptedException {
            Iterator<Text> iterator = values.iterator();
            if ( hasNoTitle ){
                hasNoTitle = false;
                context.write(new Text("学号\t姓名\t学年"),
                        new Text("门禁9点\t门禁11点\t" +
                                "消费总额\t最大消费额\t最大充值额\t饭卡遗失\t" +
                                "课程数\t平均分\t补考\t重修\t" +
                                "借阅\t类型\t借阅最贵的书\t续借\t逾期\t丢失")
                );
            }

            double bookPrice = 0.0; //  借阅的最贵的书
            int countBook = 0;      //  借阅次数
            int countRollOver = 0;  //  续借次数
            int countLose = 0;      //  遗失次数
            int countOverdue = 0;   //  逾期次数
            HashSet<String> bookType = new HashSet<String>();   //  图书类型
            StringBuffer bookTypes = new StringBuffer();        //  图书类型
            int countNine = 0;      //  门禁9点
            int countEleven = 0;    //  门禁11点
            int countMakeUp = 0;    //  补考次数
            int countRebuild = 0;   //  重修次数
            int countObject = 0;    //  统计科目
            double sumObject = 0;   //  统计总分
            double average = 0;     //  统计平均分
            double payMax = 0;      //  消费最大值
            double topUp = 0;       //  充值最大值
            double sumPay = 0;      //  消费总计
            int cardLose = 0;       //  饭卡遗失次数

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
                    if( hour > 20 && hour < 23 ) countNine++;
                    else if (hour == 23 || ( hour > -1 && hour < 6 )) countEleven++;
                } else if ( line[0].equals("SS") ) {
                    if ( Double.parseDouble(line[1]) < 60 && Double.parseDouble(line[2]) < 60 ) countRebuild++;
                    if ( Double.parseDouble(line[1]) < 60 && Double.parseDouble(line[2]) >= 60 ) countMakeUp++;
                    sumObject += Double.parseDouble(line[1]);
                    countObject++;
                } else if ( line[0].equals("MC") && CostType.containsKey(line[3]) ) {
                    if ( CostType.get(line[3]) == 0 ){
                        sumPay += Double.parseDouble(line[2]);
                        if( Double.parseDouble(line[2]) > payMax ) payMax = Double.parseDouble(line[2]);
                    } else if( CostType.get(line[3]) == 1 ) {
                        if( Double.parseDouble(line[2]) > topUp ) topUp = Double.parseDouble(line[2]);
                    } else if( CostType.get(line[3]) == 2 ) {
                        cardLose++;
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
                    Integer.toString(cardLose) + "\t" +         // 饭卡遗失次数
                    Integer.toString(countObject) + "\t" +      // 计算课程数
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
        job.setJarByClass(DataAnalysis.class);
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
