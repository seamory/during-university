<?php
function userAction()
{
	$act=$_REQUEST['act'];
	if(isset($act)){
		switch($act){
			case 0 : logout() ; break;
			case 1 : login() ; break;
			case 2 : logon() ; break;
			case 3 : findPSW() ; break;
			case 21 : addform() ; break;
			case 22 : editformbase() ; break;
			case 23 : editform() ; break;
			case 24 : delform() ; break;
			case 25 : deluserform() ; break;
			case 31 : addecs() ; break;
			case 32 : editecs() ; break;
			case 33 : delecs() ; break;
			case 34 : deluserecs() ; break;
			case 51 : adduser() ; break;
			case 52 : delUser() ; break;
			case 53 : editUser() ; break;
			case 61 : editUserInfo() ; break;
			case 62 : changePSW() ; break;
			case 71 : addMsgWall() ; break;
			case 72 : editMsgWall() ; break;
			case 73 : delMsgWall() ; break;
			case 74 : delUserMsgWall() ; break;
			default : break;
		}
	}
}

function checkLogin()
{
	if(!isset($_SESSION['uid'])){
		$url=explode('/',$_SERVER['REQUEST_URI']);
		if($url[sizeof($url)-1]=='index.php' || $url[sizeof($url)-1]==''){
			if($_COOKIE['uid'] && $_COOKIE['usname']){
				$username=$_COOKIE['usname'];
				$uid=$_COOKIE['uid'];
				$password=$_COOKIE['verifyID'];
				@$results=mysql::query('*','dm_user',"uid='{$uid}' and username='{$username}' and password='{$password}'",'one');
				if($results){
					$_SESSION['uid']=$results['uid'];
					$_SESSION['username']=$results['username'];
					$_SESSION['usergroup']=$results['usergroup'];
				}else{
					logout();
					common::alertMsg('要重新登陆地球啦~','login.php');
				}
			}else{
				common::local('login.php');
			}
		}else{
			common::local('login.php');
		}
	}
}

function autologin()
{
	if(!isset($_SESSION['uid'])){
		if($_COOKIE['uid'] && $_COOKIE['usname']){
			$uid=$_COOKIE['uid'];
			$username=$_COOKIE['usname'];
			$password=$_COOKIE['verifyID'];
			@$results=mysql::query('*','dm_user',"uid='{$uid}' and username='{$username}' and password='{$password}'",'one',MYSQL_ASSOC);
			if($results){
				$_SESSION['uid']=$results['uid'];
				$_SESSION['username']=$results['username'];
				$_SESSION['usergroup']=$results['usergroup'];
				common::local('index.php');
			}else{
				logout();
				common::alertMsg('你这是要非法入境么~','login.php');
			}
		}else{
		}
	}else{
		common::local('index.php');
	}
}

function checkAuthority()
{
	if($_SESSION['usergroup']!='administrators'){
		header('location:login.php');
		exit();
	}
}

function logout()
{
	$_SESSION=array();
	setcookie('uid', '', time()-1);
	setcookie('usname', '', time()-1);
	setcookie('verifyID', '', time()-1);
	session_destroy();
	header("location:login.php");
}

function login()
{
	$arr=$_POST;
	$username=$arr['username'];
	$password=md5($arr['password']);
	$uri=explode('/',$_SERVER['REQUEST_URI']);
	if($arr['verify']==$_SESSION['verify']){
		if(!$arr['password']){
			common::alertMsg('密码不能为空!','login.php');
		}else{
			@$results=mysql::query('*', 'dm_user', "username='{$username}' and password='{$password}'",'one');
			if($results){
				if($results['licence']==1){
					$_SESSION['uid']=$results['uid'];
					$_SESSION['username']=$results['username'];
					$_SESSION['usergroup']=$results['usergroup'];
					if($arr['cookie']==1){
						setcookie('uid', $results['uid'], time()+7*24*3600);
						setcookie('usname', $results['username'], time()+7*24*3600);
						setcookie('verifyID', $results['password'], time()+7*24*3600);
					}
					common::local('index.php');
				}else{
					common::alertMsg('被封号了，问问老大什么情况吧~','login.php');
				} 
			}else{
				common::alertMsg('不要进行无谓的尝试哦','login.php');
			}
		}
	}
	else{
		common::alertMsg('小哥，验证马跑咯！','login.php');
	}
}

