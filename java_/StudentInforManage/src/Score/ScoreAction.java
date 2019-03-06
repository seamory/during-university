package Score;

import Mysql.DatabaseConnection;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class ScoreAction {
    public static boolean addScore(String UUID, String object, String score){
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("insert into student_score(uuid, object, score) values (?, ?, ?)");
            sqlString.setString(1,UUID);
            sqlString.setString(2,object);
            sqlString.setString(3,score);
            sqlString.execute();
            conn.close();
            return true;
        } catch (Exception e){
            return false;
        }
    }

    public static boolean updateScore(String uuid, String object, String score){
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("update student_score set score=? where uuid=? and object=?");
            sqlString.setString(1,score);
            sqlString.setString(2,uuid);
            sqlString.setString(3,object);
            sqlString.execute();
            conn.close();
            return true;
        } catch (Exception e) {
            return false;
        }
    }

    public static ArrayList getOneScore(String UUID){
        ArrayList scores = new ArrayList();
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("SELECT * from student_score where uuid = ?");
            sqlString.setString(1, UUID);
            sqlString.execute();
            ResultSet result = sqlString.getResultSet();
            while ( result.next() ){
                ScoreStructure score = new ScoreStructure();
                score.setId( result.getString("uuid") );
                score.setObject( result.getString("object") );
                score.setScore( result.getString("score") );
                scores.add(score);
            }
            conn.close();
            return scores;
        } catch (Exception e){
            return scores;
        }
    }
}
