package Common;

import Mysql.DatabaseConnection;
import Score.ScoreStructure;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class CommonQuery {
    java.sql.Connection conn = null;

    public static ArrayList getAllCollege(){
        ArrayList colleges = new ArrayList();
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from collegemajordict GROUP BY college");
            sqlString.execute();
            ResultSet result =  sqlString.getResultSet();
            while(result.next()){
                CollegeStructure college = new CollegeStructure();
                college.setUid(result.getString("uid"));
                college.setCollege(result.getString("college"));
                college.setMajor(result.getString("major"));
                colleges.add(college);
            }
            sqlString.close();
            return colleges;
        }catch (Exception e){
            return colleges;
        }
    }

    public static ArrayList getAllMajor(){
        ArrayList colleges = new ArrayList();
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from collegemajordict");
            sqlString.execute();
            ResultSet result =  sqlString.getResultSet();
            while(result.next()){
                CollegeStructure college = new CollegeStructure();
                college.setUid(result.getString("uid"));
                college.setCollege(result.getString("college"));
                college.setMajor(result.getString("major"));
                colleges.add(college);
            }
            sqlString.close();
            return colleges;
        }catch (Exception e){
            return colleges;
        }
    }

    public static ArrayList getAllObject(){
        ArrayList objects = new ArrayList();
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select  * from object");
            sqlString.execute();
            ResultSet results = sqlString.getResultSet();
            while( results.next() ){
                ObjectStructure object = new ObjectStructure();
                object.setId(results.getString("oid"));
                object.setObject(results.getString("object"));
                objects.add(object);
            }
            conn.close();
            return objects;
        } catch (Exception e){
            return objects;
        }
    }
}
