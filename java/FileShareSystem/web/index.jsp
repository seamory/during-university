<%@ page import="com.filesharesystem.models.File" %>
<%@ page import="java.util.List" %>
<%@ page import="com.filesharesystem.dao.impl.FileDAOImpl" %>
<%@ taglib prefix="s" uri="/struts-tags" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
  int limitMax;
  int index;
  int limit=10;
  String indexString = request.getParameter("index");
  String limitString = request.getParameter("limit");
  if(indexString != null ){
    index = Integer.parseInt(indexString);
    if( index < 0 ){
      index = 0;
    }
  } else {
    index = 0;
  }
  List<File> files;
  files = new FileDAOImpl().getFiles ();
  int countfiles = files.size ();
%>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta title="文件共享系统">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="<%=request.getContextPath()%>/static/css/theme.css" type="text/css">
  <script type="text/javascript">
  </script>
</head>

<body>
  <%@include file="static/jsp/header.jsp"%>
  <div class="p-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="py py-2">共享文件列表</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="">共享文件数：<%=countfiles%></p>
        </div>
      </div>
    </div>
  </div>
  <div class="p-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <table class="table" id="filetable">
            <thead>
              <tr>
                <th>文件名</th>
                <th>上传时间</th>
                <th>上传用户</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
            <%
//              if( index*limit+limit >= files.size() ){
//                limitMax = files.size();
//              } else {
//                limitMax = index*limit+limit;
//              }
              for(int i = index*limit; i < files.size(); i++) {
            %>
              <tr>
                <td><%=files.get(i).getFileName()%></td>
                <td><%=files.get(i).getCreated_at()%></td>
                <td><%=files.get(i).getUid().getUsername()%></td>
                <td>
                  <a class="btn" href="/user/Download.action?fid=<%=files.get(i).getFid()%>">
                    下载
                  </a>
                  <a class="btn" href="/user/FavoriteFile.action?fid=<%=files.get(i).getFid()%>">
                    收藏
                  </a>
                </td>
              </tr>
            <% } %>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="py-1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="index.jsp?index=0" >首页</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="index.jsp?index=<%=index-1%>"> << </a>
            </li>
            <%
              int count = (int)Math.ceil( (double)files.size()/limit);
              for(int i = index; i < count; i++ ){
                if(i < index + 3 || i > count - 4){
            %>
            <li class="page-item">
              <a class="page-link"  href="index.jsp?index=<%=i%>"> <%=i+1%> </a>
            </li>
            <%
                }
              }
            %>
            <li class="page-item">
              <a class="page-link" href="index.jsp?index=<%=count-1%>" >尾页</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <%@include file="static/jsp/tail.jsp"%>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>