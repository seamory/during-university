package CheckCode;

import javax.imageio.ImageIO;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.IOException;
import java.util.Random;


public class CheckServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        BufferedImage image = new BufferedImage(100, 40, BufferedImage.TYPE_INT_RGB);
        Graphics graphics = image.getGraphics();
        graphics.setColor(RandomTool.getRandomColor().darker());
        graphics.fillRect(0, 0, 100, 40);
        String value = new String();
        int x1,x2,y1,y2;
        try {
            value = RandomTool.getRandomString(4).toLowerCase();
        } catch (Exception e) {
            e.printStackTrace();
        }

        graphics.setColor(RandomTool.getRandomColor().brighter());
        graphics.setFont(new Font( "宋体",Font.BOLD,26));
        graphics.drawString(value, 20, 20);
        Random random  =new Random();

        for (int i=0; i<2; i++){
            graphics.setColor(RandomTool.getRandomColor());
            x1 = random.nextInt(100);
            y1 = random.nextInt(30);
            x2 = random.nextInt(100);
            y2 = random.nextInt(30);
            graphics.drawLine(x1,y1,x2,y2);
        }
        request.getSession().setAttribute("Check", value.toString());
        HttpSession session = request.getSession();
        session.setAttribute("validate",value);
        ImageIO.write(image, "JPG", response.getOutputStream());
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doPost(request, response);
    }
}
