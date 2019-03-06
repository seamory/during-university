package com.filesharesystem.utils;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.util.Date;

public class MD5Util {

    public static String getUUID(String keyName){
        String uuid = null;
        try {
            MessageDigest md5 = MessageDigest.getInstance("md5");
            md5.update((keyName + DateUtil.getDatetime()).getBytes());
            uuid = new BigInteger(1,md5.digest()).toString();
        } catch (Exception e){
            e.printStackTrace();
            System.out.println(keyName + "UUID生成错误");
        }
        return uuid;
    }

    public static String md5(){
        String md5Encoder = null;
        try {
            MessageDigest md5 = MessageDigest.getInstance("md5");
            md5.update(DateUtil.getDatetime().getBytes());
            md5Encoder = new BigInteger(1,md5.digest()).toString();
        } catch (Exception e){
            e.printStackTrace();
        } finally {
//            todo record to log
            System.out.println("MD5加密错误");
        }
        return md5Encoder;
    }
}
