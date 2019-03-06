package com.filesharesystem.dao;

public interface BaseDAO {
//    新增或者保存
    boolean saveOrUpdate(Object obj);

//    删除
    boolean delete(Object obj);

//    获取对象
    Object getObject(Class class_, String name);
}
