<?php
	require_once '../config.php';
	checkLogin();
	$page=$_REQUEST['page'];
	$weibo=mysql::query('*','dm_weibo',"uid='{$_SESSION['uid']}'",'one',MYSQL_ASSOC);
?>
<!doctype html>
<html class="no-js fixed-layout">
<head>
<meta charset="utf-8">
<title>用户中心</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="MAIN">
<meta name="keywords" content="index">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="icon" type="image/png" href="../assets/i/favicon.png">
<link rel="apple-touch-icon-precomposed" href="../assets/i/app-icon72x72@2x.png">
<meta name="apple-mobile-web-app-title" content="Amaze UI" />
<link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
<link rel="stylesheet" href="../assets/css/admin.css">
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="../assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="../assets/js/amazeui.min.js"></script>
<script src="../assets/js/app.js"></script>
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse user-header">
  <div class="am-topbar-brand">
    <strong>MAIN</strong> <small>用户中心</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right user-header-list">
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> <?php 
					if(isset($_SESSION['username'])){
						echo $_SESSION['username'];
					}else if(isset($_COOKIE['usname'])){
						echo $_COOKIE['usname'];
					}
				?> <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="index.php?page=11"><span class="am-icon-user"></span> 资料 </a></li>
          <li><a href="index.php?page=12"><span class="am-icon-cog"></span> 修改密码 </a></li>
		  <li>
		  <?php
			$wb=$_GET['wb'];
			if($wb=='bind'){
				$_SESSION['url']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				wbBind();
				common::local('../oAuth/weibo/wblogin.php');
			}elseif($wb=='cBind'){
				common::alertMsg('暂不支持解除绑定','index.php');
			}
		  ?>
		  <?php if($weibo):?>
			<a href="index.php?wb=cBind"><span class="am-icon-weibo"> 解绑微博 </span></a>
		  <?php else:?>
			<a href="index.php?wb=bind"><span class="am-icon-weibo"> 绑定微博 </span></a>
		  <?php endif?>
		  </li>
          <!-- <li><a href="action.php?act=0"><span class="am-icon-power-off"></span> 退出 </a></li> -->
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>

<div class="am-cf user-main">
  <!-- sidebar start -->
  <div class="user-sidebar am-offcanvas" id="user-offcanvas">
    <div class="am-offcanvas-bar user-offcanvas-bar">
      <ul class="am-list user-sidebar-list">
        <li><a href="index.php"><span class="am-icon-home"></span> 首页</a></li>
        <li class="user-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-file"></span> 问卷表单 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse user-sidebar-sub" id="collapse-nav">
            <li><a href="index.php?page=21" class="am-cf"><span class="am-icon-check"></span> 添加问卷</span></a></li>
            <li><a href="index.php?page=22"><span class="am-icon-list"></span> 管理问卷</a></li>
			<?php if($_SESSION['usergroup']=='administrators'):?>
			<li><a href="index.php?page=25"><span class="am-icon-list-alt"></span> 管理用户问卷 </a></li>
			<?php endif;?>
          </ul>
        </li>
        <li>
			<a class="am-cf" data-am-collapse="{target: '#collapse-ecs'}"><span class="am-icon-table"></span> 空课表 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
			<ul class="am-list am-collapse user-sidebar-sub" id="collapse-ecs">
				<li><a href="index.php?page=31" class="am-cf"><span class="am-icon-check"></span> 添加空课表</span></a></li>
				<li><a href="index.php?page=32"><span class="am-icon-tags"></span> 管理空课表</a></li>
				<?php if($_SESSION['usergroup']=='administrators'):?>
				<li><a href="index.php?page=34"><span class="am-icon-tasks"></span> 管理用户空课表 </a></li>
				<?php endif;?>
			</ul class="am-list am-collapse user-sidebar-sub" id="collapse-ecs">
		</li>
		<li>
			<a class="am-cf" data-am-collapse="{target: '#collapse-mw'}"><span class="am-icon-comment-o"></span> 消息墙 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
			 <ul class="am-list am-collapse user-sidebar-sub" id="collapse-mw">
				<li><a href="index.php?page=51" class="am-cf"><span class="am-icon-comments"></span> 添加消息墙 </span></a></li>
				<li><a href="index.php?page=52" class="am-cf"><span class="am-icon-cog"></span> 管理消息墙</span></a></li>
				<?php if($_SESSION['usergroup']=='administrators'):?>
					<li><a href="index.php?page=54"><span class="am-icon-database"></span> 管理用户消息墙 </a></li>
				<?php endif;?>	
			 </ul class="am-list am-collapse user-sidebar-sub" id="collapse-mw">
		</li>
		<?php if($_SESSION['usergroup']=='administrators'):?>
		<li>
			<a class="am-cf" data-am-collapse="{target: '#collapse-user'}"><span class="am-icon-star"></span> 用户管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
			<ul class="am-list am-collapse user-sidebar-sub" id="collapse-user">
				<li><a href="index.php?page=41" class="am-cf"><span class="am-icon-user-plus"></span> 添加用户</span></a></li>
				<li><a href="index.php?page=42"><span class="am-icon-users"></span> 用户列表 </a></li>
				<li><a href="index.php?page=43"><span class="am-icon-graduation-cap"></span> 管理员列表 </a></li>
			</ul>
		</li>
		<?php endif;?>
		<li><a href="index.php?page=99"><span class="am-icon-question-circle-o"></span> 使用帮助 </a>
        <li><a href="action.php?act=0"><span class="am-icon-sign-out"></span> 注销</a></li>
      </ul>

      <div class="am-panel am-panel-default user-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-bookmark"></span> 公告</p>
          <p>感谢使用MAIN数据平台，任何问题建议请致信service@seamory.com —— MAIN Team</p>
        </div>
      </div>
