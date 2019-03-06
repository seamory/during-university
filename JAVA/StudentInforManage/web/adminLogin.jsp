<%--
  Created by IntelliJ IDEA.
  User: Nikoace
  Date: 12/5/2017
  Time: 3:07 PM
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>学生管理系统</title>
	<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>static/css/LoginPage.css">
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
</head>
<body>
<header>
    <div class="bg">
        <canvas id="display"></canvas>
        <div id="blachole"></div>
    </div>
    <div class="loginBox">

        <div class="login-html">

            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">学生信息管理系统</label>

            <div class="login-form">

                <form method="get" action="/CheckCode/Check">
                <div class="sign-in-htm">
                    <div class="group">
                        <label for="user" class="label">用户名</label>
                        <input id="user" type="text" name="username" class="input">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">密码</label>
                        <input id="pass" type="password" name="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="check" class="label">验证码</label>
                        <input id="check" type="text" name="CheckCode" class="input">
                        <br/>
                        <img style="border-radius: 10px" id="checkcode" src="<%=request.getContextPath() %>/CheckCode/CheckCode" onclick="this.src='/CheckCode/CheckCode?d='+Math.random();"/>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="登陆">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</header>

</div>
<script src="<%=request.getContextPath() %>/static/js/jquery.js"></script>
<script type="text/javascript" src="<%=request.getContextPath() %>/static/js/constellation.js"></script>
</body>
</html>
