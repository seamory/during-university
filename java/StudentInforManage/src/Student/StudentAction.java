package Student;

import Mysql.DatabaseConnection;
import org.omg.Messaging.SYNC_WITH_TRANSPORT;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Savepoint;
import java.util.ArrayList;

public class StudentAction {
    java.sql.Connection conn = null;

    /*
    @ 添加信息
    @ uuid sno name sex major grade
     */
    public static boolean addpendStudent(String sno, String name, String sex, String major, String grade, String age, String school) {
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("insert into student (`sno`, `name`, `age`, `grade`, `school`, `major`, `sex`) values(?,?,?,?,?,?,?)");

            sqlString.setString(1, sno);
            sqlString.setString(2, name);
            sqlString.setString(3, age);
            sqlString.setString(4, grade);
            sqlString.setString(5, school);
            sqlString.setString(6, major);
            sqlString.setString(7, sex);

            sqlString.execute();
            conn.close();

            return true;
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
    }

    /*
    @ 更新信息
    @ uuid sno name sex major grade
    */
    public static boolean updateStudent(String UUID, String sno, String name, String sex, String major, String grade, String age, String school) {
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("update student set sno=?, name=?, sex=?, major=?, grade=?, age=?, school=? where uuid=?");

            sqlString.setString(1, sno);
            sqlString.setString(2, name);
            sqlString.setString(3, sex);
            sqlString.setString(4, major);
            sqlString.setString(5, grade);
            sqlString.setString(6, age);
            sqlString.setString(7, school);
            sqlString.setString(8, UUID);

            sqlString.execute();
            conn.close();

            return true;
        } catch (Exception e) {
            System.out.println(UUID);
            System.out.println(sno);
            System.out.println(name);
            System.out.println(sex);
            System.out.println(major);
            System.out.println(grade);
            System.out.println(age);
            System.out.println(school);
            return false;
        }
    }

    /*
    @ 删除信息
    @ uuid sno name sex major grade
     */
    public static boolean deleteStudent(String UUID) throws Exception{
        java.sql.Connection conn = new DatabaseConnection().getConnection();
        Savepoint sp = conn.setSavepoint(); // 设置事务回滚点
          //将自动提交设置为false
        try {
            conn.setAutoCommit(false);
            PreparedStatement sqlString = conn.prepareStatement("delete from student_score where uuid = ?");
            sqlString.setString(1, UUID);
            sqlString.executeUpdate();
            sqlString = conn.prepareStatement("delete from student where uuid=?");
            sqlString.setString(1, UUID);
            sqlString.executeUpdate();
            conn.commit();
            conn.setAutoCommit(true);
            conn.close();
            return true;
        } catch (Exception e) {
            conn.rollback(sp);
            conn.commit();
            conn.setAutoCommit(true);
            return false;
        }
    }

    /*
    @ 查询全部学生
    @ UUID sno name sex major grade
     */
    public static ArrayList getAllStudent(){
        ArrayList students = new ArrayList();
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from student order by sno asc");
            sqlString.execute();
            ResultSet result = sqlString.getResultSet();
            while(result.next()){
                Student.StudentStructure student = new Student.StudentStructure();
                student.setUuid(result.getString("uuid"));
                student.setSno(result.getString("sno"));
                student.setName(result.getString("name"));
                student.setMajor(result.getString("major"));
                student.setGrade(result.getInt("grade"));
                student.setSex(result.getString("sex"));
                student.setSchool(result.getString("school"));
                student.setAge(result.getInt("age"));
                students.add(student);
            }
            conn.close();
            return students;
        }catch (Exception e){
            return students;
        }
    }

    /*
    @ 按学号查询单个学生
    @ uuid sno name sex major grade
     */
    public static Student.StudentStructure getOneStudent(String uuid){
        Student.StudentStructure student = new Student.StudentStructure();
        try{
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from student where uuid=?");
            sqlString.setString(1,uuid);
            sqlString.execute();
            ResultSet result = sqlString.getResultSet();
            while( result.next() ) {
                student.setUuid(result.getString("uuid"));
                student.setSno(result.getString("sno"));
                student.setName(result.getString("name"));
                student.setSex(result.getString("sex"));
                student.setMajor(result.getString("major"));
                student.setGrade(result.getInt("grade"));
                student.setSchool(result.getString("school"));
                student.setAge(result.getInt("age"));
            }
            conn.close();
            return student;
        }catch (Exception e){
            return student;
        }
    }

    // Get student by grade, college, major
    public static ArrayList getStudentByGCM(String grade, String college, String major){
        ArrayList students = new ArrayList();
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from student where grade=? and school=? and major=? order by sno asc");
            sqlString.setString(1,grade);
            sqlString.setString(2,college);
            sqlString.setString(3,major);
            sqlString.execute();
            ResultSet result = sqlString.getResultSet();
            while ( result.next() ){
                Student.StudentStructure student = new Student.StudentStructure();
                student.setUuid(result.getString("uuid"));
                student.setSno(result.getString("sno"));
                student.setName(result.getString("name"));
                student.setMajor(result.getString("major"));
                student.setGrade(result.getInt("grade"));
                student.setSex(result.getString("sex"));
                student.setSchool(result.getString("school"));
                student.setAge(result.getInt("age"));
                students.add(student);
            }
            conn.close();
            return students;
        } catch (Exception e) {
            return students;
        }
    }

    public static ArrayList getStudentByCondition(String search, String field){
        ArrayList students = new ArrayList();
        try {
            java.sql.Connection conn = new DatabaseConnection().getConnection();
            PreparedStatement sqlString = conn.prepareStatement("select * from student");
            switch ( search ){
                case "sno":
                    sqlString = conn.prepareStatement("select * from student where sno=?");break;
                case "name":
                    sqlString = conn.prepareStatement("select * from student where name=?");break;
                case "age":
                    sqlString = conn.prepareStatement("select * from student where age=?");break;
                case "grade":
                    sqlString = conn.prepareStatement("select * from student where grade=?");break;
                case "school":
                    sqlString = conn.prepareStatement("select * from student where school=?");break;
                case "major":
                    sqlString = conn.prepareStatement("select * from student where major=?");break;
                case "sex":
                    sqlString = conn.prepareStatement("select * from student where sex=?");break;
            }
            sqlString.setString(1,field);
            sqlString.execute();
            ResultSet result =  sqlString.getResultSet();
            while( result.next() ){
                Student.StudentStructure student = new Student.StudentStructure();
                student.setUuid(result.getString("uuid"));
                student.setSno(result.getString("sno"));
                student.setName(result.getString("name"));
                student.setMajor(result.getString("major"));
                student.setGrade(result.getInt("grade"));
                student.setSex(result.getString("sex"));
                student.setSchool(result.getString("school"));
                student.setAge(result.getInt("age"));
                students.add(student);
            }
            conn.close();
            return students;
        } catch ( Exception e ) {
            return students;
        }
    }

}