function logon()
{
	$arr=$_POST;
	if($arr['treaty']==1){
		if($arr['email']){
			if($arr['username']){
				if(strlen($arr['username'])<3){
					common::alertMsg('用户名至少要3个字符哦','login.php?act=2');
				}else{
					if($arr['password']){
						if(strlen($arr['password'])<6){
							common::alertMsg('密码至少要6位哦','login.php?act=2');
						}else{
							@$results=mysql::query('username','dm_user',"username='{$arr['username']}'",'one');
							if($arr['username']==$results['username']){
								common::alertMsg('运气不太好，换个用户名试试？','login.php?act=2');
							}else{
								$password=md5($arr['password']);
								@$result=mysql::insert("'{$arr['username']}','{$password}','users','1'", 'dm_user(username,password,usergroup,licence)');
								@$uid=mysql::query('uid','dm_user',"username='{$arr['username']}'",'one',MYSQL_ASSOC);
								mysql::insert("'{$uid['uid']}','{$arr['email']}'",'dm_userinfor(uid,email)');
								if($result){
									common::alertMsg('注册成功啦~快去登陆试试','login.php');
								}
							}
						}
					}else{
						common::alertMsg('密码不能留空哦','login.php?act=2');
					}
				}
			}else{
				common::alertMsg('用户名不能留空哦','login.php?act=2');
			}
		}else{
			common::alertMsg('邮箱不能留空哦','login.php?act=2');
		}
	}else{
		common::alertMsg('请先阅读用户协议哦','login.php?act=2');
	}
}

function wbLogin()
{
	$_SESSION['url']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if( isset($_SESSION['wbtoken']) && $_SESSION['wbtoken'] ){
		$wb = new SaeTClientV2(WB_KEY, WB_SEC, $_SESSION['wbtoken']['access_token']);
		$user = $wb -> show_user_by_id($_SESSION['wbtoken']['uid']);
		$wbid = $_SESSION['wbtoken']['uid'];
		$access_token = $_SESSION['wbtoken']['access_token'];
		@$isuser = mysql::query('*','dm_weibo',"wbid='{$wbid}'",'one');
		if($isuser){
			if($isuser['access_token']!=$access_token){
				@mysql::update("access_token='{$access_token}'",'dm_weibo',"wbid='{$wbid}'");
			}
			@$results=mysql::query('*','dm_user',"uid='{$isuser['uid']}'",'one');
			if($results){
				if($results['licence']==1){
					$_SESSION['uid']=$results['uid'];
					$_SESSION['username']=$results['username'];
					$_SESSION['usergroup']=$results['usergroup'];
					$_SESSION['wbtoken']=null;
					common::local('index.php');
				}else{
					$_SESSION['wbtoken']=null;
					common::alertMsg('被封号了，问问老大什么情况吧~','login.php');
				} 
			}else{
				$_SESSION['wbtoken']=null;
				common::alertMsg('注册出现了问题导致无法登陆','login.php');
			}
		}else{
			if($user['name']){
				@$result=mysql::insert("'{$user['name']}','{$wbid}','users','1'",'dm_user(username,password,usergroup,licence)');
				@$results=mysql::query('*','dm_user',"username='{$user['name']}'",'one',MYSQL_ASSOC);
				@mysql::insert("'{$results['uid']}','{$wbid}','{$access_token}'",'dm_weibo(uid, wbid, access_token)');
				$_SESSION['uid']=$results['uid'];
				$_SESSION['username']=$results['username'];
				$_SESSION['usergroup']=$results['usergroup'];
				$_SESSION['access_token']=null;
				if($result){
					common::alertMsg('注册成功，您的登陆密码为空，请及时修改','index.php?page=12');
				}else{
					common::alertMsg('注册失败，请联系管理员','login.php');
				}
			}else{
				$_SESSION['wbtoken']=null;
				common::alertMsg('注册失败，微博暂未授权您的登陆，请使用账号登陆','login.php');
			}
		}
	}
}

