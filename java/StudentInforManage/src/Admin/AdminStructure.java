package Admin;

/**
 * Created with IntelliJ IDEA.
 * User: KuoYu
 * Site: pythonic.site
 * Date: 2017-11-22
 * Time: 22:13
 * Description:
 */
public class AdminStructure {

    private String uid;
    private String username;
    private String password;

    /*
    Create external access method
 */
    public String getUid() {
        return uid;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }

    /*
      Initialize AdminStructure
    */
    public void setUid(String uid) { this.uid = uid; }

    public void setUsername(String username) {
        this.username = username;
    }

    public void setPassword(String password) {
        this.password = password;
    }


}


