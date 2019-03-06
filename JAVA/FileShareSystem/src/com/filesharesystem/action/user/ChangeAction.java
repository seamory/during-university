package com.filesharesystem.action.user;
/*
 *用户修改密码
 *@author gh
 *@create 2018-04-12 10:40
 */

import com.filesharesystem.dao.impl.UserDAOImpl;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

public class ChangeAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private String message;
    private String[] password;
    private String email;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        if (!password[0].equals(user.getPassword())){
           return Action.ERROR;
        }
        if (!password[1].equals(password[2])) {
            return Action.ERROR;
        }
        if( password[1] != null && !password[1].equals("") && !password[1].trim().equals("")){
            user.setPassword(password[1]);
        }
        user.setEmail(email);
        new UserDAOImpl().saveOrUpdate(user);
        return Action.SUCCESS;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String[] getPassword() {
        return password;
    }

    public void setPassword(String[] password) {
        this.password = password;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }
}