function wbBind()
{
	$uid=$_SESSION['uid'];
	if( isset($_SESSION['wbtoken']) && $_SESSION['wbtoken'] ){
		$wbid=$_SESSION['wbtoken']['uid'];
		$access_token=$_SESSION['wbtoken']['access_token'];
		@$isuser=mysql::query('*','dm_weibo',"wbid='{$wbid}'",'one',MYSQL_ASSOC);
		if(!$isuser){
			@$result=mysql::insert("'{$uid}','{$wbid}','{$access_token}'",'dm_weibo(uid, wbid, access_token)');
			$_SESSION['wbtoken']=null;
			if($result){
				common::alertMsg('绑定成功','index.php');
			}else{
				common::alertMsg('绑定失败','index.php');
			}
		}else{
			$_SESSION['wbtoken']=null;
			common::alertMsg('绑定失败,此微博号已经绑定用户或者已经注册','index.php');
		}
	}else{
		$_SESSION['wbtoken']=null;
		common::local('../oAuth/weibo/wblogin.php');
	}
}

function findPSW()
{
	$arr=$_POST;
	if($arr[verify]==$_SESSION['verify']){
		@$username=mysql::query('uid,username','dm_user',"username='{$arr['username']}'",'one');
		if($username){
			if(!$arr['email']){
				common::alertMsg("邮箱不能为空哦",'login.php');
			}else{
				@$email=mysql::query('*','dm_userinfor',"uid='{$username['uid']}'",'one');
				if($email['email']==$arr['email']){
					$string=join('',array_merge(range(0,9),range('a','z')));//,range('A','Z')));
					$password=substr(str_shuffle($string),0,6);
					$psw=md5($password);
					$result=mysql::update("password='{$psw}'",'dm_user',"uid='{$username['uid']}'");
					if($result){
						$str='新密码为:'.$password.'登陆后记得修改密码哦~';
						common::alertMsg($str,'login.php');
					}else{
						common::alertMsg("出了点问题，再试试吧",'login.php');
					}
				}else{
					common::alertMsg('邮箱输入错咯~','login.php');
				}
			}
		}else{
			common::alertMsg('没有这个用户名吖~再想想呢？','login.php');
		}
	}else{
		common::alertMsg('不要着急，验证马选错啦~','login.php');
	}
}

function addform()
{
	$arr=$_POST;
	$uid=$_SESSION['uid'];
	if($arr['fm']){
		@$result=mysql::insert("'{$uid}','{$arr['fm']}','{$arr['date']}','{$arr['depiction']}','{$arr['switch']}'",'dm_form(uid,fmname,dt,depiction,state)');
		if($result)
			common::alertMsg('添加成功','index.php?page=22');
		else
			common::alertMsg('添加失败','index.php?page=21');
	}else{
		common::alertMsg('问卷名称不能为空哦','index.php?page=21');
	}
}

function editform()
{
	$fmid=(int)$_REQUEST['id'];
	print_r($fmid);
	$uid=$_SESSION['uid'];
 	$arr=$_POST;
 	if($arr['fmname']){
		@$result=mysql::update("fmname='{$arr['fmname']}',state='{$arr['switch']}',depiction='{$arr['depiction']}'",'dm_form',"fmid='{$fmid}' and uid='{$uid}'");
		if($result)
			common::alertMsg('修改成功','index.php?page=22');
		else
			common::alertMsg('修改失败',"index.php?page=24&id=$fmid");
	}else{
		common::alertMsg('问卷名称不能为空哦',"index.php?page=24&id=$fmid");
	}
}

