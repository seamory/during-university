package com.filesharesystem.dao.impl;

import com.filesharesystem.dao.BaseDAO;
import com.filesharesystem.dao.FileDataDAO;
import com.filesharesystem.models.File;
import com.filesharesystem.models.FileData;
import com.filesharesystem.models.User;
import com.filesharesystem.utils.SessionUtil;
import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.criterion.Restrictions;

import java.util.List;

public class FileDataDAOImpl extends BaseDAOImpl implements FileDataDAO {
    // BaseDAO默认方法即可
    @Override
    public List<FileData> getFileDateByFID(File fid){
        Session session = null;
        Transaction transaction = null;
        List<FileData> fileData = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileData.class);
            criteria.add(Restrictions.eq("fid", fid));
            criteria.createCriteria("fid");
            fileData = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session !=null) {
                session.close();
            }
        }
        return fileData;
    }

    @Override
    public FileData getFavoriteFileDate(File fid, User uid){
        Session session = null;
        Transaction transaction = null;
        List<FileData> fileDatas = null;
        FileData fileData = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileData.class);
            criteria.add(Restrictions.eq("fid",fid));
            criteria.add(Restrictions.eq("visitorId", uid));
            criteria.createCriteria("fid");
            fileDatas = criteria.list();
            if(fileDatas.get(0)!=null) {
                fileData = fileDatas.get(0);
            }
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return fileData;
    }

    public FileData getFileDate(File fid, User uid, int type){
        Session session = null;
        Transaction transaction = null;
        List<FileData> fileDatas = null;
        FileData fileData = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileData.class);
            criteria.add(Restrictions.eq("fid",fid));
            criteria.add(Restrictions.eq("visitorId", uid));
            criteria.add(Restrictions.eq("type",type));
            criteria.createCriteria("fid");
            fileDatas = criteria.list();
            if(fileDatas.get(0)!=null) {
                fileData = fileDatas.get(0);
            }
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return fileData;
    }

    public List<FileData> getFileDateByUid(User uid){
        Session session = null;
        Transaction transaction = null;
        List<FileData> fileDataList = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileData.class);
            criteria.add(Restrictions.eq("uid", uid));
            criteria.createCriteria("fid");
            fileDataList = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session != null){
                session.close();
            }
        }
        return fileDataList;
    }

    public List<FileData> getUserDownList(User uid) {
        Session session = null;
        Transaction transaction = null;
        List<FileData> fileData = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileData.class);
            criteria.add(Restrictions.eq("visitorId", uid));
            criteria.add(Restrictions.eq("type", 3));
            criteria.createCriteria("fid");
            fileData = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session !=null) {
                session.close();
            }
        }
        return fileData;
    }

    public List<FileData> getUserFavorList(User uid) {
        Session session = null;
        Transaction transaction = null;
        List<FileData> fileData = null;
        try {
            session = SessionUtil.openSession();
            transaction = session.beginTransaction();
            Criteria criteria = session.createCriteria(FileData.class);
            criteria.add(Restrictions.eq("visitorId", uid));
            criteria.add(Restrictions.eq("type", 2));
            criteria.createCriteria("fid");
            fileData = criteria.list();
            transaction.commit();
        } catch (Exception e) {
            e.printStackTrace();
            transaction.rollback();
        } finally {
            if (session !=null) {
                session.close();
            }
        }
        return fileData;
    }
}
