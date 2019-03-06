<?php
require_once '../usr/mysql.php';
require_once '../usr/common.php';
connect();
#PUBILC
$type=$_REQUEST['type'];
#INSERT
if($type=='insert')
{
	$sdomain=$_POST['sdomain'];
	$sfield=$_POST['sfield'];
	$ssel=$_POST['ssel'];
}
#DELETE
else if($type=='del')
	$field=$_REQUEST['field'];
#UPDATE
else if($type=='update')
{
$select=$_POST['select'];
$keyfield=$_POST['keyfield'];
$sidval=$_POST['sidval'];
$sfieldval=$_POST['sfieldval'];
$sselval=$_POST['sselval'];
if($select=='sid')
{
	$updateCondition=$select."=".$sidval;
	$updateField=$select."=".$keyfield;
}
else if($select=='sfield')
{
	$updateCondition=$select."='".$sfieldval."'";
	$updateField=$select."='".$keyfield."'";
}
else if($select=='ssel')
{
	$updateCondition=$select."='".$sselval."'";
	$updateField=$select."='".$keyfield."'";
}
else
	die('SOMETHING MISTAKES'); 
}

#CHOSE THE OPERATION
switch($type)
{
	case 'del' : if($field) $result=demandDel($field); break;
	case 'insert' : $result=demandInsert($sdomain, $sfield, $ssel); break;
	case 'update' : $result=demandUpdate($updateField, $updateCondition); break;
	default : die('NO ARGUMENT');
}

function demandDel($field)
{
	$result=del('rootoption',"sfield='{$field}'");
	return $result;
}

function demandInsert($sdomain, $sfield, $ssel)
{
	$result=insert("'{$sdomain}','{$sfield}','{$ssel}'",'rootoption(sdomian,sfield,ssel)');
	return $result;
}

function demandUpdate($updateField, $updateCondition)
{
	$result=update("$updateField",'rootoption',"$updateCondition");
	return $result;
}

if($result)
	alertMsg('操作成功！','./index.php?pwd=verify');
else
	alertMsg('操作失败！','./index.php?pwd=verify');
?>
