package com.filesharesystem.action.file;
/*
 *文件浏览描述
 *@author gh
 *@create 2018-04-12 08:50
 */

import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

// TODO: 18.4.12 尽可能尝试通过拦截器方式实现
// 用于实现用户的浏览记录
public class VisitAction extends ActionSupport implements SessionAware {
    private Map<String, Object> session;
    private String fid;
    private String message;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        File file = (File) new FileDataDAOImpl().getObject(File.class, fid);
        FileDataDAOImpl fileDataDAO = new FileDataDAOImpl();
        if (user == null) {
            message = "抱歉，用户没有访问权限。";
            return Action.ERROR;
        }
        if (file == null) {
            message = "抱歉出了点问题，文件浏览信息无法记录。";
            return Action.ERROR;
        }
        FileData fileData = new FileData();
        fileData.setVisitorId(user);
        fileData.setFid(file);
        fileData.setType(2);
        fileDataDAO.saveOrUpdate(fileData);
        return Action.SUCCESS;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public void setFid(String fid) {
        this.fid = fid;
    }

    public String getFid() {
        return fid;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getMessage() {
        return message;
    }
}
