package com.filesharesystem.action.file;
/*
 *文件上传实现
 *@author gh
 *@create 2018-04-16 08:50
 */

import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.models.User;
import com.filesharesystem.utils.MD5Util;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.util.Map;
import java.util.UUID;

public class UploadAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private File[] upload;
    private String[] uploadFileName;
    private String[] uploadContentType;
    private String[] fileName;
    private String info;
    private String savePath;

    public String execute() throws Exception {
        User user;
        user = (User) session.get("user");
        for (int i = 0; i < upload.length; i++) {
            String saveName;
            saveName = UUID.randomUUID().toString().replaceAll("-", "");
            if (fileName[i]==null || fileName[i].equals("") || fileName[i].trim().equals("")){
                fileName[i]=uploadFileName[i];
            }
            FileInputStream fileInputStream = new FileInputStream(upload[i]);
            FileOutputStream fileOutputStream = new FileOutputStream(new File(savePath+saveName));
            int count = 0;
            byte[] buffer = new byte[1024];
            while((count = fileInputStream.read(buffer)) > 0){
                fileOutputStream.write(buffer, 0, count);
            }
            com.filesharesystem.models.File file  = new com.filesharesystem.models.File();
            file.setUid(user);
            file.setFileName(fileName[i]);
            file.setFileType(uploadContentType[i]);
            file.setPath(savePath+saveName);
            file.setStatus(1);
            file.setFileType(uploadContentType[i]);
            new FileDAOImpl().saveOrUpdate(file);
            fileInputStream.close();
            fileOutputStream.close();
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

    public File[] getUpload() {
        return upload;
    }

    public void setUpload(File[] upload) {
        this.upload = upload;
    }

    public String[] getUploadFileName() {
        return uploadFileName;
    }

    public void setUploadFileName(String[] uploadFileName) {
        this.uploadFileName = uploadFileName;
    }

    public String[] getUploadContentType() {
        return uploadContentType;
    }

    public void setUploadContentType(String[] uploadContentType) {
        this.uploadContentType = uploadContentType;
    }

    public String[] getFileName() {
        return fileName;
    }

    public void setFileName(String[] fileName) {
        this.fileName = fileName;
    }

    public String getInfo() {
        return info;
    }

    public void setInfo(String info) {
        this.info = info;
    }

    public String getSavePath() {
        return savePath;
    }

    public void setSavePath(String savePath) {
        this.savePath = savePath;
    }
}
