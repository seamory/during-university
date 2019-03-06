import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileStatus;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
public class CopyFile {
    public static void main(String[] args) throws Exception
    {
        Configuration conf=new Configuration();
        FileSystem hdfs=FileSystem.get(conf);
        Path src =new Path("D:\\txt");
        Path dst =new Path("/");
        hdfs.copyFromLocalFile(src, dst);
        System.out.println("Upload to"+conf.get("fs.default.name"));
        FileStatus files[]=hdfs.listStatus(dst);
        for(FileStatus file:files){
            System.out.println(file.getPath());
        }
    }
}