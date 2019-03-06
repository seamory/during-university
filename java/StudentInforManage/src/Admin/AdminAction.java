package Admin;
import Mysql.DatabaseConnection;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

/**
 * Created with IntelliJ IDEA.
 * User: KuoYu
 * Site: pythonic.site
 * Date: 2017-11-22
 * Time: 22:12
 * Description:
 */
public class AdminAction {
    java.sql.Connection conn = null;

    public static boolean appendAdmin(String username, String password){
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("insert into administrators(username, password) values (?, ?) ");
            sqlString.setString(1,username);
            sqlString.setString(2,password);
            sqlString.execute();
            sqlString.close();
            return true;
        }catch (Exception e){
            return false;
        }
    }

    public static boolean deleteAdmin(String uid){
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("delete from administrators where uid=?");
            sqlString.setString(1,uid);
            sqlString.execute();
            conn.close();
            return true;
        }catch (Exception e){
            return false;
        }
    }

    public static boolean updateAdmin(String uid, String password){
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("update administrators set password=? where uid=?");
            sqlString.setString(1,password);
            sqlString.setString(2,uid);
            sqlString.execute();
            conn.close();
            return true;
        }catch (Exception e){
            return false;
        }
    }

    public static AdminStructure getOneAdmin(String username, String password){
        AdminStructure admin = new AdminStructure();
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from administrators where username=? and password=?");
            sqlString.setString(1,username);
            sqlString.setString(2,password);
            sqlString.execute();
            ResultSet result = sqlString.getResultSet();
           while( result.next() ) {
                admin.setUid(result.getString("uid"));
                admin.setUsername(result.getString("username"));
                admin.setPassword(result.getString("password"));
           }
            conn.close();
            return admin;
        } catch (Exception e) {
            return admin;
        }
    }


    public static ArrayList getAllAdmin(){
        ArrayList Admins = new ArrayList();
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from administrators");
            sqlString.execute();
            ResultSet result = sqlString.getResultSet();
            while(result.next()){
                Admin.AdminStructure Admin = new Admin.AdminStructure();
                Admin.setUid(result.getString("uid"));
                Admin.setUsername(result.getString("username"));
                Admins.add(Admin);
            }
            conn.close();
            return Admins;
        }catch (Exception e){
            return Admins;
        }
    }
}
