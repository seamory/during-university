<%--
  Created by IntelliJ IDEA.
  User: HuGang
  Date: 18.5.25
  Time: 11:16
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ page import="com.filesharesystem.models.User" %>
<%@ page import="org.apache.struts2.ServletActionContext" %>
<%@ page import="com.filesharesystem.dao.impl.IPDAOImpl" %>
<%@ page import="com.filesharesystem.models.IP" %>
<%@ page import="java.util.List" %>
<%@ page import="com.filesharesystem.dao.impl.FileDAOImpl" %>
<%@ page import="com.filesharesystem.models.File" %>
<%@ page import="com.filesharesystem.models.FileData" %>
<%@ page import="com.filesharesystem.dao.impl.FileDataDAOImpl" %>
<%
    User user = (User) ServletActionContext.getRequest().getSession().getAttribute( "user" );
    String username=null;
    List<IP> ipList = null;
    List<File> files = null;
    List<FileData> DownList = null;
    List<FileData> FavorList = null;
    int limitMax;
    int type=1;
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
    if (user!=null){
        username = user.getUsername();
        type = user.getType ();
        ipList = new IPDAOImpl().ipList(user);
        files = new FileDAOImpl().getFileById(user);
        DownList = new FileDataDAOImpl().getUserDownList(user);
        FavorList = new FileDataDAOImpl().getUserFavorList(user);
    }

%>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <link rel="icon" type="image/png" href="../assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI">
    <link rel="stylesheet" href="../assets/css/amazeui.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/amazeui.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>


<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->
<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand"><a href="../index.jsp" >文件管理系统 </a></div>
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}">
        <span class="am-sr-only">导航切换</span>
        <span class="am-icon-bars"></span>
    </button>
    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-dropdown" data-am-dropdown="">
                <a class="am-dropdown-toggle" data-am-dropdown-toggle="" href="javascript:;">
                    <span class="am-icon-users"></span>&nbsp;<%=username%> &nbsp;
                    <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li>
                        <a href="userEdit.jsp">
                            <span class="am-icon-user"></span> 资料</a>
                    </li>
                </ul>
            </li>
            <li class="am-hide-sm-only">
                <a href="javascript:;" id="admin-fullscreen">
                    <span class="am-icon-arrows-alt"></span>
                    <span class="admin-fullText">开启全屏</span>
                </a>
            </li>
        </ul>
    </div>
</header>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li>
                    <a href="index.jsp">
                        <span class="am-icon-home"></span> 首页</a>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}">
                        <span class="am-icon-file"></span>&nbsp;文件列表
                        <span class="am-icon-angle-right am-fr am-margin-right"></span>
                    </a>
                    <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
                        <li>
                            <a href="myFiles.jsp" class="am-cf">
                                <span class="am-icon-th"></span>&nbsp;我的文件
                                <span class="am-badge am-badge-secondary am-margin-right am-fr"><%=files.size()%></span>
                            </a>
                        </li>
                        <li>
                            <a href="myDownloads.jsp">
                                <span class="am-icon-puzzle-piece"></span>&nbsp;下载的文件
                                <span class="am-badge am-badge-secondary am-margin-right am-fr">
                                    <%=DownList==null?0:DownList.size()%>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="myFavorites.jsp">
                                <span class="am-icon-th"></span>&nbsp;收藏的文件
                                <span class="am-badge am-badge-secondary am-margin-right am-fr">
                                    <%=FavorList==null?0:FavorList.size()%>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="myUpload.jsp">
                                <span class="am-icon-archive"></span>&nbsp;文件上传
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/logout.action">
                        <span class="am-icon-sign-out"></span> 注销</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">