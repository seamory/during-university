package com.filesharesystem.action.file;
/*
 *文件下载实现
 *@author gh
 *@create 2018-04-12 10:40
 */


import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.io.File;
import java.io.FileInputStream;
import java.io.InputStream;
import java.util.Map;

//用于用户下载文件的时候进行记录
public class DownloadAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private String fid;

    private InputStream inputStream;

    private String filePath;

    private String contentType;

    private String inputName;

    public String execute() throws Exception {
        User user = (User) session.get("user");
        com.filesharesystem.models.File file = new FileDAOImpl().getFileByFid(fid);
        String path = file.getPath();
        contentType = file.getFileType();
        inputName = file.getFileName();
        if (!new File(path).exists()){
            return Action.ERROR;
        }
        inputStream = new FileInputStream(new File(path));
        com.filesharesystem.models.File fileBean = new FileDAOImpl().getFileByFid(fid);
        FileData fileData = new FileDataDAOImpl().getFavoriteFileDate(fileBean, user);
        if(fileData == null || fileData.getType() == 2) {
            fileData = new FileData();
            fileData.setFid(fileBean);
            fileData.setType(3);
            fileData.setVisitorId(user);
            new FileDataDAOImpl().saveOrUpdate(fileData);
        }
        return Action.SUCCESS;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public String getFid() {
        return fid;
    }

    public void setFid(String fid) {
        this.fid = fid;
    }

    public InputStream getInputStream() {
        return inputStream;
    }

    public void setInputStream(InputStream inputStream) {
        this.inputStream = inputStream;
    }

    public String getFilePath() {
        return filePath;
    }

    public void setFilePath(String filePath) {
        this.filePath = filePath;
    }

    public String getContentType() {
        return contentType;
    }

    public void setContentType(String contentType) {
        this.contentType = contentType;
    }

    public String getInputName() {
        return inputName;
    }

    public void setInputName(String inputName) {
        this.inputName = inputName;
    }
}
