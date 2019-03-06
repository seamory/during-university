package com.filesharesystem.models;

import java.io.Serializable;
import java.util.Date;

public class User{
    private String uid;
    private String username;
    private String password;
    private String email;
    private int status;
    private int type;
    private Date created_at;
    private Date updated_at;

    public User() {
        // DEFAULT INT 1
        this.status = 1;
        this.type = 1;
        Date date = new Date();
//        createdAt由数据库自动创建
//        this.created_at = date;
        this.updated_at = date;
    }

    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public int getType() {
        return type;
    }

    public void setType(int type) {
        this.type = type;
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
