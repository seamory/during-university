package SCUJCC;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.DoubleWritable;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.GenericOptionsParser;

import java.io.IOException;
import java.util.HashMap;
import java.util.Iterator;
public class Score {
    public static HashMap<String, String> Grade = new HashMap<String, String>(){
        {
            put("优秀", "90");
            put("中等", "80");
            put("良好", "70");
            put("及格", "60");
            put("不及格", "50");
            put("通过", "60");
            put("不通过", "50");
            put("缓考", "0");
            put("缺考", "0");
            put("", "0");
        }
    };
    
    public static class Map extends
            Mapper<LongWritable, Text, Text, DoubleWritable> {
        // 实现map函数
        public void map(LongWritable key, Text value, Context context)
                throws IOException, InterruptedException {
        	double score = 0.0;
            String line = value.toString();
            
            System.out.println(value);
            String[] one = line.split("\t");
            
            if( one.length < 3 || one[2].equals("CJ") ) return;
            
            System.out.println(one[2]);
            System.out.print("-------");
            if(Grade.containsKey(one[2])) score = Double.parseDouble(Grade.get(one[2]));
            else score = Double.parseDouble(one[2]);
            
            context.write(new Text(one[0] + "\t" + one[1]), new DoubleWritable(score));
        }
    }

    public static class Reduce extends
            Reducer<Text, DoubleWritable, Text, DoubleWritable> {
        // 实现reduce函数
        public void reduce(Text key, Iterable<DoubleWritable> values,
                           Context context) throws IOException, InterruptedException {
            double sum = 0.0;
            int count = 0;
            Iterator<DoubleWritable> iterator = values.iterator();
            while (iterator.hasNext()) {
                sum += iterator.next().get();// 计算总分
                System.out.println(sum);
                count++;// 统计总的科目数
            }
            double average =  sum / count;// 计算平均成绩
            context.write(key, new DoubleWritable(average));
        }
    }
    
    public static void main(String[] args) throws Exception {
        Configuration conf = new Configuration();
        String[] otherArgs = new GenericOptionsParser(conf, args)
                .getRemainingArgs();
        if (otherArgs.length != 2)
        {
            System.err.println("Usage: Single Table Join <in> <out>");
            System.exit(2);
        }
        Job job = new Job(conf, "Single Table Join");
        FileSystem hdfs = FileSystem.get(conf);
        Path path = new Path("/avg");
        hdfs.delete(path,true);
        job.setJarByClass(Score.class);
        job.setMapperClass(Map.class);
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(DoubleWritable.class);
        job.setReducerClass(Reduce.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(DoubleWritable.class);
        FileInputFormat.addInputPath(job, new Path(otherArgs[0]));
        FileOutputFormat.setOutputPath(job, new Path(otherArgs[1]));
        System.exit(job.waitForCompletion(true) ? 0 : 1);
    }
}

