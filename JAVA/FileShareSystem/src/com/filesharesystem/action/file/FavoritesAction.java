package com.filesharesystem.action.file;
/*
 *文件收藏
 *@author gh
 *@create 2018-04-11 19:50
 */

import com.filesharesystem.dao.FileDataDAO;
import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

//用于用户添加收藏
public class FavoritesAction extends ActionSupport implements SessionAware{
    private Map<String, Object> session;
    private String fid;

    @Override
    public String execute() throws Exception {
        FileData fileData;
        User user = (User) session.get("user");
        File fileBean = new FileDAOImpl().getFileByFid(fid);
        fileData = new FileDataDAOImpl().getFavoriteFileDate(fileBean,user);
        System.out.println("收藏文件" + user.getUsername() + fileBean.getFileName());
        if (fileData == null || fileData.getType() == 3) {
            fileData = new FileData();
            fileData.setVisitorId(user);
            fileData.setFid(fileBean);
            fileData.setType(2);
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
}
