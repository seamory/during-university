<?php
	require_once '../config.php';
	$mwid=$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	if(!$uid){
		exit();
	}else{
		$msgWall=mysql::query('*','dm_msgwall',"mwid='{$mwid}' and uid='{$uid}'",'one',MYSQL_ASSOC);
		if($msgWall){
			$msg=mysql::query('*','dm_msgs',"mwid='{$mwid}'",'one',MYSQL_ASSOC);
		}else{
			exit();
		}
	}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $msgWall['title']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="MAIN">
<meta name="keywords" content="index">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="icon" type="image/png" href="../assets/i/favicon.png">
<link rel="apple-touch-icon-precomposed" href="../assets/i/app-icon72x72@2x.png">
<meta name="apple-mobile-web-app-title" content="Amaze UI" />
<link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
<link rel="stylesheet" href="../assets/css/admin.css">
<!-- <script type="text/javascript" src="https://ajax.microsoft.com/ajax/jquery/jquery-3.1.1.min.js"></script> -->
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
<body style="background:url(<?php echo $msgWall['background']?>);-moz-background-size:100% 100%;background-size:100% 100%;">
<button type="button" class="am-btn am-btn-primary" data-am-modal="{target: '#my-function'}" style="position:absolute">
  ...
</button>

<div class="am-g">
	<div class="am-u-md-8 am-u-sm-centered am-text-center am-text-middle" style="height:60px">
		<div id="title" style="margin-top:30px;font-size:35px;"> <?php echo $msgWall['title'];?> </div>
	</div>
	<div id="msgBox">
	</div>
</div>
<!-- function -->
<div class="am-popup" id="my-function">
  <div class="am-popup-inner" >
    <div class="am-popup-hd">
      <h4 class="am-popup-title">消息墙</h4><!-- title -->
      <span data-am-modal-close
            class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
		<div>
		<div class="am-g">
		  <div class="am-u-md-8 am-u-sm-centered">
			<button type="submit" class="am-btn am-btn-primary am-btn-block" data-am-modal="{target: '#my-luckyDraw'}">抽奖</button>
			<!-- <button type="submit" class="am-btn am-btn-danger am-btn-block" data-am-modal="{target: '#my-popup'}">抽奖设置</button>-->
			<button type="submit" class="am-btn am-btn-danger am-btn-block" data-am-modal="{target: '#my-setting'}">墙设置</button>
		  </div>
		</div>
		</div>
    </div>
  </div>
</div>
<!-- luckyDraw -->
<div class="am-popup" id="my-luckyDraw">
	<div class="am-popup-inner" >
		<div class="am-popup-hd" style="height:80px">
		  <h4 class="am-popup-title" style="height:100px"><button type="submit" id="luckyButton" class="am-btn am-btn-primary am-btn-block" onclick="lucky()" style="font-size:30px">抽奖</button></h4><!-- title -->
		  <span data-am-modal-close class="am-close">&times;</span>
		</div>
		<div class="am-popup-bd" style="margin-top:30px">
			<!-- <div class="am-g">-->
			<!--  <div id="luckyBox" class="am-u-md-8 am-u-sm-centered" > -->
			<div id="luckyBox">
			<!-- <div class="am-text-middle"> -->
			<!-- <img> -->
			<!-- <div class="am-comment-bd"> -->
			<!-- </div> -->
			<!-- <div> -->
			<!-- </div>-->
			<!-- </div>-->
			</div>
		</div>
		</div>
	</div>
</div>
<!-- popup -->
<div class="am-popup" id="my-popup">
  <div class="am-popup-inner" >
    <div class="am-popup-hd">
      <h4 class="am-popup-title">抽奖设置</h4><!-- title -->
      <span data-am-modal-close
            class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
		<div>
		<div class="am-g">
		  <div class="am-u-md-8 am-u-sm-centered" >
			<!-- <div class="am-text-middle"> -->
			<!-- <img> -->
			<!-- <div class="am-comment-bd"> -->
			<!-- </div> -->
			<!-- <div> -->
		  </div>
		</div>
		</div>
    </div>
  </div>
</div>
<!-- setting -->
<div class="am-popup" id="my-setting">
  <div class="am-popup-inner" >
    <div class="am-popup-hd">
      <h4 class="am-popup-title">消息墙配置</h4><!-- title -->
      <span data-am-modal-close
            class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
		<div>
		<div class="am-g">
		  <div class="am-u-md-8 am-u-sm-centered">
			<fieldset class="am-form-set am-form">
			<div class="am-input-group">
				<span class="am-input-group-label">标题颜色</span>
				<input type="text" id="titleColor" value="#FFF" placeholder="标题字体颜色">
			</div>
			<div class="am-input-group">
				<span class="am-input-group-label">标题字体</span>
				<input type="text" id="titleFontFamily" value="微软雅黑" placeholder="标题字体颜色">
			</div>
			<div class="am-input-group">
				<span class="am-input-group-label">标题字体大小</span>
				<input type="text" id="titleFontSize" value="30px" placeholder="标题字体颜色">
			</div>
			</fieldset>
			<button type="submit" class="am-btn am-btn-primary am-btn-block" onclick="setStyle()">保存</button>
			<button type="submit" class="am-btn am-btn-danger am-btn-block">清除</button>
		  </div>
		</div>
		</div>
    </div>
  </div>
