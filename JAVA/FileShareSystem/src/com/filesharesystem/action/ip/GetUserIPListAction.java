package com.filesharesystem.action.ip;
/*
 *用户用于获取登录情况
 *@author gh
 *@create 2018-04-17 09:17
 */

import com.filesharesystem.dao.impl.IPDAOImpl;
import com.filesharesystem.models.IP;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.List;
import java.util.Map;

public class GetUserIPListAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private List<IP> ipList;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        ipList = new IPDAOImpl().ipList(user);
        return Action.SUCCESS;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public Map<String, Object> getSession() {
        return session;
    }
}
