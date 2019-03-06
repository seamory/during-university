package com.filesharesystem.dao.impl;
/*
 *文件等级评定和文件评论
 *@author gh
 *@create 2018-04-11 20:35
 */

import com.filesharesystem.dao.FileCommitDAO;
import com.filesharesystem.models.FileCommit;
import com.filesharesystem.models.FileData;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.criterion.Restrictions;

import java.util.List;

public class FileCommitDAOImpl extends BaseDAOImpl implements FileCommitDAO{

    public List<FileCommit> getFileCommitByFID(String fid) {
        Session session = null;
        Transaction transaction = null;
        List<FileCommit> fileCommit = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileCommit.class);
            criteria.add(Restrictions.eq("fid", fid));
            fileCommit = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session !=null) {
                session.close();
            }
        }
        return fileCommit;
    }

    public FileCommit getFileCommit(String fid, String uid){
        Session session = null;
        Transaction transaction = null;
        List<FileCommit> fileCommitList = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileCommit.class);
            criteria.add(Restrictions.eq("fid",fid));
            criteria.add(Restrictions.eq("visitorid",uid));
            fileCommitList = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null) {
                session.close();
            }
        }
        return fileCommitList.get(0);
    }
}