function editformbase()
{
	$fmid=(int)$_REQUEST['id'];
	$arr=$_POST;
	@$result=mysql::query('*','dm_formbase',"fmid='{$fmid}'",'one');
	if($result){
		@mysql::del('dm_formbase',"fmid='{$fmid}'");
		@mysql::del('dm_formstruct',"fmid='{$fmid}'");
		$i=1;
		if($arr) foreach( $arr['topic'] as $key => $val ){
			@$result=mysql::insert("'{$fmid}','{$i}','{$val}'",'dm_formbase(fmid,topicID,topic)');
			@$result=mysql::insert("'{$fmid}','{$i}','{$arr['intype'][$i]}','{$arr['value'][$i]}'",'dm_formstruct(fmid,topicID,type,value)');
			$i++;
		}
	}else if($arr){
		$i=1;
		if($arr) foreach( $arr['topic'] as $key => $val ){
			@$result=mysql::insert("'{$fmid}','{$i}','{$val}'",'dm_formbase(fmid,topicID,topic)');
			@$result=mysql::insert("'{$fmid}','{$i}','{$arr['intype'][$i]}','{$arr['value'][$i]}'",'dm_formstruct(fmid,topicID,type,value)');
			$i++;
		}
	}
	if($result)
		common::alertMsg('编辑成功','index.php?page=22');
	else
		common::alertMsg('编辑失败',"index.php?page=23&id=$fmid");
}

function delform()
{
	$fmid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	@$results=mysql::query('*','dm_form',"fmid='{$fmid}' and uid='{$uid}'",'one');
	if(!empty($results)){
		@$result=mysql::del('dm_form',"fmid='{$fmid}'");
		@mysql::del('dm_formbase',"fmid='{$fmid}'");
		@mysql::del('dm_formstruct',"fmid='{$fmid}'");
		@mysql::del('dm_formresult',"fmid='{$fmid}'");
		if($result){
			common::alertMsg('删除成功','index.php?page=22');
		}else{
			common::alertMsg('删除失败','index.php?page=22');
		}
	}
	else{
		common::alertMsg('删除失败','index.php?page=22');
	}
}

function deluserform()
{
	$fmid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	@$usergroup=mysql::query('usergroup','dm_user',"uid='{$uid}'",'one',MYSQL_ASSOC);
	if($usergroup['usergroup']=='administrators'){
		@$result=mysql::del('dm_form',"fmid='{$fmid}'");
		@mysql::del('dm_formbase',"fmid='{$fmid}'");
		@mysql::del('dm_formstruct',"fmid='{$fmid}'");
		if($result){
			common::alertMsg('删除成功','index.php?page=25');
		}else{
			common::alertMsg('删除失败','index.php?page=25');
		}
	}
	else{
		common::alertMsg('删除失败','index.php?page=25');
	}
}

function addecs()
{
	$arr=$_POST;
	$uid=$_SESSION['uid'];
	if($arr['name']){
		@$result=mysql::insert("'{$uid}','{$arr['name']}','{$arr['date']}','{$arr['sdb']}','{$arr['switch']}'",'dm_eclass(uid,ecname,dt,sdb,state)');
		if($result)
			common::alertMsg('添加成功','index.php?page=32');
		else
			common::alertMsg('添加失败','index.php?page=31');
	}else{
		common::alertMsg('名称不能为空哦~','index.php?page=31');
	}
}

function editecs()
{
	$ecid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	$arr=$_POST;
	if($arr['name']){
		@$result=mysql::update("ecname='{$arr['name']}',state='{$arr['switch']}'",'dm_eclass',"ecid='{$ecid}' and uid='{$uid}'");
		if($result)
			common::alertMsg('修改成功','index.php?page=32');
		else
			common::alertMsg('修改失败',"index.php?page=33&id=$ecid");
	}else{
		common::alertMsg('名称不能为空哦',"index.php?page=33&id=$ecid");
	}
}

