import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.BlockLocation;
import org.apache.hadoop.fs.FileStatus;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;

public class FileLoc {
    public static void main(String[] args) throws Exception { Configuration conf=new Configuration();
        FileSystem hdfs=FileSystem.get(conf);
        Path fpath = new Path("/user/hadoop/cygwin");
        FileStatus filestatus = hdfs.getFileStatus(fpath);
        BlockLocation[] blkLocations = hdfs.getFileBlockLocations(filestatus, 0, filestatus.getLen());
        int blockLen = blkLocations.length;
        for(int i=0;i<blockLen;i++){
            String[] hosts = blkLocations[i].getHosts(); System.out.println("block_"+i+"_location:"+hosts[0]);
        }
    }
}
