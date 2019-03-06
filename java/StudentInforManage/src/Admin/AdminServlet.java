package Admin;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

/**
 * Created with IntelliJ IDEA.
 * User: KuoYu
 * Site: pythonic.site
 * Date: 2017-11-22
 * Time: 22:11
 * Description:
 */
@WebServlet(name = "AdminServlet", urlPatterns = {"/addAdmin", "/updateAdmin", "/deleteAdmin"})
public class AdminServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        request.setCharacterEncoding("utf-8");
        if (request.getRequestURI().endsWith("/addAdmin")){
            doAddAdmin(request,response);
        } else if (request.getRequestURI().endsWith("/updateAdmin")) {
            doUpdateAdmin(request,response);
        } else if (request.getRequestURI().endsWith("/deleteAdmin")) {
            doDeleteAdmin(request,response);
        }
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doPost(request, response);
    }

    private void doAddAdmin(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        if(AdminAction.appendAdmin(username, password)){
            response.sendRedirect("viewAdmin.jsp");
        } else {
            response.sendRedirect("addAdmin.jsp");
        }
    }

    private void doUpdateAdmin(HttpServletRequest request,  HttpServletResponse response) throws IOException {
        String id = request.getParameter("id");
        String password = request.getParameter("password");
        if(AdminAction.updateAdmin(id, password)){
            response.sendRedirect("viewAdmin.jsp");
        } else {
            response.sendRedirect("viewAdmin.jsp");
        }
    }

    private void doDeleteAdmin(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String id =  request.getParameter("id");
        if(AdminAction.deleteAdmin(id)){
            response.sendRedirect("viewAdmin.jsp");
        } else {
            response.sendRedirect("viewAdmin.jsp");
        }
    }
}
