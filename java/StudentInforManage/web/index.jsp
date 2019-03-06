<%@ page language="java" import="java.util.*" pageEncoding="utf-8" %>
<%@ include file="templates/head.jsp" %>
<%@ include file="templates/nav.jsp" %>
<script type = "text/javascript">
    window.onload=function() {
        document.getElementById("show_msg").className="active";
    }
    function alertUserAction(info){
        if( info == 1 ){
            alert("删除失败");
        }
        if( info == 2){
            alert("删除成功")
        }
    }
    function getStudent() {
        var obj = document.getElementById("search");
        var index = obj.selectedIndex;
        var searchText = obj.options[index].text;
        var searchValue = obj.options[index].value; // 选中值
        var field = document.getElementById("field").value;
        window.location.href="index.jsp?search="+searchValue + "&field=" + field;
    }
    alertUserAction(<%= request.getParameter("info") %>)
</script>

<div class="rt_content">
    <%
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
    %>
    <section>
        <h2><strong style="color:grey;">搜索学生信息</strong></h2>
        <form>
            <select class="select" name="search" id="search">
                <option>字段</option>
                <option value="sno">学号</option>
                <option value="name">姓名</option>
                <option value="grade">年级</option>
                <option value="age">年龄</option>
                <option value="sex" >性别</option>
                <option value="major">专业</option>
                <option value="school">学院</option>
            </select>
            <input type="text" name="field" id="field" class="textbox textbox_295"/>
            <input type="button" onclick="getStudent()" value=" 搜索" class="group_btn"/>
        </form>
    </section>

    <section>
        <div class="page_title">
            <h2 class="fl">学生信息展示</h2>
        </div>
        <table class="table">
            <form action="deleteStudents" method="post">
                <tr>
                    <th>删除</th>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>年龄</th>
                    <th>性别</th>
                    <th>年级</th>
                    <th>专业</th>
                    <th>学院</th>
                    <th>操作</th>
                </tr>
                <%
                    int limitMax;
                    ArrayList students = new ArrayList();
                    if(request.getParameter("search") != null && request.getParameter("field") != null) {
                        String search = new String(request.getParameter("search").getBytes("ISO-8859-1"),"UTF-8");
                        String field = new String(request.getParameter("field").getBytes("ISO-8859-1"),"UTF-8");
                        students = StudentAction.getStudentByCondition(search, field);
                        limit = 9999;
                    } else {
                        students = StudentAction.getAllStudent();
                    }
                    if( index*limit+limit >= students.size() ){
                        limitMax = students.size();
                    } else {
                        limitMax = index*limit+limit;
                    }
                    for (int i = index*limit; i < limitMax; i++) {
                        StudentStructure student = (StudentStructure) students.get(i);
                %>
                <tr>
                    <td>
                        <input type="checkbox" name="id" value="<%=student.getUuid()%>"/>
                    </td>
                    <td>
                        <%=student.getSno() %>
                    </td>
                    <td>
                        <%=student.getName() %>
                    </td>
                    <td>
                        <%=student.getAge()%>
                    </td>
                    <td>
                        <%=student.getSex()%>
                    </td>
                    <td>
                        <%=student.getGrade()%>
                    </td>
                    <td>
                        <%=student.getMajor()%>
                    </td>
                    <td>
                        <%=student.getSchool()%>
                    </td>
                    <td>
                        <a href="viewStudentScore.jsp?id=<%=student.getUuid()%>" class="inner_btn">
                            查看
                        </a>
                        <a href="updateStudent.jsp?id=<%=student.getUuid()%>" class="inner_btn" <%--id="showPopTxt"--%>>
                            修改
                        </a>
                        <a href="deleteStudent?id=<%=student.getUuid()%>" class="inner_btn">
                            删除
                        </a>
                    </td>
                </tr>
                <%
                    }
                %>
                <tr>
                    <td colspan="9">
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn" value="删除所选" />
                    </td>
                </tr>
            </form>
        </table>
        <aside class="paging">
            <a href="index.jsp?index=0" >首页</a>
            <a href="index.jsp?index=<%=index-1%>"> << </a>
            <%
                int count = (int)Math.ceil( (double)students.size()/limit);
                    for(int i = index; i < count; i++ ){
                        if(i < index+3 || i > count - 4){
            %>
            <a href="index.jsp?index=<%=i%>">第<%=i+1%>页</a>
            <%
                    }
                }
            %>
            <a href="index.jsp?index=<%=count-1%>" >尾页</a>
        </aside>
<%@include file="templates/footer.jsp" %>