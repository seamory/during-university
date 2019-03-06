package com.filesharesystem.action.file;
/*
 *文件取消收藏
 *@author gh
 *@create 2018-04-11 20:10
 */

import com.filesharesystem.dao.FileDataDAO;
import com.filesharesystem.dao.impl.FileCommitDAOImpl;
import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.FileCommit;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.List;
import java.util.Map;


//用于用户取消收藏
public class FavoritesCancelAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private String fid;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        System.out.println(fid);
        File file = new FileDAOImpl().getFileByFid(fid);
        FileData fileData = new FileDataDAOImpl().getFileDate(file, user, 2);
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
