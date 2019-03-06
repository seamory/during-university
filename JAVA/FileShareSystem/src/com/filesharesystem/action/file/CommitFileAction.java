package com.filesharesystem.action.file;

import com.filesharesystem.dao.FileDAO;
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

import java.util.Map;

/**
 * 上传文件，涉及User/File/FileData
 *
 * @author KuoYu
 * @version 1.0
 * @see User
 * @see File,FileData
 */


public class CommitFileAction extends ActionSupport implements SessionAware {

    private static final long serialVersionUID = 8698717742693703294L;
    private Map<String, Object> session;
    private String fid;
    private int level;
    private String commit;

    @Override
    public String execute() {
        User user = (User) session.get("user");
        FileCommit fileCommit = new FileCommitDAOImpl().getFileCommit(fid, user.getUid());
        File file = new FileDAOImpl().getFileByFid(fid);
        if (file == null) {
            addActionError("文件信息获取失败");
        }
        fileCommit.setFid(file);
        fileCommit.setVisitorId(user);
        fileCommit.setLevel(level);
        fileCommit.setCommit(commit);
        new FileCommitDAOImpl().saveOrUpdate(fileCommit);
        return Action.SUCCESS;
    }

    public static long getSerialVersionUID() {
        return serialVersionUID;
    }

    public void setFid(String fid) {
        this.fid = fid;
    }

    public String getFid() {
        return fid;
    }

    public void setCommit(String commit) {
        this.commit = commit;
    }

    public String getCommit() {
        return commit;
    }

    public void setLevel(int level) {
        this.level = level;
    }

    public int getLevel() {
        return level;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }
}
