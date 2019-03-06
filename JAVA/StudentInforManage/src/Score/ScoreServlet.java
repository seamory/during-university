package Score;

import Common.CommonQuery;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

@WebServlet(name = "ScoreServlet", urlPatterns = {"/addScore", "/changeScore"})
public class ScoreServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        request.setCharacterEncoding("utf-8");
        if (request.getRequestURI().endsWith("/addScore")){
            doAddScore(request,response);
        } else if (request.getRequestURI().endsWith("/changeScore")){
            doUpdateScore(request,response);
        }
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doPost(request, response);
    }

    private void doAddScore(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String object = request.getParameter("object");
        String[] uuid = request.getParameterValues("id");
        String[] score = request.getParameterValues("score");
        for (int i = 0; i<score.length ; i++) {
            System.out.println(uuid[i]);
            System.out.println(score[i]);
            System.out.println(object);
            ScoreAction.addScore(uuid[i], object, score[i]);
        }
        response.sendRedirect("addStudentScore.jsp");
    }

    private void doUpdateScore(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String uuid = request.getParameter("id");
        String object = request.getParameter("object");
        String score = request.getParameter("score");
        if(ScoreAction.updateScore(uuid,object,score)){
            response.sendRedirect("index.jsp");
        } else {
            response.sendRedirect("index.jsp");
        }
    }
}
