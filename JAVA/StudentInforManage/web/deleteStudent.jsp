<%--
  Created by IntelliJ IDEA.
  User: Brocade
  Date: 17.11.22
  Time: 15:22
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" import="java.util.*" pageEncoding="utf-8" %>
<%@ page import="Student.StudentAction" %>
<%@ page import="Student.StudentStructure" %>
<html>
<head>
    <title></title>
</head>
<body>
<% StudentAction.deleteStudent(request.getParameter("uuid")); %>
</body>
</html>
