//package com.filesharesystem.models;
//
//import com.filesharesystem.dao.UserDAO;
//import com.filesharesystem.dao.UserDataDAO;
//import com.filesharesystem.dao.impl.UserDAOImpl;
//import com.filesharesystem.dao.impl.UserDataDAOImpl;
//import com.filesharesystem.utils.SessionUtil;
//import com.opensymphony.xwork2.Action;
//import org.hibernate.Session;
//import org.hibernate.SessionFactory;
//import org.hibernate.Transaction;
//import org.hibernate.cfg.Configuration;
//import org.hibernate.service.ServiceRegistry;
//import org.hibernate.service.ServiceRegistryBuilder;
//
//import java.util.Date;
//import java.util.List;
//
//public class TestMain {
//    private Session session;
//    private SessionFactory factory;
//    private Transaction transaction;
//
//    public static void main(String[] args) {
////        Session session = SessionUtil.openSession();
////        List<User> uList = session
////                .createQuery("from User as u where u.username=:name")
////                .setString("name","111").list();
////        if(uList.isEmpty()){
////            System.out.println("empty");
////        }else{
////            System.out.println(uList.get(0).getUsername());
//        UserDAO userDAO = new UserDAOImpl();
//        UserDataDAO userDataDAO = new UserDataDAOImpl();
//        String name = "23423423";
//        if (userDAO.getUser(name) != null) {
//            System.out.println(Action.ERROR);
//        } else {
//            User user = new User();
//            user.setUsername(name);
//            user.setPassword("2222");
//            user.setEmail("123123");
//            userDAO.save_or_update(user);
//            System.out.println(Action.SUCCESS);
//        }
//    }
//
//    public static void getobject(Object obj) {
//        System.out.println(obj.getClass().getName());
//    }
//
//    public void createUser() {
//        User user = new User();
//        Session session = getSession();
//        user.setUsername("111");
//        user.setPassword("2222");
//        user.setEmail("123123");
//
//        session.save(user);
//        commit();
//    }
//
//    // 提交评论， file fileCommit user
//    public void commitComment() {
//        Date date = new Date();
//        Session session = getSession();
//        File file = (File) session.load(File.class, "f6f17c126289fe29016289fe2b160000");
//        FileCommit fileCommit = new FileCommit();
//        User user = (User) session.load(User.class, "40289481628928020162892803cd0000");
//        fileCommit.setCommit("this is test");
//        fileCommit.setFid(file);
//        session.save(fileCommit);
//        commit();
//    }
//
//    /**
//     * 提交文件, file filedata user
//     */
//    public void commitFile() {
//        Date date = new Date();
//        Session session = getSession();
//        File file = new File();
//        FileData fileData = new FileData();
//        User user = (User) session.load(User.class, "40289481628928020162892803cd0000");
//        file.setFileName("CommitFile");
//        file.setFileType("context/text");
//        file.setUid(user);
//        fileData.setVisitorId(user);
//        fileData.setAuthorId(user);
//        fileData.setFid(file);
//        session.save(file);
//        session.save(fileData);
//        commit();
//    }
//
//    public TestMain() {
//        Configuration configuration = new Configuration().configure();
//        ServiceRegistry serviceRegistry = new ServiceRegistryBuilder()
//                .applySettings(configuration.getProperties())
//                .buildServiceRegistry();
//        factory = configuration.buildSessionFactory(serviceRegistry);
//    }
//
//    public Session getSession() {
//        try {
//            session = factory.openSession();
//            transaction = session.beginTransaction();
//        } catch (Exception e) {
//            e.printStackTrace();
//            transaction.rollback();
//        }
//        return session;
//    }
//
//    public void commit() {
//        if (session != null && transaction != null) {
//            transaction.commit();
//        } else {
//            //TODO: log here
//        }
//    }
//
//    public void closeSession() {
//        if (session != null) {
//            session.close();
//        } else {
//            // TODO: log here
//        }
//    }
//}
