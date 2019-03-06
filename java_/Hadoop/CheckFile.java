import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;

public class CheckFile {
    public static void main(String[] args) throws Exception {
        Configuration conf = new Configuration();
        FileSystem hdfs = FileSystem.get(conf);
        Path findf = new Path("/input/LICENSE.txt");
        boolean isExists = hdfs.exists(findf);
        System.out.println("Exist?"+isExists);
    }
}
