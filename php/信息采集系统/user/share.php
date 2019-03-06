<?php
$act=$_REQUEST['act'];
$id=$_REQUEST['id'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>分享</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <meta name="description" content="MAIN">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="assets/css/user.css">
</head>
<body>
	<div class="am-g" style="margin:0 auto">
		<div>请将以下链接复制粘贴到您想分享的地方</div>
		<div>表单访问链接：<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/DMsystem/index.php?act='.$act.'&id='.$id;?>"><?php echo 'http://'.$_SERVER['SERVER_NAME'].'/DMsystem/index.php?act='.$act.'&id='.$id;?></a></div>
	</div>
</body>
</html>