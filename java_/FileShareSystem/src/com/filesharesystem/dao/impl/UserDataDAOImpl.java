package com.filesharesystem.dao.impl;

import com.filesharesystem.dao.BaseDAO;
import com.filesharesystem.dao.UserDataDAO;
import com.filesharesystem.models.UserData;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.criterion.Restrictions;

public class UserDataDAOImpl extends BaseDAOImpl implements UserDataDAO {
//    使用BaseDao
    public UserData getUserData(String uid) {
        Session session = null;
        Transaction transaction = null;
        UserData userData = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            userData = (UserData) session.createCriteria(UserData.class).
                    add(Restrictions.eq("uid",uid)).
                    list().get(0);
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (session != null) {
                session.close();
            }
        }
        return userData;
    }
}
