package com.filesharesystem.action;

import com.filesharesystem.dao.UserDAO;
import com.filesharesystem.dao.impl.IPDAOImpl;
import com.filesharesystem.dao.impl.UserDAOImpl;
import com.filesharesystem.models.IP;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionContext;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.ServletActionContext;
import org.apache.struts2.interceptor.SessionAware;

import java.util.HashSet;
import java.util.Map;

/**
 * 登陆
 *
 * @author KuoYu
 * @version 1.0
 * @see User
 */
public class SignInAction extends ActionSupport implements SessionAware {

    private static final long serialVersionUID = 3651532609841503307L;
    private UserDAO dao = new UserDAOImpl();
    private String username;
    private String password;
    private String verify;
    private Map<String, Object> session;

    public String execute() {
        IP ip = new IP();
        String ipAddress = ServletActionContext.getRequest().getRemoteAddr();
        String  checkCode = (String) session.get("checkCode");
        System.out.println("获取验证码"+checkCode);
        System.out.println("IP地址"+ipAddress);
        if(this.username == null || this.username.equals("") || this.username.trim().equals("")){
            this.addFieldError("username", "用户名不能为空");
        }
        if(this.password == null || this.password.equals("") || this.password.trim().equals("")){
            this.addFieldError("password","用户密码不能为空");
        }
        if(!verify.equals(checkCode)){
            addActionError("验证码错误");
        }
        User user = dao.checkUser(username, password);
        if (user != null) {
            session.put ( "user",user );
            ActionContext.getContext ().setSession ( session );
            System.out.println("用户名"+user.getUsername());
            ip.setUid(user);
            ip.setIpv4(ipAddress);
            new IPDAOImpl().saveOrUpdate(ip);
            if ( user.getType() == 0 ) {
                return "admin";
            } else {
                return "user";
            }
        } else {
            addActionError("用户鉴权失败");
            return Action.ERROR;
        }
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    public static long getSerialVersionUID() {
        return serialVersionUID;
    }

    public UserDAO getDao() {
        return dao;
    }

    public void setDao(UserDAO dao) {
        this.dao = dao;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getPassword() {
        return password;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getUsername() {
        return username;
    }

    public void setVerify(String verify) {
        this.verify = verify;
    }

    public String getVerify() {
        return verify;
    }
}
