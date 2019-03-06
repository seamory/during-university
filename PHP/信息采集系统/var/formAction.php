<?php
function formAction()
{
	$act=$_REQUEST['act'];
	switch($act){
		case 1 : saveform(); break;
		case 3 : saveecs(); break;
		case 2 : toform(); break;
		case 4 : toecs(); break;
		case 5 : toMsgWall(); break;
		default : break;
	}
}

//保存表单
function saveform()
{
	$fmid=(int)$_REQUEST['id'];
	if(!empty($_POST)){
		if(checkip($fmid)){
			$arr=$_POST;
			$uip=$_SERVER['REMOTE_ADDR'];
			foreach($arr as $key => $val){
				preg_match_all('/(\d+)/',$key, $out, PREG_SET_ORDER);
				@$val=join('、',$val);
				mysql::insert("'{$fmid}','{$uip}','{$out[0][0]}','{$val}'",'dm_formresult(fmid,ip,topicid,topicresult)');
			}
			$result=mysql::insert("'{$fmid}','{$uip}'",'dm_ip(fmid,ip)');
			common::local('thanks.php');
		}else{
			common::alertMsg("你的厚爱我已经感受到咯，但是一个IP只能填写一次哦(?>?<?）",'thanks.php');
		}
	}else{
		common::alertMsg("既然来了，总要留下点什么嘛~","../index.php?act=2&id=$fmid");
	}
}

function saveecs()
{
	$ecid=(int)$_REQUEST['id'];
	$url='http://www.maindb.cn/index.php?act=4&id='.$ecid;
	$arr=$_POST;
	if(checkEcsId){
		checkEcsName($arr['name'],$ecid);
		if(!$arr['name']){
			common::alertMsg('姓名不能为空', $url);
		}else{
			if($arr['val']){
				for($i=0;$i<sizeof($arr['val']);$i++){
					$class=(int)($arr['val'][$i]/7)+1;
					$weekday=$arr['val'][$i]%7+1;
					$result=mysql::insert("'{$ecid}','{$arr['name']}','{$arr['name']}','11','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
				}
			}else{
				for($i=0;$i<sizeof($arr['vals']);$i++){
					$class=(int)($arr['vals'][$i]/7)+1;
					$weekday=$arr['vals'][$i]%7+1;
					$result=mysql::insert("'{$ecid}','{$arr['name']}','{$arr['name']}','10','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
				}
				for($i=0;$i<sizeof($arr['vald']);$i++){
					$class=(int)($arr['vald'][$i]/7)+1;
					$weekday=$arr['vald'][$i]%7+1;
					$result=mysql::insert("'{$ecid}','{$arr['name']}','{$arr['name']}','20','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
				}
			}
			common::local('thanks.php');
		}
	}else{
		common::alertMsg('幺幺零，有人想非礼我!','index.php');
	}
}

function toform()
{
	$fmid=$_REQUEST['id'];
	$url='usr/form.php?id='.$fmid;
	common::local("$url");
}

function toecs()
{
	$ecid=$_REQUEST['id'];
	$url='usr/eclass.php?id='.$ecid;
	common::local("$url");
}

function toMsgWall()
{
	$mwid=$_REQUEST['id'];
	$url='usr/msg.php?id='.$mwid;
	common::local("$url");
}

//检查ID参数是否合法
function checkEcsId($ecid)
{
	@$results=mysql::query('*','dm_eclass',"ecid='{$ecid}'",'one',MYSQL_ASSOC);
	if($results){
		return true;
	}else{
		return false;
	}
}
//检查是否填写过资料
function checkEcsName($name,$ecid)
{
	@$results=mysql::query('name','dm_ecs',"name='{$name}'",'one',MYSQL_ASSOC);
	if($results){
		mysql::del('dm_ecs',"name='{$name}' and ecid='{$ecid}'");
	}
}
//检查IP地址，作为存储数据的直接调用
function checkip($fmid)
{
	$uip=$_SERVER['REMOTE_ADDR'];
	@$results=mysql::query('*','dm_ip',"ip='{$uip}' and fmid='{$fmid}'",'one',MYSQL_ASSOC);
	if($results)
		if($uip==$results['ip']){
			return false;
		}
		else{
			return true;
		}
	else{
		return true;
	}
}
?>