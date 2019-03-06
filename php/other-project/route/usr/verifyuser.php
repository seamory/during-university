<?php
session_start();
#LOADING THE KEY FUNCTION
include_once './mysql.php';
include_once './common.php';

#CONNECT THE DATABASE
connect();
#MAIN
$username=$_POST['username'];
$password=$_POST['password'];
$verify=$_POST['verify'];
if($username && $password && $verify)
	if($_SESSION['verify']==$verify)
	//if($_COOKIE['verify']==$verify)
	{
		$array=query('*', 'ROOTUSER', "username='{$username}'", MYSQL_ASSOC);
		if($password==$array['password'])
		{
			alertMsg('登陆成功','../admin/index.php?pwd=verify');
			$_SESSION['uid']=$array['UID'];
			setcookie('uid',$array['UID']);
		}
		else
		{
			alertMsg('登陆失败','../index.php');
		}
	}
	else
		alertMsg('验证码错误！', '../index.php');
else
	alertMsg('用户输入为空！', '../index.php');
?>