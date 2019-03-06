package com.filesharesystem.dao;
/*
 *文件等级评定和文件评论接口
 *@author gh
 *@create 2018-04-11 20:36
 */

import com.filesharesystem.models.FileCommit;

import java.util.List;

public interface FileCommitDAO {

    List<FileCommit> getFileCommitByFID(String fid);

    FileCommit getFileCommit(String fid, String uid);
}
