package com.filesharesystem.models;

import java.util.Date;

public class IP {
    private int id;
    private User uid;
    private String ipv4;
    private Date created_at;
    private Date updated_at;

    //    private Set<User> userSet = new HashSet<User>();
    //TODO:未完成，ip和用户的映射
    public IP() {
        Date date = new Date();
//        createdAt由数据库自动创建
        this.created_at = date;
        this.updated_at = date;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public User getUid() {
        return uid;
    }

    public void setUid(User uid) {
        this.uid = uid;
    }

    public String getIpv4() {
        return ipv4;
    }

    public void setIpv4(String ipv4) {
        this.ipv4 = ipv4;
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
