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

<%
    ArrayList colleges = CommonQuery.getAllCollege();
    ArrayList majors = CommonQuery.getAllMajor();
%>

<form action="/addStudent" method="post">
<section>
    <h2><strong style="color:grey;">添加学生信息</strong></h2>
    <ul class="ulColumn2">
        <li>
            <span class="item_name" style="width:120px;">学生名：</span>
            <input type="text" class="textbox textbox_295" name="name" placeholder="学生名"/>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >学号：</span>
            <input type="text" class="textbox textbox_295" name="sno"  placeholder="学号" />
        </li>
        <li>
            <span class="item_name" style="width:120px;" >年龄：</span>
            <select class="select" name="age">
                <% for(int i=12;i<100;i++){%>
                <option value="<%=i%>"><%=i%></option>
                <%}%>
            </select>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >年级：</span>
            <select class="select" name="grade">
                <% for(int i=2014;i<=2017;i++){%>
                <option value="<%=i%>"><%=i%></option>
                <%}%>
            </select>
        </li>
        <li>
            <span class="item_name" style="width:120px;"  >性别：</span>
            <label class="single_selection"><input type="radio" name="sex" value="男" />男</label>
            <label class="single_selection"><input type="radio" name="sex" value="女"/>女</label>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >学院：</span>
            <select class="select" name="school">
                <%
                    for(int i=0;i<colleges.size();i++){
                        CollegeStructure college = (CollegeStructure)colleges.get(i);
                %>
                <option value="<%=college.getCollege()%>"><%=college.getCollege()%></option>
                <%}%>
            </select>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >专业：</span>
            <select class="select" name="major">
                <%
                    for(int i=0;i<majors.size();i++){
                        CollegeStructure major = (CollegeStructure)majors.get(i);
                %>
                <option value="<%=major.getMajor()%>"><%=major.getMajor()%></option>
                <%}%>
            </select>
        </li>
        <li>
            <span class="item_name" style="width:120px;"></span>
            <input type="submit" class="link_btn" />
        </li>
    </ul>
</section>
</form>

<%@include file="templates/footer.jsp"%>