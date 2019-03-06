package CheckCode;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.awt.*;
import java.io.IOException;
import java.util.Random;

@WebServlet(name = "RandomTool")
public class RandomTool  {
    private final static String VALUE = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    public static  String getRandomString(int num) throws Exception{
        StringBuilder builder = new StringBuilder();
        Random random = new Random();
        if (num > 5) {
            throw new Exception("num is limited in 5");
        }
        for (int i = 0; i< num ; i++) {
            int index = random.nextInt(VALUE.length());
            char temp = VALUE.charAt(index);
            builder.append(temp);
        }
        return builder.toString();
    }
    public static Color getRandomColor(){
        Random random = new Random();
        int red = random.nextInt(256);
        int green = random.nextInt(256);
        int blue = random.nextInt(256);
        return new Color(red,green,blue);
    }
}
