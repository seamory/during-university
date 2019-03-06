package com.filesharesystem.action.user;
/*
 *修改预留资料
 *@author gh
 *@create 2018-04-12 10:41
 */

import com.filesharesystem.dao.impl.FileDataDAOImpl;
import com.filesharesystem.dao.impl.UserDataDAOImpl;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.filesharesystem.models.UserData;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionSupport;
import org.apache.struts2.interceptor.SessionAware;

import java.util.Map;

public class ChangeDataAction extends ActionSupport implements SessionAware{

    private Map<String, Object> session;

    private int gender;

    private int age;

    private String birthday;

    private String qq;

    private String phone;

    @Override
    public String execute() throws Exception {
        User user = (User) session.get("user");
        System.out.println(getPhone());
        UserData userData = new UserData();
//        userData = (UserData) new UserDataDAOImpl().getObject(UserData.class, user.getUid());
//        if (userData == null) {
//            userData = new UserData();
//        }
        userData.setUid(user.getUid());
        userData.setGender(getGender());
        userData.setAge(getAge());
        userData.setBirthday(getBirthday());
        userData.setQQ(getQq());
        userData.setPhone(getPhone());
        new UserDataDAOImpl().saveOrUpdate(userData);
        return Action.SUCCESS;
    }

    @Override
    public void setSession(Map<String, Object> session) {
        this.session = session;
    }

    public Map<String, Object> getSession() {
        return session;
    }

    public int getGender() {
        return gender;
    }

    public void setGender(int gender) {
        this.gender = gender;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public String getBirthday() {
        return birthday;
    }

    public void setBirthday(String birthday) {
        this.birthday = birthday;
    }

    public String getQq() {
        return qq;
    }

    public void setQq(String qq) {
        this.qq = qq;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }
}
