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

public class childParentOne {
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
                context.write(new Text(child), new Text(0 + "-" +child + "-" +parent));
                context.write(new Text(parent), new Text( 1 + "-" + child + "-" +parent));
            }
        }
    }

    public static class IntSumReducer
            extends Reducer<Text, Text, Text, Text> {
        public void reduce(Text key, Iterable<Text> values, Context context)
                throws IOException, InterruptedException {
            ArrayList<String> grandchild = new ArrayList<String>();
            ArrayList<String> grandparent = new ArrayList<String>();
//            System.out.println(key.toString());
            Iterator<Text> iterator = values.iterator();
            while (iterator.hasNext()) {
                String value = iterator.next().toString();
                String[] childParent = value.split("-");
                if(childParent[0].equals("0")){
//                    child 0-child-parent
                    grandparent.add(childParent[2]);
                } else if(childParent[0].equals("1")) {
//                    parent 1-child-parent
                    grandchild.add(childParent[1]);
                }
            }
            if(grandchild.size() != 0 && grandparent.size() != 0) {
                for (int i = 0; i < grandchild.size(); i++) {
                    for (int j = 0; j < grandparent.size(); j++) {
                        context.write(new Text(grandchild.get(i)), new Text(grandparent.get(j)));
                    }
                }
            }
        }
    }

    public static void main(String[] args) throws Exception {
        long start = System.currentTimeMillis();
        Configuration conf = new Configuration();
        FileSystem hdfs=FileSystem.get(conf);
        Path delef=new Path("/output");
        boolean isDeleted=hdfs.delete(delef,true);
        Job job = Job.getInstance(conf, "childParentOne");
        job.setJarByClass(childParentOne.class);
        job.setMapperClass(TokenizerMapper.class);
        job.setReducerClass(IntSumReducer.class);
        job.setOutputKeyClass(Text.class);
        job.setOutputValueClass(Text.class);
        FileInputFormat.addInputPath(job, new Path(args[0]));
        FileOutputFormat.setOutputPath(job, new Path(args[1]));
        System.out.println(job.waitForCompletion(true) ? 0 : 1);
        long end = System.currentTimeMillis();
        System.out.println("One Time : " + (end-start) + "ms");

    }
}