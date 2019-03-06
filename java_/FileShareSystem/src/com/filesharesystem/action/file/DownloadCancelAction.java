package com.filesharesystem.action.file;
/*
 *删除文件下载记录
 *@author gh
 *@create 2018-05-30 09:49
 */

import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

public class DownloadCancelAction extends ActionSupport implements SessionAware {
    private Map<String, Object> session;
    private String fid;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        File file = new FileDAOImpl().getFileByFid(fid);
        FileData fileData = new FileDataDAOImpl().getFileDate(file, user, 3);
        new FileDataDAOImpl().delete(fileData);
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
}
