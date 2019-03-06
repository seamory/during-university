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
import java.util.HashMap;
import java.util.Iterator;
import java.util.StringTokenizer;

public class childParentFour {
    public static HashMap<String, ArrayList<String> > childParent = new HashMap<String, ArrayList<String> >();
    public static class TokenizerMapper
            extends Mapper<Object, Text, Text, Text> {
        public void map(Object key, Text value, Context context
        ) throws IOException, InterruptedException {
            StringTokenizer itr = new StringTokenizer(value.toString()," ");
            while(itr.hasMoreTokens()){
                String child = itr.nextToken();
                String parent = itr.nextToken();
                if ( !childParent.containsKey(child) ) {
                    ArrayList<String> parents = new ArrayList<String>();
                    parents.add(parent);
                    childParent.put(child, parents);
                    context.write(new Text(child), new Text(parent));
                }
                if(childParent.containsKey(child) && !childParent.get(child).contains(parent)){
                   childParent.get(child).add(parent);
                    context.write(new Text(child), new Text(parent));
                }
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
                if(childParent.containsKey(value.toString())){
                    for (String grandparent:childParent.get(value.toString())) {
                        context.write(key, new Text(grandparent));
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
        job.setJarByClass(childParentFour.class);
        job.setMapperClass(TokenizerMapper.class);
        job.setReducerClass(Result.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(Text.class);
        FileInputFormat.addInputPath(job, new Path(args[0]));
        FileOutputFormat.setOutputPath(job, new Path(args[1]));
        System.out.println(job.waitForCompletion(true) ? 0 : 1);
        long end = System.currentTimeMillis();
        System.out.println("Four Time : " + (end-start) + "ms");
    }
}