function delecs()
{
	$ecid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	@$results=mysql::query('*','dm_eclass',"ecid='{$ecid}' and uid='{$uid}'",'one');
	if(!empty($results)){
		@$result=mysql::del('dm_eclass',"ecid='{$ecid}'");
		@mysql::del('dm_ecs',"ecid='{$ecid}'");
		if($result){
			common::alertMsg('删除成功','index.php?page=32');
		}else{
			common::alertMsg('删除失败','index.php?page=32');
		}
	}
	else{
		common::alertMsg('删除失败','index.php?page=32');
	}
}

function deluserecs()
{
	$ecid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	@$usergroup=mysql::query('usergroup','dm_user',"uid='{$uid}'",'one',MYSQL_ASSOC);
	if($usergroup['usergroup']=='administrators'){
		@$result=mysql::del('dm_eclass',"ecid='{$ecid}'");
		@mysql::del('dm_ecs',"ecid='{$ecid}'");
		if($result){
			common::alertMsg('删除成功','index.php?page=34');
		}else{
			common::alertMsg('删除失败','index.php?page=34');
		}
	}
	else{
		common::alertMsg('删除失败','index.php?page=34');
	}
}

function adduser()
{
	$arr=$_POST;
	switch($arr['UG']){
		case 0: $ug='administrators'; break;
		case 1: $ug='users'; break;
	}
	$username=$arr['username'];
	@$results=mysql::query('username','dm_user',"username='{$username}'",'one');
	if($arr['username']==$results['username']){
		common::alertMsg('该用户已存在','index.php?page=41');
	}
	else{
		$password=md5($arr['password']);
		@$result=mysql::insert("'{$arr['username']}','{$password}','{$ug}',{$arr['switch']}", 'dm_user(username,password,usergroup,licence)');
		@$uid=mysql::query('uid','dm_user',"username='{$arr['username']}'",'one',MYSQL_ASSOC);
		mysql::insert("'{$uid['uid']}'",'dm_userinfor(uid)');
		if($result)
			if($arr['UG']==0)
				common::alertMsg('添加管理员成功','index.php?page=43');
			else if($arr['UG']==1)
				common::alertMsg('添加用户成功','index.php?page=42');
	}
}

function delUser()
{
	$uid=(int)$_REQUEST['id'];
	@$result=mysql::del('dm_user', "uid='{$uid}'");
	@mysql::del('dm_weibo',"uid='{$uid}'");
	if($result){
		common::alertMsg('删除成功','index.php');
	}else{
		common::alertMsg('删除失败','index.php');
	}
}

function editUser()
{
	$uid=(int)$_REQUEST['id'];
	$arr=$_POST;
	$password=md5($arr['password']);
	@$results=mysql::query('username,usergroup','dm_user',"uid='{$uid}'",'one',MYSQL_ASSOC);
	if($arr['password']){
		@$result=mysql::update("password='{$password}',licence='{$arr['switch']}'",'dm_user',"uid='{$uid}'");
	}else{
		@$result=mysql::update("licence='{$arr['switch']}'",'dm_user',"uid='{$uid}'");
	}
	if($result){
		if($results['usergroup']=='administrators')
			common::alertMsg('修改信息成功','index.php?page=43');
		else if($results['usergroup']=='users')
			common::alertMsg('修改信息成功','index.php?page=42');
	}else{
		common::alertMsg('修改信息失败',"index.php?page=40&id=$uid");
	}
}

function editUserInfo()
{
	$arr=$_POST;
	if($arr){
		if(!$arr['email']){
			common::alertMsg('邮箱不能为空哦','index.php?page=11');
		}else{
			@$result=mysql::update("name='{$arr['name']}',sex='{$arr['sex']}',age='{$arr['age']}',email='{$arr['email']}',tel='{$arr['tel']}',qq='{$arr['oicq']}',wechat='{$arr['wechat']}'",'dm_userinfor',"uid='{$_SESSION['uid']}'");
			if($result){
				common::alertMsg('修改成功','index.php?page=11');
			}else{
				common::alertMsg('修改失败','index.php?page=11');
			}
		}
	}
}

