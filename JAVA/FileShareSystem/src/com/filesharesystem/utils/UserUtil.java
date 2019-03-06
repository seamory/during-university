package com.filesharesystem.utils;

import java.util.HashMap;
import java.util.Map;

public class UserUtil {
    Map<Integer, String> mapping = new HashMap<Integer, String>() {
        {
            put(1, "error");
            put(2, "ok");
            put(3, "baned");
        }
    };
}
