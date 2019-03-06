package CheckCode;

import Admin.AdminAction;
import Admin.AdminStructure;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;
import java.io.PrintWriter;

public class LoginServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doGet(request,response);
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        HttpSession session = request.getSession();
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        String CheckCode = request.getParameter("CheckCode");
        String value = (String) session.getAttribute("validate");
        AdminStructure admin = AdminAction.getOneAdmin(username,password);
        if (value == null || value.equals("")||value.trim().equals("")){
            System.out.println("验证码生成错误");
        }


        String info;
        System.out.println(value);
        System.out.println(CheckCode);
        System.out.println(username);
        System.out.println(password);
        System.out.println(admin.getUsername());
        System.out.println(admin.getPassword());

        if (CheckCode.equals(value) && admin.getUsername() != null && username.equals( admin.getUsername() ) && password.equals( admin.getPassword() )){
            System.out.println("验证正确");
            //request.getRequestDispatcher("/index.jsp").forward(request,response);
            response.sendRedirect("/index.jsp");
        } else {
            if ( !CheckCode.equals(value) ){
                info = "1";
                response.sendRedirect("/adminLogin.jsp?info=" + info);
                return;
            }
            if ( admin.getUsername() == null ){
                info = "2";
                response.sendRedirect("/adminLogin.jsp?info=" + info);
                return;
            }
        }
    }

}