function changePSW()
{
	$arr=$_POST;
	if($arr){
		$username=$_SESSION['username'];
		$password=md5($arr['opwd']);
		$opsw=mysql::query('password','dm_user',"username='{$username}' and password='{$password}'");
		$opwd=mysql::query('password','dm_user',"username='{$username}' and password='{$arr['opwd']}'");	//for weibo user
		if($opsw || $opwd){
			if($arr['npwd'][0]==$arr['npwd'][1]){
				if(strlen($arr['npwd'][1])<6){
					common::alertMsg('密码至少要6位哦','index.php?page=12');
					exit();
				}else{
					$password=md5($arr['npwd'][1]);
					@$result=mysql::update("password='{$password}'",'dm_user',"username='{$username}'");
					if($result){
						$_SESSION=array();
						setcookie('uid', '', time()-1);
						setcookie('usname', '', time()-1);
						setcookie('verifyid', '', time()-1);
						session_destroy();
						common::alertMsg('修改成功,请重新登陆','index.php');
					}else{
						common::alertMsg('原密码和新密码不能一样哦','index.php?page=12');
					}
				}
			}else{
				common::alertMsg('小伙子，两次密码不一样吖~','index.php?page=12');
			}
		}else{
			common::alertMsg('哎呀呀，原密码错误啦~','index.php?page=12');
		}
	}
}

function addMsgWall()
{
	$uid=$_SESSION['uid'];
	if($_POST){
		$arr=$_POST;
		if(!$arr['title']){
			common::alertMsg('主题不能为空哦','index.php?page=51');
		}else{
			$result=mysql::insert("'{$uid}','{$arr['title']}','{$arr['topic']}','{$arr['sdt']}','{$arr['edt']}','{$arr['switch']}','{$arr['background']}'",'dm_msgwall(uid,title,topic,sdt,edt,state,background)');
			if($result){
				common::alertMsg('保存成功','index.php?page=52');
			}else{
				common::alertMsg('保存失败','index.php?page=51');
			}
		}
		
	}
}

function editMsgWall()
{
	$uid=$_SESSION['uid'];
	$mwid=(int)$_REQUEST['id'];
	if($_POST){
		$arr=$_POST;
		$result=mysql::update("title='{$arr['title']}',topic='{$arr['topic']}',sdt='{$arr['sdt']}',edt='{$arr['edt']}',state='{$arr['switch']}',background='{$arr['background']}'",'dm_msgwall',"mwid='{$mwid}' and uid='{$uid}'");
		if($result){
			common::alertMsg('修改成功','index.php?page=52');
		}else{
			common::alertMsg('修改失败','index.php?page=52');
		}
	}
}

function delMsgWall()
{
	$mwid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	@$results=mysql::query('*','dm_msgwall',"mwid='{$mwid}' and uid='{$uid}'",'one');
	if(!empty($results)){
		@$result=mysql::del('dm_msgwall',"mwid='{$mwid}'");
		@mysql::del('dm_msgs',"mwid='{$mwid}'");
		if($result){
			common::alertMsg('删除成功','index.php?page=52');
		}else{
			common::alertMsg('删除失败','index.php?page=52');
		}
	}
	else{
		common::alertMsg('删除失败','index.php?page=52');
	}
}

function delUserMsgWall()
{
	$mwid=(int)$_REQUEST['id'];
	$uid=$_SESSION['uid'];
	@$usergroup=mysql::query('usergroup','dm_user',"uid='{$uid}'",'one',MYSQL_ASSOC);
	if($usergroup['usergroup']=='administrators'){
		@$result=mysql::del('dm_msgwall',"mwid='{$mwid}'");
		@mysql::del('dm_msgs',"mwid='{$mwid}'");
		if($result){
			common::alertMsg('删除成功','index.php?page=54');
		}else{
			common::alertMsg('删除失败','index.php?page=54');
		}
	}
	else{
		common::alertMsg('删除失败','index.php?page=54');
	}
}

?>