<%@ page import="Admin.AdminAction" %><%--
  Created by IntelliJ IDEA.
  User: Brocade
  Date: 17.11.222
  Time: 15:22
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="templates/head.jsp"%>
<%@ include file="templates/nav.jsp"%>
<%@ page import="Student.StudentAction" %>
<%@ page import="Common.CollegeStructure" %>
<%@ page import="Common.CommonQuery" %>
<% request.getAttribute("id"); %>

<%
    StudentStructure student = StudentAction.getOneStudent(request.getParameter("id"));
    ArrayList colleges = CommonQuery.getAllCollege();
    ArrayList majors = CommonQuery.getAllMajor();
%>
<script type = "text/javascript">
    window.onload=function() {
        document.getElementById("change_msg").className="active";
    }
    function getMajor(){

    }
</script>
<form action="/updateStudent" method="post">
<section>
    <h2><strong style="color:grey;">修改学生信息</strong></h2>
    <ul class="ulColumn2">
        <li>
            <input type="hidden" name="uuid" value="<%=request.getParameter("id")%>"/>
        </li>
        <li>
            <span class="item_name" style="width:120px;">学生名：</span>
            <input type="text" class="textbox textbox_295" name="name" value=<%= student.getName()%>  />
            <%--<span class="errorTips">错误提示信息...</span>--%>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >学号：</span>
            <input style="background:#CCCCCC" type="text" class="textbox textbox_295" name="sno" readonly="readonly" value=<%= student.getSno()%> />
        </li>
        <li>
            <span class="item_name" style="width:120px;" >年龄：</span>
            <select class="select" name="age">
                <% for(int i=12;i<100;i++){%>
                <option value="<%=i%>" <% if(student.getAge() == i){%>selected<%}%>><%=i%></option>
                <%}%>
            </select>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >年级：</span>
            <select class="select" name="grade">
            <% for(int i=2014;i<=2017;i++){%>
            <option value="<%=i%>" <% if(student.getGrade() == i){%>selected<%}%>><%=i%></option>
            <%}%>
            </select>
        </li>
        <li>
            <span class="item_name" style="width:120px;"  >性别：</span>
            <label class="single_selection"><input type="radio" name="sex" value="男" <%if(student.getSex().equals("男")){%>checked<%}%>/>男</label>
            <label class="single_selection"><input type="radio" name="sex" value="女" <%if(student.getSex().equals("女")){%>checked<%}%>/>女</label>
        </li>
        <li>
            <span class="item_name" style="width:120px;" >学院：</span>
            <select class="select" name="school">
                <%
                    for(int i=0;i<colleges.size();i++){
                        CollegeStructure college = (CollegeStructure)colleges.get(i);
                %>
                <option value="<%=college.getCollege()%>" <%if(student.getSchool().equals(college.getCollege())){%> selected <%}%>><%=college.getCollege()%></option>
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
                <option value="<%=major.getMajor()%>" <%if(student.getMajor().equals(major.getMajor())){%> selected <%}%>><%=major.getMajor()%></option>
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