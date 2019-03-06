<%@ page import="Common.CommonQuery" %>
<%@ page import="Common.CollegeStructure" %>
<%@ page import="java.security.AlgorithmConstraints" %>
<%@ page import="Common.ObjectStructure" %><%--
  Created by IntelliJ IDEA.
  User: Brocade
  Date: 17.11.22
  Time: 15:22
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ include file="templates/head.jsp"%>
<%@ include file="templates/nav.jsp"%>
<% request.setCharacterEncoding("UTF-8"); %>
<% request.getAttribute("id"); %>

<script type = "text/javascript">
    window.onload=function() {
        document.getElementById("add_msg").className="active";
    }
    function getStudentInfo(){
        var obj = document.getElementById("grade");
        var index = obj.selectedIndex;
        var gradeText = obj.options[index].text;
        var gradeValue = obj.options[index].value; // 选中值

        obj = document.getElementById("school");
        index = obj.selectedIndex;
        var schoolText = obj.options[index].text;
        var schoolValue = obj.options[index].value; // 选中值

        obj = document.getElementById("major");
        index = obj.selectedIndex;
        var majorText = obj.options[index].text;
        var majorValue = obj.options[index].value; // 选中值

        obj = document.getElementById("object");
        index = obj.selectedIndex;
        var objectText = obj.options[index].text;
        var objectValue = obj.options[index].value; // 选中值

        window.location.href="addStudentScore.jsp?grade="+gradeValue+"&school="+schoolValue+"&major="+majorValue+"&object="+objectValue;
    }
</script>

<div class="rt_content">
<%
    ArrayList colleges = CommonQuery.getAllCollege();
    ArrayList majors = CommonQuery.getAllMajor();
    ArrayList objects = CommonQuery.getAllObject();

    String Grade = request.getParameter("grade");
    String School = request.getParameter("school");
    String Major = request.getParameter("major");
    String Object = request.getParameter("object");
    if( Grade == null && School == null && Major == null && Object == null ){
%>
<section>
    <h2><strong style="color:grey;">添加学生成绩</strong></h2>
        <ul class="ulColumn2">
            <li>
                <span class="item_name" style="width:120px;" >年级：</span>
                <select class="select" id="grade" name="grade">
                    <% for(int i=2014;i<=2017;i++){%>
                    <option value="<%=i%>"><%=i%></option>
                    <%}%>
                </select>
            </li>
            <li>
                <span class="item_name" style="width:120px;" >学院：</span>
                <select class="select" id="school" name="school">
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
                <select class="select" id="major" name="major">
                    <%
                        for(int i=0;i<majors.size();i++){
                            CollegeStructure major = (CollegeStructure)majors.get(i);
                    %>
                    <option value="<%=major.getMajor()%>"><%=major.getMajor()%></option>
                    <%}%>
                </select>
            </li>
            <li>
            <span class="item_name" style="width:120px;" >科目：</span>
            <select class="select" id="object" name="major">
                <%
                    for(int i=0;i<objects.size();i++){
                        ObjectStructure object = (ObjectStructure) objects.get(i);
                %>
                <option value="<%=object.getObject()%>"><%=object.getObject()%></option>
                <%}%>
            </select>
            </li>
            <li>
                <span class="item_name" style="width:120px;"></span>
                <input type="submit" value="查询" onclick="getStudentInfo()" class="link_btn">
            </li>
        </ul>
</section>
<%
    } else {
        Grade = new String(Grade.getBytes("ISO-8859-1"),"UTF-8");
        School = new String(School.getBytes("ISO-8859-1"),"UTF-8");
        Major = new String(Major.getBytes("ISO-8859-1"),"UTF-8");
        Object = new String(Object.getBytes("ISO-8859-1"),"UTF-8");
%>
<section>
    <div class="page_title">
        <h2><strong style="color:grey;">添加<%=Grade%>级<%=School%><%=Major%>学生<%=Object%>成绩</strong></h2>
    </div>
<form action="addScore" method="post">
    <table class="table">
        <tr>
            <th>学号</th>
            <th>姓名</th>
            <th>成绩</th>
        </tr>
        <%
            ArrayList students = StudentAction.getStudentByGCM(Grade, School, Major);
            for (int i = 0; i < students.size(); i++) {
                StudentStructure student = (StudentStructure) students.get(i);
        %>
        <tr>
            <td>
                <%=student.getSno()%>
            </td>
            <td>
                <%=student.getName()%>
            </td>
            <td>
                    <input type="hidden" name="id" value="<%=student.getUuid()%>" />
                    <span class="item_name" style="width:120px;">成绩：</span>
                    <input type="text" class="textbox textbox_295" name="score"/>
            </td>
        </tr>
        <% } %>
        <tr>
            <td colspan="3">
                <input type="hidden" name="object" value="<%=Object%>">
                <span class="item_name" style="width:120px;"></span>
                <input type="submit" class="link_btn" />
            </td>
        </tr>
    </table>
</form>
</section>
<%
    }
%>
</div>

<%@include file="templates/footer.jsp"%>