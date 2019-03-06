<%@ page language="java" import="java.util.*" pageEncoding="utf-8" %>
<%@ page import="Student.StudentAction" %>
<%@ page import="Student.StudentStructure" %>

<%
    String path = request.getContextPath();
    String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
%>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>后台管理系统</title>
    <meta name="author" content="DeathGhost"/>
    <link rel="stylesheet" type="text/css" href="static/css/style.css"/>
    <!--[if lt IE 9]>
    <script src="static/js/html5.js"></script>
    <![endif]-->
    <script src="static/js/jquery.js"></script>
    <script src="static/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        (function ($) {
            $(window).load(function () {

                $("a[rel='load-content']").click(function (e) {
                    e.preventDefault();
                    var url = $(this).attr("href");
                    $.get(url, function (data) {
                        $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
                        //scroll-to appended content
                        $(".content").mCustomScrollbar("scrollTo", "h2:last");
                    });
                });

                $(".content").delegate("a[href='top']", "click", function (e) {
                    e.preventDefault();
                    $(".content").mCustomScrollbar("scrollTo", $(this).attr("href"));
                });

            });
        })(jQuery);
    </script>
</head>

<body>
<!--header-->
<header>
    <h1><img src="static/images/admin_logo.png"/></h1>
    <ul class="rt_nav">
        <li><a href="/" class="quit_icon">安全退出</a></li>
    </ul>
</header>
