package com.filesharesystem.action.file;
/*
 *用于设置文件是公开还是私有
 *@author gh
 *@create 2018-05-07 09:25
 */

import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

public class SetFileTypeAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private String fid;
    private String fileName;
    private int type;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        File file = new FileDAOImpl().getFileByFid(fid);
        file.setFileName(fileName);
        file.setType(type);
        new FileDAOImpl().saveOrUpdate(file);
        return super.execute();
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    public void setFid(String fid) {
        this.fid = fid;
    }

    public String getFid() {
        return fid;
    }

    public void setType(int type) {
        this.type = type;
    }

    public int getType() {
        return type;
    }

    public String getFileName() {
        return fileName;
    }

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }
}