<!-- 
      <div class="am-panel am-panel-default user-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> wiki</p>
          <p>Welcome to the Amaze UI wiki!</p>
        </div>
      </div> -->
    </div>
  </div>
  <!-- sidebar end -->

  <!-- content start -->
  <div class="user-content">
	<?php
	if($_SESSION['usergroup']=='users'){
		switch($page){
			case 11 : require_once 'editUserInfor.php'; break;
			case 12 : require_once 'changePSW.php'; break;
			case 21 : require_once 'addForm.php'; break;
			case 22	: require_once 'listForm.php'; break;
			case 23 : require_once 'editFormBase.php'; break;
			case 24 : require_once 'editForm.php'; break;
			case 31 : require_once 'addEcs.php'; break;
			case 32 : require_once 'listEcs.php'; break;
			case 33 : require_once 'editEcs.php'; break;
			case 51 : require_once 'addMsgWall.php'; break;
			case 52 : require_once 'listMsgWall.php'; break;
			case 53 : require_once 'editMsgWall.php'; break;
			case 99 : require_once 'help.php'; break;
			default : require_once 'main.php'; break;
		}
	}elseif($_SESSION['usergroup']=='administrators'){
		switch($page){
			case 11 : require_once 'editUserInfor.php'; break;
			case 12 : require_once 'changePSW.php'; break;
			case 21 : require_once 'addForm.php'; break;
			case 22	: require_once 'listForm.php'; break;
			case 23 : require_once 'editFormBase.php'; break;
			case 24 : require_once 'editForm.php'; break;
			case 31 : require_once 'addEcs.php'; break;
			case 32 : require_once 'listEcs.php'; break;
			case 33 : require_once 'editEcs.php'; break;
			case 51 : require_once 'addMsgWall.php'; break;
			case 52 : require_once 'listMsgWall.php'; break;
			case 53 : require_once 'editMsgWall.php'; break;	//PUBLIC
			case 25 : require_once 'listAllForm.php'; break;
			case 34 : require_once 'listAllEcs.php'; break;
			case 40 : require_once 'editUser.php'; break;
			case 41 : require_once 'addUser.php'; break;
			case 42 : require_once 'listUser.php'; break;
			case 43 : require_once 'listAdmin.php'; break;
			case 54 : require_once 'listUserMsgWall.php'; break;
			case 99 : require_once 'help.php'; break;
			default : require_once 'main.php'; break;
		}
	}
/* 		if($page=="11"){
			require_once 'editUserInfor.php';
		}elseif($page=="12"){
			require_once 'changePSW.php';
		}elseif($page=="21"){
			require_once 'addForm.php';
		}elseif($page=="22"){
			require_once 'listForm.php';
		}elseif($page=="23"){
			require_once 'editFormBase.php';
		}elseif($page=="24"){
			require_once 'editForm.php';
		}elseif($page=="31"){
			require_once 'addEcs.php';
		}elseif($page=="32"){
			require_once 'listEcs.php';
		}elseif($page=="33"){
			require_once 'editEcs.php';
		}else{
			require_once 'main.php';
		} */
	/* if($_SESSION['usergroup']=='administrators'){
		if($page=="25"){
			require_once 'listAllForm.php';
		}elseif($page=="34"){
			require_once 'listAllEcs.php';
		}elseif($page=="40"){
			require_once 'editUser.php';
		}elseif($page=="41"){
			require_once 'addUser.php';
		}elseif($page=="42"){
			require_once 'listUser.php';
		}elseif($page=="43"){
			require_once 'listAdmin.php';
		}
	} */
	?>

    <footer class="user-content-footer">
      <hr>
      <p class="am-padding-left">© 2017 MAIN, Team.</p>
    </footer>
  </div>
  <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only user-menu" data-am-offcanvas="{target: '#user-offcanvas'}"></a>

</body>
</html>
