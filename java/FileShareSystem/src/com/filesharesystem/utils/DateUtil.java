package com.filesharesystem.utils;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

public class DateUtil {
    private static Date date = new Date();

    public static String getDatetime(){

        SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy.MM.dd HH:mm:ss.sss");
        return simpleDateFormat.format(date);
    }
}
