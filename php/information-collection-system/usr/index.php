<?php 
$uri=explode('/',$_SERVER['REQUEST_URI']);
if($uri[sizeof($uri)-2]=='usr')
	header('location:../index.php');
	formAction();
?>
<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>MAIN数据平台</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="MAIN">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <style>
    .get {
      /* background: #1E5B94; */
	  /* background: #3293fe; */
	  background:url("assets/i/index.jpg");
      color: #fff;
      text-align: center;
      padding: 100px 0px 200px 0px;
    }

    .get-title {
      font-size: 200%;
      border: 2px solid #fff;
      padding: 20px;
      display: inline-block;
    }

    .get-btn {
      background: #fff;
    }

    .detail {
      background: #fff;
	  margin-top:30px;
    }

    .detail-h2 {
      text-align: center;
      font-size: 150%;
      margin: 40px 0;
    }

    .detail-h3 {
      color: #1f8dd6;
    }

    .detail-p {
      color: #7f8c8d;
    }

    .detail-mb {
      margin-bottom: 30px;
    }

    .hope {
      background: #0bb59b;
      padding: 50px 0;
    }

    .hope-img {
      text-align: center;
    }

    .hope-hr {
      border-color: #149C88;
    }

    .hope-title {
      font-size: 140%;
    }

    .about {
      background: #fff;
      padding: 40px 0;
      color: #7f8c8d;
    }

    .about-color {
      color: #34495e;
    }

    .about-title {
      font-size: 180%;
      padding: 30px 0 50px 0;
      text-align: center;
    }

    .footer p {
      color: #7f8c8d;
      margin: 0;
      padding: 15px 0;
      text-align: center;
      background: #2d3e50;
    }
  </style>
</head>
<body>
<header class="am-topbar am-topbar-fixed-top">
  <div class="am-container">
    <h1 class="am-topbar-brand">
      <a href="#">MAIN DATA MANAGEMENT</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only"
            data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">导航切换</span> <span
        class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="collapse-head">
      <ul class="am-nav am-nav-pills am-topbar-nav">
         <li class="am-active"><a href="#">首页</a></li> 
      </ul>
	  
      <div class="am-topbar-right">
        <a href="user/login.php?act=2" style="color:#fff;"><button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm"><span class="am-icon-pencil"></span> 注册</button></a>
      </div>

      <div class="am-topbar-right">
        <a href="user/login.php" style="color:#fff;"><button class="am-btn am-btn-primary am-topbar-btn am-btn-sm"><span class="am-icon-user"></span> 登录</button></a>
      </div>
	  
	  <div class="am-topbar-right" style="margin-top:10px">
        <a href="./user/login.php?wb=login" ><img src="../assets/i/weibo_login.png" alt="" width="60%" height="60%"></a>
      </div>
    </div>
  </div>
</header>

<div class="get" >
  <div class="am-g">
     <!-- <div class="am-u-lg-12">	 
      <h1 class="get-title">MAIN 信息系统</h1>
    </div> -->
  </div>
</div>

<div class="detail">
  <div class="am-g am-container">
    <div class="am-u-lg-12">
      <div class="am-g">
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">

          <h3 class="detail-h3">
            <i class="am-icon-bar-chart am-icon-sm"></i>
            发布问卷表单
          </h3>

          <p class="detail-p">
            面向问卷轻量级用户，提供简单快捷的问卷表单创建服务，第一时间满足您的发布需要。
          </p>
        </div>
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">
          <h3 class="detail-h3">
            <i class="am-icon-list-alt am-icon-sm"></i>
            发布空课表
          </h3>

          <p class="detail-p">
            面向高校学生组织，提供便捷的空课表填写及生成服务，方便您第一时间调拨人员。
          </p>
        </div>
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">
          <h3 class="detail-h3">
            <i class="am-icon-check-square-o am-icon-sm"></i>
            数据采集服务定制
          </h3>

          <p class="detail-p">
            相比于主动性的问卷发布采集用户意见，在面向市场用户，问卷所不能解决的专业化的数据采集情况下，我们将为您提供专业化的数据采集及数据一体化服务，确保交付用户的资料是数据的直观体现。
          </p>
        </div>
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">
          <h3 class="detail-h3">
            <i class="am-icon-send-o am-icon-sm"></i>
            高效稳定
          </h3>

          <p class="detail-p">
            旨在为用户提供最方便最直观的服务，位于阿里云的服务器，将为您的使用带来绝对的稳定。
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="footer">
  <p>© 2017 by the <a href="http://www.seamory.com/" target="_blank">MAIN</a> Team.</p>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
</body>
</html>
