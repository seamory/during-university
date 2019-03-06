<?php
	require_once '../config.php';
	if($_REQUEST['act'])
		$act=$_REQUEST['act'];
	else
		$act=1;
	autologin();
	if($_GET['wb']=='login'){
		$_SESSION['url']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		wbLogin();
		common::local('../oAuth/weibo/wblogin.php');
	}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title><?php echo $out=$act==1?'MAIN系统登陆用户登陆':'用户注册';?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link rel="alternate icon" type="image/png" href="../assets/i/favicon.png">
	<link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
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
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <h1>MAIN</h1>
    <p>MAIN DATE MANAGEMENT SYSTEM<br/>问卷发布，空课表生成，数据采集</p>
  </div>
  <hr />
</div>
<?php if($act==1):?>
<div class="am-g">
	<div class="am-u-lg-3 am-u-md-5 am-u-sm-centered">
      <h3>登录</h3>
		<hr>
		<div class="am-btn-group">
			<a href="login.php?wb=login" ><img src="../assets/i/weibo_login.png" alt="" width="60%" height="60%"></a>
		  <!--<a href="#" class="am-btn am-btn-secondary am-btn-sm"><i class="am-icon-github am-icon-sm"></i> Github</a>
		  <a href="#" class="am-btn am-btn-success am-btn-sm"><i class="am-icon-google-plus-square am-icon-sm"></i> Google+</a>
		  <a href="#" class="am-btn am-btn-primary am-btn-sm"><i class="am-icon-stack-overflow am-icon-sm"></i> stackOverflow</a>-->
		</div>
		<form action="action.php?act=1" method="post" enctype="application/x-www-form-urlencoded" class="am-form">
			<span>用户名:</span>
			<input type="text" name="username">
			<span>密码:</span>
			<input type="password" name="password">
			<span>验证码:</span><img src='vimage.php' alt="">
			<input type="text" name="verify">
			<span class="am-text-middle" style="font-size:12px;vertical-align:middle;">一周内自动登陆</span>
			<input type="checkbox" name="cookie" value="1" class="" style="vertical-align:middle;">
			<span style="position:relative;left:50px;font-size:15px;vertical-align:middle;"><a data-am-modal="{target: '#my-popup'}">忘记密码?</a></span>
			<div>
				<button type="submit" class="am-btn am-btn-default am-round">登陆</button>
			</div>
		</form>
	</div>
</div>

<div class="am-popup" id="my-popup">
  <div class="am-popup-inner">
	<div class="am-popup-hd">
	  <h4 class="am-popup-title">找回密码</h4>
	  <span data-am-modal-close class="am-close">&times;</span>
	</div>
	<div class="am-popup-bd">
	<div class="am-g">
	  <div class="am-u-md-8 am-u-sm-centered">
		<form action="action.php?act=3" method="post" enctype="urlencode" class="am-form">
		  <fieldset class="am-form-set">
			<div class="am-input-group">
			  <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
			  <input type="text" name="username" class="am-form-field" placeholder="注册用户名">
			</div>

			<div class="am-input-group">
			  <span class="am-input-group-label"><i class="am-icon-bookmark am-icon-fw"></i></span>
			  <input type="email" name="email" class="am-form-field" placeholder="注册邮箱">
			</div>
			
			<div class="am-input-group">
			  <span class="am-input-group-label" style="background:#FFF"><img src="vimage.php"alt=""></span>
			  <input type="text" name="verify" class="am-form-field" placeholder="请选择一匹验证马">
			</div>
		  </fieldset>
		  <button type="submit" class="am-btn am-btn-primary am-btn-block">生成新密码</button>
		</form>
	  </div>
	</div>
	</div>
  </div>
</div>
<?php elseif($act==2):?>
<div class="am-g">
	<div class="am-u-lg-3 am-u-md-5 am-u-sm-7 am-u-sm-centered">
      <h3>注册</h3>
      	<div class="am-btn-group">
			<a href="login.php?wb=login" ><img src="../assets/i/weibo_login.png" alt="" width="60%" height="60%"></a>
		  <!--<a href="#" class="am-btn am-btn-secondary am-btn-sm"><i class="am-icon-github am-icon-sm"></i> Github</a>
		  <a href="#" class="am-btn am-btn-success am-btn-sm"><i class="am-icon-google-plus-square am-icon-sm"></i> Google+</a>
		  <a href="#" class="am-btn am-btn-primary am-btn-sm"><i class="am-icon-stack-overflow am-icon-sm"></i> stackOverflow</a>-->
		</div>
		<hr>
		<form action="action.php?act=2" method="post" enctype="application/x-www-form-urlencoded" class="am-form">
		<span >用户名</span><span style="font-size:12px;"> (用户名至少3个字符) </span>
		<input type="text" name="username" >
		<span >密码</span><span style="font-size:12px;"> (密码长度不小于6位) </span>
		<input type="password" name="password" id="pwd" >
		<span >确认密码</span>
		<input type="password" name="password" id="rpwd" onblur="check()">
		<span id="pwd_notice"></span>
		<span >邮箱</span><span style="font-size:12px;"> (这将作为您找回密码的唯一依据) </span>
		<input type="email" name="email">
		<span class="am-text-middle" style="font-size:12px">我已阅读<a data-am-modal="{target: '#my-popup'}">用户协议</a></span>
		<input type="checkbox" name="treaty" value="1" class="am-text-middle">
		<div>
			<button type="submit" class="am-btn am-btn-default am-round">注册</button>
		</div>
		</form>
	</div>
</div>

<div class="am-popup" id="my-popup">
  <div class="am-popup-inner">
	<div class="am-popup-hd">
	  <h4 class="am-popup-title">用户协议</h4>
	  <span data-am-modal-close class="am-close">&times;</span>
	</div>
	<div class="am-popup-bd">
		<?php require_once 'licence.php';?>
	</div>
  </div>
</div>
<?php endif;?>
</body>
</html>