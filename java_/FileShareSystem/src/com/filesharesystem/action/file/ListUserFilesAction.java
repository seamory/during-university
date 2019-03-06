package com.filesharesystem.action.file;
/*
 *文件记录
 *@author gh
 *@create 2018-04-12 10:42
 */

import com.filesharesystem.dao.FileDataDAO;
import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.List;
import java.util.Map;

//用于列出用户的文件操作
public class ListUserFilesAction extends ActionSupport implements SessionAware {
    private Map<String, Object> session;
    private String message;
    private List<File> files;


    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        List<File> files;
         if( user == null) {
            message = "抱歉出了点问题,无法获取用户信息";
            return Action.ERROR;
        }
        files = new FileDAOImpl().getFileById(user);
        return Action.SUCCESS;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getMessage() {
        return message;
    }

    public void setFiles(List<File> files) {
        this.files = files;
    }

    public List<File> getFiles() {
        return files;
    }
}
