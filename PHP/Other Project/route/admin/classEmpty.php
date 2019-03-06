<style type="text/css">
.classEmptyform{
	font-family:"微软雅黑";
}
.classEmptySheet{
	border:solid 1px rgba(0,0,0,1.00);
	border-radius:5px;
	width:auto;
	text-align:center;
}
.classEmptySheetTitle{
	width:50px;
}
</style>
<?php 
echo '<form action="classEmpty.php?method=send" enctype="multipart/form-data" method="POST" name="classEmptyform" class="classEmptyform">';
echo '<table class="classEmptySheet"><tr>';
//PRINT THE TITLE
for($i=0;$i<=7;$i++)
{
	if($i==0)
		echo '<td class="classEmptySheetTitle"></td>';
	else
		echo '<td>星期'.$i.'</td>';
}
echo '</tr>';
//PRINTF THE CORE FUNCTION
for($i=0;$i<77;$i++)
{
	if($i%7==0)
	{
		$rows=$i/7+1;
			echo '</tr><tr><td>第'.$rows.'节</td>';
	}
	echo '<td><input class="classEmptyBottom" type="checkbox" name="classEmpty[]" value="'.$i.'"></td>';
}
echo '</tr></table>';
echo '<input type="submit" value="提交">';
echo '<a href="classEmpty.php?method=get">查看</a>';
echo '</form>';
?>

<?php
require_once '../usr/mysql.php';
if($_REQUEST['method']=='send')
	saveClassEmpty($_REQUEST['classEmpty']);
function saveClassEmpty($ce)
{
	connect();
	for($i=0;$i<sizeof($ce);$i++)
	{
		$class=(int)($ce[$i]/7)+1;
		$weekday=$ce[$i]%7+1;
		$result=insert("1,3,{$weekday},{$class}",'tools_classempty(ceid,uid,weekday,class)');
	}
}
?>