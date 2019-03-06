package com.filesharesystem.action.file;
/*
 *用户操作(收藏,浏览,下载)的文件
 *@author gh
 *@create 2018-04-17 08:41
 */

import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;
import org.hibernate.Transaction;

import java.util.List;
import java.util.Map;

public class ListUserRecordAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private String message;
    private List<FileData> fileDataList;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        fileDataList = new FileDataDAOImpl().getFileDateByUid(user);
        return Action.SUCCESS;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getMessage() {
        return message;
    }

    public List<FileData> getFileDataList() {
        return fileDataList;
    }

    public void setFileDataList(List<FileData> fileDataList) {
        this.fileDataList = fileDataList;
    }
}
