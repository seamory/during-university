package Student;

import Mysql.DatabaseConnection;
import Student.StudentAction;

import javax.print.attribute.standard.MediaSize;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

@WebServlet(name = "StudentServlet", urlPatterns = {"/viewStudent", "/addStudent", "/updateStudent", "/deleteStudent", "/deleteStudents"})
public class StudentServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        request.setCharacterEncoding("utf-8");
        if(request.getRequestURI().endsWith("/viewStudent")){
            RequestDispatcher dispatcher = request.getRequestDispatcher("viewStudentScore.jsp");
            dispatcher.forward(request, response);
        } else if (request.getRequestURI().endsWith("/addStudent")){
            doAddpendStudent(request,response);
        } else if (request.getRequestURI().endsWith("/updateStudent")) {
            doUpdateStudent(request,response);
        } else if (request.getRequestURI().endsWith("/deleteStudent")) {
            try {
                doDeleteStudent(request,response);
            } catch (Exception e) {
                e.printStackTrace();
            }
        } else if (request.getRequestURI().endsWith("/deleteStudents")){
            try {
                doDeleteStudents(request,response);
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doPost(request, response);
    }

    private void doAddpendStudent(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{
        String UUID = request.getParameter("uuid");
        String SNO = request.getParameter("sno");
        String NAME = request.getParameter("name");
        String SEX = request.getParameter("sex");
        String MAJOR = request.getParameter("major");
        String GRADE = request.getParameter("grade");
        String AGE = request.getParameter("age");
        String SCHOOL = request.getParameter("school");
        if (StudentAction.addpendStudent(SNO, NAME, SEX, MAJOR, GRADE, AGE, SCHOOL)){
            response.sendRedirect("index.jsp");
        } else {
            response.sendRedirect("addpendStudent.jsp");
        }
    }

    private void doUpdateStudent(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{
        String UUID = request.getParameter("uuid");
        String SNO = request.getParameter("sno");
        String NAME = request.getParameter("name");
        String SEX = request.getParameter("sex");
        String MAJOR = request.getParameter("major");
        String GRADE = request.getParameter("grade");
        String AGE = request.getParameter("age");
        String SCHOOL = request.getParameter("school");
        if(StudentAction.updateStudent(UUID,SNO, NAME, SEX, MAJOR, GRADE, AGE, SCHOOL)){
            response.sendRedirect("index.jsp");
        } else {
            response.sendRedirect("index.jsp");
        }
    }

    private void doDeleteStudents(HttpServletRequest request, HttpServletResponse response) throws Exception {
        String[] ids = request.getParameterValues("id");
        for(int i = 0; i < ids.length; i++){
            StudentAction.deleteStudent(ids[i]);
        }
        response.sendRedirect("index.jsp");
    }

    private void doDeleteStudent(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException, Exception{
        String UUID = request.getParameter("id");
        if(StudentAction.deleteStudent(UUID)){
            response.sendRedirect("index.jsp");
        } else {
            response.sendRedirect("index.jsp");
        }
    }

}
