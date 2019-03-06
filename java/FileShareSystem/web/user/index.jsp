<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="../static/jsp/user-header.jsp"%>

<div class="admin-content-body">
  <div class="am-cf am-padding">
    <div class="am-fl am-cf">
      <strong class="am-text-primary am-text-lg">面板</strong> /
      <small>一些常用功能</small>
    </div>
  </div>

  <div class="am-g">
    <div class="am-u-sm-12">
      <div class="am-panel am-panel-default">
        <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-0'}">最近上传的文件（只显示最近的5个文件）
          <span class="am-icon-chevron-down am-fr"></span>
        </div>
        <div class="am-panel-bd am-collapse am-in" id="collapse-panel-0">
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
              for (int i = files.size()>5 ? files.size()-5 : 0; i < files.size(); i++) {
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
        </div>
      </div>

    </div>
  </div>
  <div class="am-g">
    <div class="am-u-md-6">
      <div class="am-panel am-panel-default">
        <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">文件快速上传
          <span class="am-icon-chevron-down am-fr"></span>
        </div>
        <div class="am-panel-bd am-collapse" id="collapse-panel-1">
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
              </ul>
              <input class="am-btn am-btn-default" value="上传" type="submit">
          </form>
        </div>
      </div>
    </div>
    <div class="am-u-md-6">
      <div class="am-panel am-panel-default">
        <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-2'}">最近登录IP
          <span class="am-icon-chevron-down am-fr"></span>
        </div>
        <div id="collapse-panel-2" class="am-panel-bd am-collapse">
          <table class="am-table am-table-bd am-table-bdrs am-table-striped am-table-hover">
            <tbody>
              <tr>
                <th>IP地址</th>
                <th>登录时间</th>
              </tr>
              <%
                for (int i = ipList.size()-5; i< ipList.size(); i++) {
              %>
              <tr>
                <td><%=ipList.get(i).getIpv4()%></td>
                <td><%=ipList.get(i).getCreated_at()%></td>
              </tr>
            <% } %>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<%@include file="../static/jsp/user-footer.jsp"%>