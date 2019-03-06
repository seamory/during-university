import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.StringTokenizer;

public class childParentThree {
    public static ArrayList<String> childs = new ArrayList<String>();
    public static ArrayList<String> parents = new ArrayList<String>();
    public static class TokenizerMapper
            extends Mapper<Object, Text, Text, Text> {
        public void map(Object key, Text value, Context context
        ) throws IOException, InterruptedException {
            StringTokenizer itr = new StringTokenizer(value.toString()," ");
            while(itr.hasMoreTokens()){
                String child = itr.nextToken();
                String parent = itr.nextToken();
                if(child.equals("C") && parent.equals("p")){
                    continue;
                }
                childs.add(child);
                parents.add(parent);
//                System.out.println(parents.get(parents.size()-1));
                context.write(new Text(parent), new Text(child));
            }
        }
    }

    public static class Result
            extends Reducer<Text, Text, Text, Text> {
        public void reduce(Text key, Iterable<Text> values, Context context)
                throws IOException, InterruptedException {
            Iterator<Text> iterator = values.iterator();
            while (iterator.hasNext()){
                Text value = iterator.next();
                if(parents.contains(value.toString())){
                    for (int i = 0; i < parents.size(); i++){
                        if(parents.get(i).equals(value.toString())){
                            context.write(new Text(childs.get(i)), key);
                        }
                    }
                }
            }
        }
    }

    public static void main(String[] args) throws Exception {
        long start = System.currentTimeMillis();
        Configuration conf = new Configuration();
        FileSystem hdfs= FileSystem.get(conf);
        Path delef=new Path("/output");
        boolean isDeleted=hdfs.delete(delef,true);
        Job job = Job.getInstance(conf, "childParentThree");
        job.setJarByClass(childParentThree.class);
        job.setMapperClass(TokenizerMapper.class);
        job.setReducerClass(Result.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(Text.class);
        FileInputFormat.addInputPath(job, new Path(args[0]));
        FileOutputFormat.setOutputPath(job, new Path(args[1]));
        System.out.println(job.waitForCompletion(true) ? 0 : 1);
        long end = System.currentTimeMillis();
        System.out.println("One Time : " + (end-start) + "ms");
    }
}