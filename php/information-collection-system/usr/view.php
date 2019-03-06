<?php
require_once '../config.php';
function getComSet($str,$maxWeek=16)
{
	$x=0;
	$array=explode(',',$str);
	for($i=1;$i<=$maxWeek;$i++){
		for($j=0,$k=0;$j<sizeof($array);$j++){
			if($array[$j]!=$i){
				$k++;
			}
		}
		if($k==sizeof($array)){
			$result[$x++]=$i;
		}
	}
	if(sizeof($result)>1){
		return $result=join(',',$result);
	}else{
		return $result=$result[0];
	}
}
$name=$_SESSION['name'];
$class=$_SESSION['class'];
//var_dump($_SESSION);
?>
<html>
<head>
 <meta charset="utf-8">
 <title><?php echo $ecs['ecname'];?></title>
 <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
<style type="text/css">
</style>
</head>
<body>
<div class="am-g" style="margin-top:0px;">
	<div class="am-u-lg-10 am-u-md-10 am-u-sm-centered am-text-center">
	<span class="am-text-center">
		此页面为用户提交预览页面。
		<br>如果问题，请反馈到表单发布人员并致信service@seamory.com。感谢！
		<br><a href="thanks.php">关闭预览</a>
	</span>
	</div>
</div>
	<table class="am-table am-table-bordered am-text-middle">
	<tr>
		<?php for($i=0;$i<=7;$i++):?>
			<?php if($i==0):?>
				<td class="am-text-centered am-text-middle" width="10px">课程</td>
			<?php else:?>
				<td class="am-text-centered am-text-middle" width="14.3%">星期<?php echo $i;?></td>
			<?php endif;?>
		<?php endfor;?>
	<?php for($i=0;$i<84;$i++):?>
		<?php $result=null;?>
		<?php if($i%7==0):$rows=$i/7+1;?>
			</tr><tr><td class="am-text-centered am-text-middle">第<?php echo $rows;?>节</td>
		<?php endif;?>
		<?php
			$j=$i%7+1;
			$k=(int)($i/7)+1;
		?>
		<td class="am-text-left"><?php echo $class[$k][$j];?></td>
	<?php endfor;?>
	</tr>
	</table>
</body>