<%@ page import="Common.CommonQuery" %>
<%@ page import="Common.CollegeStructure" %><%--
  Created by IntelliJ IDEA.
  User: Brocade
  Date: 17.11.22
  Time: 15:22
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="templates/head.jsp"%>
<%@ include file="templates/nav.jsp"%>
<% request.getAttribute("id"); %>

<script type = "text/javascript">
    window.onload=function() {
        document.getElementById("add_msg").className="active";
    }
</script>

<form action="/addAdmin" method="post">
<section>
    <h2><strong style="color:grey;">添加管理员</strong></h2>
    <ul class="ulColumn2">
        <li>
            <span class="item_name" style="width:120px;">用户名：</span>
            <input type="text" class="textbox textbox_295" name="username"/>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >密码：</span>
            <input type="password" class="textbox textbox_295" name="password" />
        </li>
        <li>
            <span class="item_name" style="width:120px;"></span>
            <input type="submit" class="link_btn" />
        </li>
    </ul>
</section>
</form>

<%@include file="templates/footer.jsp"%>