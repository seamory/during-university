import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.Path;

public  class  Rename {
    public static void main(String[] args) throws Exception {
        Configuration conf = new Configuration();
        FileSystem hdfs = FileSystem.get(conf);
        Path frpath = new Path("/test");
        Path topath = new Path("/test1");
        boolean isRename = hdfs.rename(frpath, topath);
        String result = isRename ? "成功" : "失败";
        System.out.println("文件重命名结果为：" + result);
    }
}
