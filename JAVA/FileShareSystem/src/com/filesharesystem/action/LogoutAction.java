package com.filesharesystem.action;
/*
 *注销用户
 *@author gh
 *@create 2018-05-30 10:23
 */

import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

public class LogoutAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;

    @Override
    public String execute() throws Exception {
        session.put("user", null);
        return Action.SUCCESS;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    public void setSession(Map<String, Object> session) {
        this.session = session;
    }
}
