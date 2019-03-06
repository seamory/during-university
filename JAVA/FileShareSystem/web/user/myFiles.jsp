<%--
  Created by IntelliJ IDEA.
  User: HuGang
  Date: 18.5.28
  Time: 10:30
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="../static/jsp/user-header.jsp"%>

<div class="am-cf am-padding">
    <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg">我的文件</strong> /
        <small>将显示上传的文件</small>
    </div>
</div>
<div class="am-g">
    <div class="am-u-sm-12">
        <table class="am-table am-table-bd am-table-striped admin-content-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>文件名</th>
                <th>文件类型</th>
                <th>上传时间</th>
                <th>文件公开</th>
                <th>管理</th>
            </tr>
            </thead>
            <tbody>
            <%
//                if( index*limit+limit >= files.size() ){
//                    limitMax = files.size();
//                } else {
//                    limitMax = index*limit+limit;
//                }
                for(int i = index*limit; i < files.size(); i++) {
            %>
            <tr>
                <td><%=i+1%></td>
                <td>
                    <%=files.get(i).getFileName().length()>10?
                            files.get(i).getFileName().substring(0, 5) + "..." +
                                    files.get(i).getFileName().substring(files.get(i).getFileName().length()-5):
                            files.get(i).getFileName()
                    %>
                </td>
                <td>
                    <%=files.get(i).getFileType().length()>10?
                            files.get(i).getFileType().substring(0,5) + "..." +
                                    files.get(i).getFileType().substring(files.get(i).getFileType().length()-5):
                            files.get(i).getFileType()%>
                </td>
                <td>
                    <%=files.get(i).getCreated_at()%>
                </td>
                <td>
                    <%=files.get(i).getType()==1?"是":"否"%>
                </td>
                <td>
                    <div class="am-dropdown" data-am-dropdown="">
                        <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle="">
                            <span class="am-icon-cog"></span>
                            <span class="am-icon-caret-down"></span>
                        </button>
                        <ul class="am-dropdown-content">
                            <li>
                                <a href="./FileEdit.jsp?fid=<%=files.get(i).getFid()%>">1. 编辑</a>
                            </li>
                            <li>
                                <a href="/user/Download.action?fid=<%=files.get(i).getFid()%>">2. 下载</a>
                            </li>
                            <li>
                                <a href="/user/DeleteFile.action?fid=<%=files.get(i).getFid()%>">3. 删除</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <% } %>
            </tbody>
        </table>
        <%--分页--%>
        <ul data-am-widget="pagination" class="am-pagination am-pagination-default">
            <li class="am-pagination-first ">
                <a href="myFiles.jsp?index=0" class="">第一页</a>
            </li>

            <li class="am-pagination-prev ">
                <a href="myFiles.jsp?index=<%=index-1%>" class=""> << </a>
            </li>

            <%
                int count = (int)Math.ceil( (double)files.size()/limit);
                for(int i = index; i < count; i++ ){
                    if(i < index + 3 || i > count - 4){
            %>
            <li class="">
                <a href="myFiles.jsp?index=<%=i%>" class=""> <%=i+1%> </a>
            </li>
            <%
                    }
                }
            %>

            <li class="am-pagination-last ">
                <a href="myFiles.jsp?index=<%=count-1%>" class="">最末页</a>
            </li>
        </ul>
    </div>
</div>

<%@include file="../static/jsp/user-footer.jsp"%>