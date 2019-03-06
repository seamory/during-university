package com.filesharesystem.dao.impl;

import com.filesharesystem.dao.IPDAO;
import com.filesharesystem.models.IP;
import com.filesharesystem.models.User;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.criterion.Restrictions;
import org.hibernate.criterion.SimpleExpression;

import java.util.List;

public class IPDAOImpl extends BaseDAOImpl implements IPDAO {
//TODO：见models.IP

    @Override
    public List<IP> ipList(User uid){
        Session session = null;
        Transaction transaction = null;
        List<IP> ipList = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(IP.class);
            criteria.add(Restrictions.eq("uid", uid));
            criteria.createCriteria("uid");
            ipList = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null) session.close();
        }
        return ipList;
    }

    @Override
    public List<IP> uidList(String ip) {
        Session session = null;
        Transaction transaction = null;
        List<IP> ipList = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(IP.class);
            criteria.add(Restrictions.eq("ipv4", ip));
            criteria.createCriteria("uid");
            ipList = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null) session.close();
        }
        return ipList;
    }

    @Override
    public List<IP> getAll() {
        Session session = null;
        Transaction transaction = null;
        List<IP> ipList = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(IP.class);
            criteria.createCriteria("uid");
            ipList = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null) {
                session.close();
            }
        }
        return ipList;
    }
}
