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
require_once '../usr/mysql.php';
connect();
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
	$result=null;
	if($i%7==0)
	{
		$rows=$i/7+1;
			echo '</tr><tr><td>第'.$rows.'节</td>';
	}
	$class=(int)($i/7)+1;
	$weekday=$i%7+1;
	$results=query('uid','tools_classempty',"class=$class and weekday=$weekday",'mul',MYSQL_NUM);
	if($results)
	{
		for($j=0;$j<sizeof($results);$j++)
			$result[$j]=$results[$j][0];
		$result=join(',', $result);
	}
	echo '<td>'.$result.'</td>';
}
echo '</tr></table>';
echo '</form>';
?>