<%--
  Created by IntelliJ IDEA.
  User: Brocade
  Date: 17.11.22
  Time: 15:22
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" import="java.util.*" pageEncoding="utf-8" %>
<%@ include file="templates/head.jsp" %>
<%@ include file="templates/nav.jsp" %>
<%@ page import="Student.StudentAction" %>
<%@ page import="Student.StudentStructure" %>
<%@ page import="Common.CommonQuery" %>
<%@ page import="Score.ScoreStructure" %>
<%@ page import="Score.ScoreAction" %>

<%
    StudentStructure student = StudentAction.getOneStudent(request.getParameter("id"));
%>

<section>
    <div class="page_title">
        <h2 class="fl">学生"<%=student.getName() %>"成绩</h2>
    </div>

    <table class="table">
        <tr>
            <th class="center">学号</th>
            <th class="center">姓名</th>
            <th>科目</th>
            <th>成绩</th>
            <th>修改</th>
        </tr>
        <tbody>
        <%
            ArrayList scores = ScoreAction.getOneScore(request.getParameter("id"));
            for(int i=0; i< scores.size(); i++){
                ScoreStructure score = (ScoreStructure)scores.get(i);
        %>
        <tr>
            <td class="center"><%=student.getSno() %></td>
            <td class="center"><%=student.getName() %></td>
            <td class="center"><%=score.getObject()%></td>
            <td class="center"><%=score.getScore()%></td>
            <td>
                <form action="/changeScore" method="post">
                    <input type="hidden" name="object" value="<%=score.getObject()%>" />
                    <input type="hidden" name="id" value="<%=student.getUuid()%>" />
                    <span class="item_name" style="width:120px;">新成绩：</span>
                    <input type="text" class="textbox textbox_295" name="score"/>
                    <span class="item_name" style="width:120px;"></span>
                    <input type="submit" class="link_btn" />
                </form>
            </td>
        </tr>
        <%
            }
        %>
        </tbody>
    </table>
</section>

<%@include file="templates/footer.jsp" %>