<%--
  Created by IntelliJ IDEA.
  User: HuGang
  Date: 18.5.29
  Time: 12:58
  To change this template use File | Settings | File Templates.
--%>
<%
    String fid = request.getParameter("fid");
    File file = new FileDAOImpl().getFileByFid(fid);
%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="../static/jsp/user-header.jsp"%>
<div class="am-cf am-padding">
    <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg">文件信息修改</strong> /
        <small>用于修改文件属性</small>
    </div>
</div>
<div class="am-g">
    <div class="am-u-sm-12">
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-0'}">
                <%=file.getFileName()%> 文件属性修改
                <span class="am-icon-chevron-down am-fr"></span>
            </div>
            <div class="am-panel-bd am-collapse am-in" id="collapse-panel-0">
                <form class="am-form am-form-horizontal" action="/user/SetType.action" method="post" enctype="application/x-www-form-urlencoded">
                    <input type="hidden" name="fid" value="<%=file.getFid()%>">
                    <div class="am-form-group">
                        <label for="doc-ipt-1" class="am-u-sm-2 am-form-label">文件名</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="fileName" value="<%=file.getFileName()%>" id="doc-ipt-1" placeholder="输入新文件名">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">是否公开文件</label>
                        <div class="am-u-sm-10">
                            <select name="type" id="doc-ipt-pwd-2">
                                <option value="1" <%=file.getType()==1?"selected":""%>>公开</option>
                                <option value="0" <%=file.getType()==0?"selected":""%>>私有</option>
                            </select>
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
<%@include file="../static/jsp/user-footer.jsp"%>
