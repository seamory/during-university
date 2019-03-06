package com.filesharesystem.dao;

import com.filesharesystem.models.User;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.Session;
import org.hibernate.Transaction;

import java.util.ArrayList;
import java.util.List;

public interface UserDAO extends BaseDAO {

//    获取所有用户
    List<User> getUsers();

//    通过用户名获取用户
    User getUserByName(String username);

//    通过用户uid获取用户
    User getUserById(String uid);

//    通过用户名和用户密码获取用户
    User checkUser(String username, String password);
}
