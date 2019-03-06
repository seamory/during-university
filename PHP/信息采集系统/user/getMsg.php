<?php
require_once '../config.php';

$act=$_GET['act'];
switch($act){
	case 1 : msgWall(); break;
	case 2 : LuckyDraw(); break;
}

function JSON($array)
{ 
	$json = json_encode($array);
	return urldecode($json);
}

function msgWall()
{
	$uid=$_SESSION['uid'];
	$id=$_GET['lastID'];
	$mwid=$_GET['id'];
	$msgWall=mysql::query('*','dm_msgwall',"mwid='{$mwid}' and uid='{$uid}'",'one',MYSQL_ASSOC);
	if($msgWall){
		$msgs=mysql::query('*','dm_msgs',"mwid='{$mwid}' and mid>'{$id}' limit 3",'mul',MYSQL_ASSOC);
		echo JSON($msgs);
	}else{
		exit();
	}
}

function LuckyDraw()
{
	$uid=$_SESSION['uid'];
	$mwid=$_GET['id'];
	$msgWall=mysql::query('*','dm_msgwall',"mwid='{$mwid}' and uid='{$uid}'",'one',MYSQL_ASSOC);
	if($msgWall){
		$msgs=mysql::query('*','dm_msgs',"mwid='{$mwid}' group by id",'mul',MYSQL_ASSOC);
		echo JSON($msgs);
	}else{
		exit();
	}
}
?>