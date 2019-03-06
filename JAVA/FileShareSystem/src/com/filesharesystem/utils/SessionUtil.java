package com.filesharesystem.utils;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;
import org.hibernate.service.ServiceRegistry;
import org.hibernate.service.ServiceRegistryBuilder;

// TODO: 思考是使用BaseDAO还是创建Utils？
// 使用Utils,创建工厂，保持DAO层的整洁
public class SessionUtil {
    private static SessionFactory factory;

    static {
        Configuration configuration = new Configuration().configure();
        ServiceRegistry serviceRegistry = new ServiceRegistryBuilder()
                .applySettings(configuration.getProperties())
                .buildServiceRegistry();
        factory = configuration.buildSessionFactory(serviceRegistry);
    }

    public static Session openSession() {
        Session session = factory.openSession();
        return session;
    }

    public static void closeSession(Session session) throws Exception{
        try {
            if (session != null) {
                session.close();
            }
        } finally {
            // TODO: log here
            // 用户 :
            System.out.println("session log");
        }
    }
}
