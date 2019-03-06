package com.filesharesystem.dao.impl;

import com.filesharesystem.dao.BaseDAO;
import com.filesharesystem.models.IP;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.springframework.web.context.request.SessionScope;

import java.util.List;
import java.util.Set;

public class BaseDAOImpl implements BaseDAO {
    /**
     * 传入obj,根据obj的类型进行<b>保存和更改</b>
     *
     * @param obj
     * @return
     */
    @Override
    public boolean saveOrUpdate(Object obj) {
        boolean ret = false;
        Session session = null;
        Transaction transaction = null;
        try {
            session = SessionUtil.openSession();
            transaction =  session.beginTransaction();
            session.saveOrUpdate(obj.getClass().getName(), obj);
            transaction.commit();
            ret = true;
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null) {
               session.close();
            }
        }

        return ret;
    }

    /**
     * 传入obj 根据obj的类型进行删除
     *
     * @param obj
     * @return
     */
    @Override
    public boolean delete(Object obj) {
        boolean ret = false;
        Session session = null;
        Transaction transaction = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            session.delete(obj.getClass().getName(), obj);
            System.out.println(obj.getClass().getName());
            transaction.commit();
            ret = true;
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null) {
                session.close();
            }
        }
        return ret;

    }

    /**
     * 根据 类型 和 serializeUID 进行获取不常用
     *
     * @param class_
     * @param name
     * @return
     */
    @Override
    public Object getObject (Class class_, String name) {
        Object obj= new Object();
        Session session = null;
        Transaction transaction = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            obj = session.get(class_.getClass(), name);
            SessionUtil.closeSession(session);
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if ( session != null ){
                session.close();
            }
        }
        return obj;
    }



}
