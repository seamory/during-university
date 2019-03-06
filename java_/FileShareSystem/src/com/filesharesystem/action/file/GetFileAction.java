/*
 *拉取文件信息
 *@author Nikoace
 *@create 2
 */
package com.filesharesystem.action.file;

import com.filesharesystem.dao.impl.FileDAOImpl;
import com.filesharesystem.models.File;
import com.filesharesystem.models.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionContext;
import com.opensymphony.xwork2.ActionSupport;

import java.util.List;

public class GetFileAction extends ActionSupport
{

    private static final long serialVersionUID = 8698717426937032941L;
    private List<File> files;
    private User user;

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public List <File> getFiles() {
        return files;
    }

    public void setFiles(List <File> files) {
        this.files = files;
    }

    @Override
    public String execute() throws Exception {
        List<File> files;
        files = new FileDAOImpl ().getFiles ();
        int countfiles = files.size ();
        ActionContext.getContext ().put ( "count",countfiles );
        // TODO: 2018/5/16 显示上传用户 
        ActionContext.getContext ().put ( "list",files );
        return Action.SUCCESS;
    }
}
