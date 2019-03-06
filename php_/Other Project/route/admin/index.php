<?php
	session_start();
	require_once '../usr/common.php';
	require_once '../usr/mysql.php';
	$action=$_REQUEST['pwd'];
	if($action!='verify')
		alertMsg('没有访问权限！','../index.php');
	if($_SESSION['uid']==''&&$_COOKIE['uid']=='')
		alertMsg('请登陆！','../index.php');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>管理页主页</title>
</head>

<body>
<table>
<tr><td>SID</td><td>sdomain</td><td>sfield</td><td>ssel</td></tr>
<?php
connect();
$array=query('*', 'rootoption', null, MYSQL_NUM);
if(!$array)
	echo '暂未设置路由选项';
else
foreach($array as $key=>$val)
{
	for($i=0;$i<sizeof($val);$i++)
	{
		list($sid, $sdomain, $sfield, $ssel)=$val;
		echo '<td>'.$val[$i].'</td>';
	}
	echo "<td><a href='method.php?type=del&field={$val[2]}'>删除</a></td>";
	echo "
	<td>
	<form enctype=\"multipart/form-data\" action=\"method.php\" method=\"post\">
	<select name=\"select\" size=\"1\">
		<option value=\"sid\">sid</option>
		<option value=\"sfield\">sfield</option>
		<option value=\"ssel\">ssel</option>
	</select>
	<input type=\"text\" name=\"keyfield\" />
	<input type=\"hidden\" name=\"sidval\" value=\"".$sid."\" />
	<input type=\"hidden\" name=\"sfieldval\" value=\"".$sfield."\" />
	<input type=\"hidden\" name=\"sselval\" value=\"".$ssel."\" />
	<input type=\"hidden\" name=\"type\" value=\"update\" />
	<input type=\"submit\" value=\"update\" />
	</form>
	</td>";
	echo '</tr>';
}
?>
</table>
<form enctype="multipart/form-data" action="method.php" method="post">
<input type="text" name="sdomain" />
<input type="text" name="sfield" />
<input type="text" name="ssel" />
<input type="hidden" name="type" value="insert"/>
<input type="submit" value="insert" />
</form>
</body>
</html>