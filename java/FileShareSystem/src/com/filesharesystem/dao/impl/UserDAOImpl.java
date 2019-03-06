package com.filesharesystem.dao.impl;

import com.filesharesystem.dao.UserDAO;
import com.filesharesystem.models.User;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.*;
import org.hibernate.cfg.Configuration;
import org.hibernate.criterion.Restrictions;
import org.hibernate.criterion.SimpleExpression;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;


public class UserDAOImpl extends BaseDAOImpl implements UserDAO {

    /*
    * 获得所有用户，取得用户列表
    * 用于管理员操作
    */
    public List<User> getUsers() {
        Session session = null;
        Transaction transaction = null;
        List<User> users = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(User.class);
            users = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return users;
    }

    /*
    * 通过用户名查询数据
    * 用于查询用户下关联的文件列表
    */
    public User getUserByName(String username){
        Session session = null;
        Transaction transaction = null;
        User user = new User();
        List<User> users;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(User.class);
            criteria.add(Restrictions.eq("username", username));
            users = criteria.list();
            if( users.toArray().length == 1)
                user = users.get(0);
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return user;
    }

    /*
    * 通过用户uid查询用户
    * 用于管理员对用户的操作
    * 用于用户进行资料的修改
    */
    public User getUserById(String uid){
        Session session = null;
        Transaction transaction = null;
        User user = new User();
        List<User> users;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(User.class);
            criteria.add(Restrictions.eq("uid", uid));
            users = criteria.list();
            if( users.toArray().length == 1)
                user = users.get(0);
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return user;
    }

    /*
    * 用户检查
    * 用于登陆
    */
    public User checkUser(String username, String password){
        Session session = null;
        Transaction transaction = null;
        User user = null;
        List<User> users;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(User.class);
            criteria.add(Restrictions.eq("username", username));
            criteria.add(Restrictions.eq("password", password));
            users = criteria.list();
            if( users.toArray().length == 1)
                user = users.get(0);
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return user;
    }
    /*    public static void main(String[] args) {
        UserDAO test = new UserDAOImpl();
        List<User> users = test.getUsers();
        User user = test.checkUser("laisicheng","123456");
        Iterator<User> iterator = users.iterator();

        while (iterator.hasNext()){
            User one = iterator.next();
            System.out.println(one.getUsername());
        }
    }*/
}

