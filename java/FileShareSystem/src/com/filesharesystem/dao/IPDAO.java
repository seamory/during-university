package com.filesharesystem.dao;

import com.filesharesystem.models.IP;
import com.filesharesystem.models.User;

import java.util.List;

public interface IPDAO extends BaseDAO {
    //TODO：见models.IP

//    通过用户uid获取用户的登录ip地址
    List<IP> ipList(User uid);

//    通过ip地址获取用户
    List<IP> uidList(String ip);

//    获取所有的ip信息
    List<IP> getAll();
}
