<%@ page import="CheckCode.CheckServlet" %><%--
  Created by IntelliJ IDEA.
  User: Nikoace
  Date: 11/22/2017
  Time: 14:48
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>StudentManage</title>
    <script type="application/javascript">
        function reloadCode() {
            var time = new Date().getTime();
            document.getElementById("Code").src = "<%=request.getContextPath()%>/CheckCode/CheckCode" + time;
        }
        function alertUserAction(info){
            if( info == 1 ){
                alert("验证码错误");
            }
            if( info == 2){
                alert("用户名或者密码错误")
            }
        }
        alertUserAction(<%= request.getParameter("info") %>)
    </script>
    <style type="text/css">
        body {
            background-image: url(<%=request.getContextPath()%>static/images/login_bg.JPG);
            text-align: center;
        }

        .LoginBox {
            border-radius: 5px;
            margin: 240px;
            height: 260px;
            width: 450px;
            background-color: #FFFFCC;
            box-sizing: content-box;
            display: inline-block;
            float: none;
            line-height: 40px;
            position: static;
            z-index: auto;
        }

        .Login {

            width: 120px;
        }

        #lo {
            position: relative;
            width: 120px;
            vertical-align: sub;
        }

        table {
            align-content: center;
        }
    </style>
</head>
<body>
<div class="LoginBox">
    <h1 align="center">管理员登录</h1>
    <form action="<%=request.getContextPath()%>/CheckCode/Check" method="get" enctype="text/plain">
        <table align="center">
            <tr>
                <td>用户名：</td>
                <td>
                    <input type="text" class="Login" name="username" placeholder="用户名"/>
                </td>
            </tr>
            <tr>
                <td>密码：</td>
                <td>
                    <input type="password" class="Login" name="password" placeholder="密码"/>
                </td>
            </tr>
            <tr>
                <td> 验证码：</td>
                <td>
                    <input type="text" class="Login" name="CheckCode" placeholder="验证码"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <img alt="check" id="Code" src="<%=request.getContextPath() %>/CheckCode/CheckCode">
                    <a href="">换一张？</a>
                </td>

            </tr>
        </table>
        <button type="submit" id="lo">登录</button>
        <br/>
    </form>
</div>

</body>
</html>
