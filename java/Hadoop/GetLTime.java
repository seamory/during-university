import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileStatus;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;

public class GetLTime {
    public static void main(String[] args) throws Exception {
        Configuration conf = new Configuration();
        FileSystem hdfs = FileSystem.get(conf);
        Path fpath = new Path("/user/hadoop/test/file1.txt");
        FileStatus fileStatus = hdfs.getFileStatus(fpath);
        long modiTime = fileStatus.getModificationTime();
        System.out.println("file1.txt 的修改时间是" + modiTime);
    }
}

