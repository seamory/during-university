<?php
require_once 'config.php';
debugMysql('local');

function connect()
{
	$islink=mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD) or die('CONNECT DATABASE REEOR:'.mysql_errno());
	mysql_select_db(DB_CHOSE);
	mysql_set_charset(DB_CHARSET);
	return $islink;
}

function query($field, $table, $conditon=null, $fetch='one', $type=MYSQL_BOTH)
{
	if($conditon)
		$conditon=' where '.$conditon;
	$str='select '.$field.' from '.$table.$conditon;
	$isResult=mysql_query($str);
	if($fetch=='one')
	{
		$result=mysql_fetch_array($isResult,$type);
		return $result;
	}
	else if($fetch=='mul')
	{
		while($result=mysql_fetch_array($isResult,$type))
			$results[]=$result;
		return $results;
	}
	else
		die("ARGUMENT ERROR!");
}

function del($table, $condition)
{
	if($condition)
		$condition=' where '.$condition;
	$str='delete from '.$table.$condition;
	$isResult=mysql_query($str);
	return mysql_affected_rows();
}

function update($field, $table, $condition)
{
	if($condition)
		$condition=' where '.$condition;
	$str='update '.$table.' set '.$field.$condition;
	$isResult=mysql_query($str);
	return mysql_affected_rows();
	
}

function insert($field, $table)
{
	$str='insert into '.$table.' values ('.$field.')';
	$isResult=mysql_query($str);
	return mysql_affected_rows();
}

function queryNum($table, $type=rows)
{
	$str='select * from '.$table;
	$isResult=mysql_query($str);
	switch($type)
	{
		case 'rows' : $result=mysql_num_rows($isResult);break;
		case 'fields' : $result=mysql_num_fields($isResult);break;
		default : die('TYPE FIELD ERROE!');
	}
	return $result;
}
?>