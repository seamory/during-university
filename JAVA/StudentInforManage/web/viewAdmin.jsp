<%@ page language="java" import="java.util.*" pageEncoding="utf-8" %>
<%@ include file="templates/head.jsp" %>
<%@ include file="templates/nav.jsp" %>
<%@ page import="Admin.AdminStructure" %>
<%@ page import="Admin.AdminAction" %>

<script type = "text/javascript">
    window.onload=function() {
        document.getElementById("show_msg").className="active";
    }
</script>

<div class="rt_content">
    <!--点击加载-->
    <script>
        $(document).ready(function () {
            $("#loading").click(function () {
                $(".loading_area").fadeIn();
                $(".loading_area").fadeOut(1500);
            });
        });
    </script>
    <section class="loading_area">
        <div class="loading_cont">
            <div class="loading_icon"><i></i><i></i><i></i><i></i><i></i></div>
            <div class="loading_txt">
                <mark>数据正在加载，请稍后！</mark>
            </div>
        </div>
    </section>
    <!--结束加载-->

    <section>
        <div class="page_title">
            <h2 class="fl">管理员列表</h2>
        </div>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>管理员</th>
                <th>密码管理</th>
                <th>操作</th>
            </tr>
            <%

                ArrayList admins = AdminAction.getAllAdmin();
                for (int i = 0; i < admins.size(); i++) {
                    AdminStructure admin = (AdminStructure) admins.get(i);
            %>
            <tr>
                <td style="width:265px;">
                    <div class="cut_title ellipsis">
                        <%=admin.getUid()%>
                    </div>
                </td>
                <td>
                    <%=admin.getUsername() %>
                </td>
                <td>
                    <form action="/updateAdmin" method="post">
                        <input type="hidden" name="id" value="<%=admin.getUid()%>" />
                        <span class="item_name" style="width:120px;">新密码：</span>
                        <input type="text" class="textbox textbox_295" name="password"/>
                        <span class="item_name" style="width:120px;"></span>
                        <input type="submit" class="link_btn" />
                    </form>
                </td>
                <td>
                    <a href="deleteAdmin?id=<%=admin.getUid()%>" class="inner_btn">
                        删除
                    </a>
                </td>

            </tr>
            </tbody>
            <% } %>
        </table>
     </section>

<%@include file="templates/footer.jsp" %>