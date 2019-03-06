package com.filesharesystem.models;

import java.util.Date;

public class FileCommit {
    private String id;
    private User visitorId;
    private File fid;
    private int level;
    private String commit;
    private Date created_at;
    private Date updated_at;

    public FileCommit() {
        Date date = new Date();
//        createdAt由数据库自动创建
//        this.created_at = date;
        this.updated_at = date;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public User getVisitorId() {
        return visitorId;
    }

    public void setVisitorId(User visitorId) {
        this.visitorId = visitorId;
    }

    public File getFid() {
        return fid;
    }

    public void setFid(File fid) {
        this.fid = fid;
    }

    public int getLevel() {
        return level;
    }

    public void setLevel(int level) {
        this.level = level;
    }

    public String getCommit() {
        return commit;
    }

    public void setCommit(String commit) {
        this.commit = commit;
    }

    public Date getCreated_at() {
        return created_at;
    }

    public void setCreated_at(Date created_at) {
        this.created_at = created_at;
    }

    public Date getUpdated_at() {
        return updated_at;
    }

    public void setUpdated_at(Date updated_at) {
        this.updated_at = updated_at;
    }
}
