<?php
require_once '../config.php';
checkLogin();
$fmid=$_REQUEST['id'];
@$form=mysql::query('*','dm_form',"fmid='{$fmid}'",'one');
if(!$form){
	exit();
}else{
	@$result=mysql::query('ip','dm_ip',"fmid='{$fmid}'",'mul',MYSQL_ASSOC);
	for($i=0;$i<sizeof($result);$i++){
		$ip[$i]=$result[$i]['ip'];
	}
	@$result=mysql::query('topic','dm_formbase',"fmid='{$fmid}'",'mul',MYSQL_ASSOC);
	for($i=0;$i<sizeof($result);$i++){
		$topic[$i]=$result[$i]['topic'];
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $form['fmname'];?></title>
<style type="text/css">
*{
	font-family:"微软雅黑";
}
#ecs{
	/* background:url(../image/bgimage.jpg) no-repeat center center */
}
#ecs_main{
	margin:0 auto;
	display:table;
	padding:10px 50px 10px 50px;
	background:rgba(255,255,255,0.5);
	border-radius:5px;
}
.title{
	margin:0 auto;
	padding:0px 0px 5px 0px;
	font-size:25px;
	text-align:center;
	display:table;
}
.time{
	margin:0 auto;
	padding:10px;
	font-size:10px;
	text-align:right;
	display:table;
}
.classEmptySheet{
	display:inline-table;
	margin:5px 10px 0px 10px;
	/* border:solid 1px rgba(0,0,0,1); */
	width:100%;
	text-align:center;
}
th{
	font-size:10px;
	border:solid 1px rgba(0,0,0,1);
}
table td{
	border:solid 1px rgba(0,0,0,1);
	font-size:15px;
}
</style>
</head>
<body>
	<table class="classEmptySheet">
		<thead>
			<tr>
				<th width="50px">用户</th>
				<?php for($i=0;$i<sizeof($topic);$i++):?>
				<th style="font-size:12px;"><?php echo $topic[$i];?></th>
				<?php endfor;?>
			</tr>
		</thead>
		<tr>
			<?php for($i=0;$i<sizeof($ip);$i++):?>
			<td><?php echo $i+1;?></td>
			<?php 
				for($j=1;$j<=sizeof($topic);$j++):
					@$val=mysql::query('topicresult','dm_formresult',"ip='{$ip[$i]}' and fmid='{$fmid}' and topicid='{$j}'",'one',MYSQL_ASSOC);
			?>
			<td style="font-size:12px;"><?php echo $val['topicresult'];?></td>
			<?php endfor;?>
			</tr>
			<?php endfor;?>
	</table>
</body>
</html>