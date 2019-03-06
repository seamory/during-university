import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem; 
import org.apache.hadoop.fs.Path;   
public class DeleteFile {     
    public static void main(String[] args) throws Exception {
        Configuration conf=new Configuration();
        FileSystem hdfs=FileSystem.get(conf);
        Path delef=new Path("/output");
        //boolean isDeleted=hdfs.delete(delef,false);
        //递归删除
        boolean isDeleted=hdfs.delete(delef,true);
        System.out.println("Delete?"+isDeleted);
    }
}