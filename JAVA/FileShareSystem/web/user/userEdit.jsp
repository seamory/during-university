<%@ page import="com.filesharesystem.models.*" %>
<%@ page import="com.filesharesystem.dao.impl.UserDataDAOImpl" %><%--
  Created by IntelliJ IDEA.
  User: HuGang
  Date: 18.5.29
  Time: 12:59
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java"%>
<%@ include file="../static/jsp/user-header.jsp"%>
<%
//    UserData userData = (UserData) new UserDataDAOImpl().getObject(UserData.class,user.getUid());
    UserData userData = new UserDataDAOImpl().getUserData(user.getUid());
    if (userData == null) {
        userData = new UserData();
    }
%>
<div class="am-cf am-padding">
    <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg">用户资料修改</strong> /
        <small>用于修改用户资料</small>
    </div>
</div>
<div class="am-g">
    <div class="am-u-sm-12">
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-0'}">用户密码及邮箱修改
                <span class="am-icon-chevron-down am-fr"></span>
            </div>
            <div class="am-panel-bd am-collapse" id="collapse-panel-0">
                <form class="am-form am-form-horizontal" enctype="application/x-www-form-urlencoded" method="post" action="/user/UserCore.action">
                    <div class="am-form-group">
                        <label for="doc-ipt-1" class="am-u-sm-2 am-form-label">电子邮件</label>
                        <div class="am-u-sm-10">
                            <input type="email" name="email" id="doc-ipt-1" placeholder="<%=user.getEmail()%>" value="<%=user.getEmail()%>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">原密码</label>
                        <div class="am-u-sm-10">
                            <input type="password" name="password" id="doc-ipt-pwd-2" placeholder="请输入原密码" value="<%=user.getPassword()%>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="doc-ipt-pwd-3" class="am-u-sm-2 am-form-label">新密码</label>
                        <div class="am-u-sm-10">
                            <input type="password" name="password" id="doc-ipt-pwd-3" placeholder="输入新密码">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="doc-ipt-pwd-4" class="am-u-sm-2 am-form-label">确认新密码</label>
                        <div class="am-u-sm-10">
                            <input type="password" name="password" id="doc-ipt-pwd-4" placeholder="确认新密码">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            <button type="submit" class="am-btn am-">保存修改</button>

                            <button type="reset" class="am-btn am-btn-default">取消修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="am-g">
    <div class="am-u-sm-12">
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">用户资料修改
                <span class="am-icon-chevron-down am-fr"></span>
            </div>
            <div class="am-panel-bd am-collapse" id="collapse-panel-1">
                <form class="am-form am-form-horizontal" method="post" enctype="application/x-www-form-urlencoded" action="/user/UserData.action">

                    <div class="am-form-group">
                        <label for="userData-1" class="am-u-sm-2 am-form-label">性别</label>
                        <div class="am-u-sm-10">
                            <select name="gender" id="userData-1">
                                <option value="0" <%=userData.getGender()==0?"selected":""%>>女</option>
                                <option value="1" <%=userData.getGender()==1?"selected":""%>>男</option>
                                <option value="2" <%=userData.getGender()==2?"selected":""%>>保密</option>
                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="userData-2" class="am-u-sm-2 am-form-label">年龄</label>
                        <div class="am-u-sm-10">
                            <select name="age" id="userData-2">
                                <% for (int age=1; age < 100; age++) { %>
                                <option value="<%=age%>" <%=userData.getAge()==age?"selected":""%>><%=age%></option>
                                <% } %>
                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="userData-3" class="am-u-sm-2 am-form-label">生日</label>
                        <div class="am-u-sm-10">
                            <input type="date" name="birthday" id="userData-3" value="<%=userData.getBirthday()%>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="userData-4" class="am-u-sm-2 am-form-label">QQ</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="qq" id="userData-4" placeholder="请输入QQ" value="<%=userData.getQQ()%>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="userData-5" class="am-u-sm-2 am-form-label">电话</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="phone" id="userData-5" placeholder="请输入电话号码" value="<%=userData.getPhone()%>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                            <input type="submit" class="am-btn am-" value="保存修改">

                            <button type="reset" class="am-btn am-btn-default">取消修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<%@include file="../static/jsp/user-footer.jsp"%>
