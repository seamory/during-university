<?php
	require_once '../config.php';
	//处理参数
	if($_REQUEST['id']){
		$fmid=$_REQUEST['id'];
	}elseif($_POST['id']){
		$fmid=$_POST['id'];
	}else{
		exit();
	}
	//校验表单
	if(isset($fmid)){
		@$results=mysql::query('*','dm_form',"fmid='{$fmid}'",'one');
		if($results){
			if($results['state']=='1'){
				$topic=mysql::query('*','dm_formbase',"fmid='{$fmid}'",'mul');
				$para=mysql::query('*','dm_formstruct',"fmid='{$fmid}'",'mul');
				if(!$topic){
					common::alertMsg('表单还未填写内容~','index.php');
				}
			}else{
				common::alertMsg('表单还未发布哦~','index.php');
			}
		}else{
			common::alertMsg('表单不存在，请联系表单发布者','index.php');
		}
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $results['fmname'];?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="MAIN">
<meta name="keywords" content="index">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!-- <link rel="icon" type="image/png" href="i/favicon.png"> -->
<!-- <link rel="apple-touch-icon-precomposed" href="i/app-icon72x72@2x.png"> -->
<meta name="apple-mobile-web-app-title" content="Amaze UI" />
<link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
</head>
<body>
<div class="am-g" style="background:rgba(20,20,20,0.1)">
	<div class="am-u-sm-12 am-u-md-10 am-u-lg-8 am-u-sm-centered" style="background:rgba(255,255,255,1);">
	<form action="action.php?act=1&id=<?php echo $fmid;?>" method="post" enctype="application/x-www-form-urlencode" class="am-form" style="margin:0 auto">
	<div class="am-u-sm-11 am-u-md-10 am-u-lg-9 am-u-sm-centered">
		<div class="am-text-center" style="padding:30px 0px 0px 0px">
			<span style="font-size:28px;display:block"><?php echo $results['fmname'];?></span>
			<span class="am-text-left" style="font-size:12px"><?php echo $results['dt'];?></span>
		</div>
		<span style="font-size: 16px;display: block;text-indent: 2em;"><?php echo $results['depiction'];?></span>
		<div class="am-margin-left" style="margin-top:30px">
			<?php for($i=0;$i<sizeof($topic);$i++):?>
			<div>
				<div><?php echo $i+1;?>. <?php echo $topic[$i]['topic'];?></div>
				<?php $text=explode('//',$para[$i]['value']);?>
				
				<?php if($para[$i]['type']=='select'):?>
				<div class="am-form-group" style="width:300px;">
					<select name="topic_<?php echo $i+1;?>[]">
					<?php for($j=0;$j<sizeof($text);$j++):?>
					<option value="<?php echo $text[$j];?>"> <?php echo $text[$j]?> </option>
					<?php endfor;;?>
					</select>
				</div>
				
				<?php elseif($para[$i]['type']=='textarea'):?>
				<?php for($j=0;$j<sizeof($text);$j++):?>
					<div class="am-form-group">
						<?php echo $text[$j];?> <textarea name="topic_<?php echo $i+1;?>[]" rows="5" placeholder="200字以内"></textarea>
					</div>
				<?php endfor;?>
					
				<?php elseif($para[$i]['type']!='text'):?>
				<?php for($j=0;$j<sizeof($text);$j++):?>
				<div class="am-<?php echo $para[$i]['type'];?>">
					<label class="am-<?php echo $para[$i]['type'];?> am-secondary">
						<?php echo $text[$j];?><input type="<?php echo $para[$i]['type'];?>" name="topic_<?php echo $i+1;?>[]" value="<?php echo $text[$j];?>" data-am-ucheck>
					</label>
				</div>
				<?php endfor;?>
				
				<?php else:?>
				<?php for($j=0;$j<sizeof($text);$j++):?>
				<div class="am-form-group" style="width:300px">
					<?php echo $text[$j];?><input type="<?php echo $para[$i]['type'];?>" name="topic_<?php echo $i+1;?>[]">
				</div>
				<?php endfor;?>
				
				<?php endif;?>
			</div>
			<?php endfor;?>
		</div>
		
		<div class="am-text-center" style="padding:20px 0px 30px 0px">
			<button type="submit" class="am-btn am-btn-primary" style="margin-right:20px">提交</button>
			<button type="reset" class="am-btn am-btn-danger">重置</button>
		</div>
	</div>
	</form>
		<div class="am-text-center" style="margin-top:30px;padding-bottom:10px;">
			POWER BY <a href="http://www.maindb.cn">MAIN TEAM.</a>
		</div>
	</div>
</div>
	
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
</body>
</html>