</div>
<script>
var lastID=0;
var id=<?php echo (int)$mwid;?>;
var users;
var save=new Array();
function userConnectStyle(background, head_url, name, time, connect)
{
	height=$(window).height();
	var divExt=document.createElement('div');
	divExt.className='am-u-md-8 am-u-sm-centered';
	divExt.style.borderRadius='10px';
	divExt.style.padding='0px';
	divExt.style.marginTop='12px';
	divExt.style.background='url(' + background + ')';
	divExt.style.mozBackgroundSize='100% 100%';
	divExt.style.backgroundSize='100% 100%';
	
	var divFrame=document.createElement('div');
	divFrame.className='';
	divFrame.style.background='rgba(0,0,0,0.3)';
	divFrame.style.padding='20px';
	divFrame.style.borderRadius='10px';
	divFrame.style.height=Number((height-60)/3-25)+'px';

	var header=document.createElement('header');
	header.className='am-text-center';
	header.style='';

	var divInfor=document.createElement('div');
	divInfor.className='am-comment-meta';
	divInfor.style.fontSize='20px';
	divInfor.style.color='#FFF';

	var img=document.createElement('img');
	img.src=head_url;
	img.alt='';
	img.style.width='100px';
	img.style.height='100px';
	img.style.marginTop='5px';
	img.style.borderRadius='10px';
	img.style.display='inline';

	var divConnect=document.createElement('div');
	divConnect.className='am-comment-bd';
	divConnect.style.fontSize='30px';
	divConnect.style.display='inline';
	divConnect.style.color='#FFF';

	divInfor.innerHTML=name + '发布于' + time;
	header.appendChild(divInfor);
	divConnect.innerHTML=connect;

	divFrame.appendChild(header);
	divFrame.appendChild(img);
	divFrame.appendChild(divConnect);
	divExt.appendChild(divFrame);
	
	return divExt;
}

function luckyBoxStyle(background, head_url, name)
{
	var divExt=document.createElement('div');
	divExt.className='am-u-md-12 am-u-sm-centered';
	divExt.style.borderRadius='10px';
	divExt.style.padding='0px';
	divExt.style.marginTop='12px';
	divExt.style.background='url(' + background + ')';
	divExt.style.mozBackgroundSize='100% 100%';
	divExt.style.backgroundSize='100% 100%';
	
	var divFrame=document.createElement('div');
	divFrame.className='am-text-middle';
	divFrame.style.background='rgba(0,0,0,0.3)';
	divFrame.style.padding='20px';
	divFrame.style.borderRadius='10px';
	divFrame.style.height='150px';
	
	var img=document.createElement('img');
	img.src=head_url;
	img.alt='';
	img.style.width='100px';
	img.style.height='100px';
	img.style.marginTop='5px';
	img.style.borderRadius='10px';
	img.style.display='inline';
	
	var divName=document.createElement('div');
	divName.className='am-comment-bd';
	divName.style.fontSize='40px';
	divName.style.display='inline';
	divName.style.color='#FFF';
	
	divName.innerHTML=name;
	divFrame.appendChild(img);
	divFrame.appendChild(divName);
	divExt.appendChild(divFrame);
	
	return divExt;
}

function getMessages() {
	$.ajax({  
		url: 'getMsg.php?act=1&lastID=' + lastID + '&id=' + id,
		dataType: "JSON",
		error: function(){    
			//alert('Error loading JSON document');  
		},
		success: function(data){
			$.each(data,function(i,n){
				message = userConnectStyle(n.background, n.head_url, n.name, n.dt, n.connect);
				$(message).prependTo('#msgBox').hide().slideDown('slow');
				lastID=n.mid;
			});
		}
	});
	window.setTimeout(getMessages, 3000);
}

function getRandomNum(Min,Max)
{   
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}

function getUsers()
{
	$.ajax({  
		url: 'getMsg.php?act=2&id=' + id,
		dataType: "JSON",
		error: function(){    
			//alert('Error loading JSON document');
		},
		success: function(data){
			users=data;
		}
	});
	window.setTimeout(getUsers, 1000);
}

function lucky()
{
	var num=-1;
	var i;
	var bool=true;
	$("#luckyButton").text("抽奖");
	for(key in users){
		num++;
	}
	i = getRandomNum(0,num);
	for(j=0;j<=save.length;j++){
		if(Number(save[j])==i){
			bool=false;
			$("#luckyButton").text("幸运儿已被抽中，请将机会留给他人");
			break;
		}
	}
	if(bool){
		save.push(i);
		message = luckyBoxStyle(users[i].background, users[i].head_url, users[i].name);
		$(message).prependTo('#luckyBox').hide().slideDown('slow');
	}else{
	}
	//$.each(users,function(i,n){
	//});
}


function remove()
{
	var msgbox=document.getElementById("msgBox");
	var div=msgbox.childNodes[3];
	if(msgBox.childNodes.length>3)
		$(div).remove().slideDown('slow');
	window.setTimeout(remove, 1000);
}

function getScreen()
{
	var height=$(window).height();
	return Number((height-60)/3);
}

function setStyle()
{
	var title=document.getElementById("title");
	title.style.color=document.getElementById("titleColor").value;
	title.style.fontFamily=document.getElementById("titleFontFamily").value;
	title.style.fontSize=document.getElementById("titleFontSize").value;
}

getUsers();
remove();
getMessages();

</script>
</body>
</html>