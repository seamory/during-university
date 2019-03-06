<?php
 	require_once '../config.php';
  	$mwid=(int)$_GET['id'];
	$_SESSION['url']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$msgWall=mysql::query('*','dm_msgwall',"mwid='{$mwid}'",'one');
	if(!$msgWall){
		common::local('index.php');
	}
	
	if( isset($_SESSION['wbtoken']) && $_SESSION['wbtoken'] ){
		$_SESSION['temp_token']=$_SESSION['wbtoken'];	//单独生成一个不与其他变量冲突的全局变量
		$_SESSION['wbtoken']=null;	//销毁此变量
	};
	
	if( isset($_SESSION['temp_token']) && $_SESSION['temp_token'] ){
		$token=$_SESSION['temp_token'];
		$wb = new SaeTClientV2(WB_KEY, WB_SEC, $token['access_token']);
		$user = $wb->show_user_by_id($token['uid']);
	}
	
	if($_POST){
		$arr=$_POST;
		$times=mysql::query('*','dm_msgs',"id='{$arr['id']}' and mwid='{$mwid}'",'mul',MYSQL_ASSOC);
		if(sizeof($times)>2){
			unset($_POST);
			unset($arr);
			common::alert('您已达最大发言次数，发言次数不会影响抽奖的概率');
		}else{
			if($arr['id'] && $arr['connect']){
				mysql::insert("'{$mwid}','{$arr['name']}','{$arr['head_url']}','{$arr['id']}','{$arr['connect']}','{$arr['dt']}','{$arr['platform']}','{$arr['background']}'",'dm_msgs(mwid,name,head_url,id,connect,dt,platform,background)');
				$str=urlencode($arr['connect'].'分享自:http://mw.myworldbooks.cn');
				unset($_POST);
				unset($arr);
				$wb->update($str);
			}else{
				common::alert('留言不能为空');
			}
		}
	};
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>用户留言</title>
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
</head>
<body>
<?php if(!$msgWall['state']):?>
	<div class="am-text-center">
		<div>暂时还未开放发言哦</div>
	</div>
<?php else:?>
<?php if($token):?>
<div class="am-g">
	<div class="am-u-md-8 am-u-sm-centered">
		<h3 class="am-text-center"><?php echo $msgWall['title'];?></h3>
	</div>
	<div id="wb_connect_btn" ></div>
	<div class="am-u-md-8 am-u-sm-centered">
		<form action="msg.php?id=<?php echo $mwid;?>" method="post" enctype="appliction/x-www-form-urlencode" class="am-form">
			<fieldset class="am-form-set">
				<article class="am-comment am-comment-primary"> <!-- 评论容器 -->
					<a href="">
						<img class="am-comment-avatar" src="<?php echo $user['avatar_large'];?>" alt=""/> <!-- 评论者头像 -->
					</a>
					<div class="am-comment-main"> <!-- 评论内容容器 -->
						<header class="am-comment-hd">
						  <!--<h3 class="am-comment-title">评论标题</h3>-->
						  <div class="am-comment-meta"> <!-- 评论元数据 -->
							<a href="#link-to-user" class="am-comment-author"> 
								<?php echo $user['name'];?>
							</a> <!-- 评论者 -->
							发布 <time datetime=""><?php echo $id['dt'];?></time>
						  </div>
						</header>
						<div class="am-comment-bd">
							<textarea name="connect" class="am-form-field" rows="5" placeholder="留言(必填,200字以内)(您的发言将会同步至您的微博)"></textarea> </div> <!-- 评论内容 -->
						</div>
				</article>				
				<input type="hidden" name="name" class="am-form-field" value="<?php echo $user['name'];?>" >
				<input type="hidden" name="head_url" class="am-form-field" value="<?php echo $user['avatar_large'];?>">
				<input type="hidden" name="id" class="am-form-field" value="<?php echo $token['uid'];?>" >
				<input type="hidden" name="dt" class="am-form-field" value="<?php echo time::getTime();?>" >
				<input type="hidden" name="platform" class="am-form-field" value="weibo" >
				<input type="hidden" name="background" class="am-form-field" value="<?php echo $user['cover_image_phone'];?>">
			</fieldset>
			<div class="am-u-md-3 am-u-sm-centered">
				<button type="submit" class="am-btn am-btn-primary am-btn-block am-u-md-2">提交上墙</button>
			</div>
		</form>
	</div>
<?php else:?>
	<div class="am-text-center">
		<div style="font-size:13px">您所参与的主题是：</div>
		<div style="font-size:30px"><?php echo $msgWall['title']?></div>
		<div style="font-size:15px">请先登陆后再发言哦</div>
		<a href="../oAuth/weibo/wblogin.php"><img src="../assets/i/weibo_login.png" alt=""></a>
	</div>
<?php endif;?>
<?php endif;?>
</div>
</body>
</html>