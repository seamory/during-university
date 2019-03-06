<%--
  Created by IntelliJ IDEA.
  User: HuGang
  Date: 18.5.28
  Time: 22:43
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="../static/jsp/user-header.jsp"%>

<div class="am-cf am-padding">
    <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg">上传文件</strong> /
        <small>将上传文件用以共享</small>
    </div>
</div>

<div class="am-g">
    <div class="am-u-sm-12">
        <form class="am-form-inline" method="post" enctype="multipart/form-data" action="/user/Upload.action">
            <ul class="am-list">
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
                <li class="am-list-item-text">
                    <div class="am-form-group">
                        <input type="file" name="upload">
                    </div>
                    <div class="am-form-group">
                        <input type="text" name="fileName" class="am-form-field" placeholder="文件显示名称">
                    </div>
                </li>
            </ul>
            <input class="am-btn am-btn-default" value="上传" type="submit">
        </form>
    </div>
</div>

<%@include file="../static/jsp/user-footer.jsp"%>