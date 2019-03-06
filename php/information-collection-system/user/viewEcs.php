<?php
require_once '../config.php';
checkLogin();

$ecid=$_REQUEST['id'];
@$ecs=mysql::query('*','dm_eclass',"ecid='{$ecid}'",'one');
if(!$ecs){
	exit();
}
?>
<!doctype html>
<html>
<head>
 <meta charset="utf-8">
 <title><?php echo $ecs['ecname'];?></title>
 <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
<style type="text/css">
</style>
</head>
<body id="ecs" style="font-size:12px;">
<div class="am-g">
<div class="am-u-md-11 am-u-sm-centered am-text-center">
	<div class="am-text-center" style="font-size:30px;">
		<?php echo $ecs['ecname'];?>
	</div>
	<div class="am-u-sm-centered" style="font-size:15px;">
		<?php echo $ecs['dt'];?>
	</div>
<!-- 总课表处理方法 -->
<?php if($ecs['sdb']==1):?>
<table class="am-table am-table-bordered am-text-middle">
<tr>
	<?php for($i=0;$i<=7;$i++):?>
		<?php if($i==0):?>
			<td class="am-text-centered am-text-middle" width="5%">课程</td>
		<?php else:?>
			<td class="am-text-centered am-text-middle" width="13.57%">星期<?php echo $i;?></td>
		<?php endif;?>
	<?php endfor;?>
<?php for($i=0;$i<77;$i++):?>
	<?php $result=null;?>
	<?php if($i%7==0):$rows=$i/7+1;?>
		</tr><tr><td class="am-text-centered am-text-middle" style="font-size:10px;">第<?php echo $rows;?>节</td>
	<?php endif;?>
	<?php
		$class=(int)($i/7)+1;
		$weekday=$i%7+1;
		@$val=mysql::query('name','dm_ecs',"ecid='{$ecid}' and class='{$class}' and weekday='{$weekday}' and sdb=11",'mul',MYSQL_NUM);//此处为二维数组，需要单独处理
		if($val){
			for($j=0;$j<sizeof($val);$j++){
				$result[$j]=$val[$j][0];
			}
			@$result=join('、',$result);
		}
	?>
	<td class="am-text-left"><?php echo $result;?></td>
<?php endfor;?>
</tr>
</table>

<!-- 单双周课表处理方法 -->
<!-- 处理表头 -->
<?php elseif($ecs['sdb']==0):?>
<div class="am-u-lg-8 am-u-sm-centered" style="font-size:15px;color:red;">
	为了方便用户对收集的空课表进行管理，本页面将生成3个空课表页面，主空课表为单双周合并，副空课表为单双周分离。用户可以导入EXCEL后自行对空课表数据进行合并管理。
</div>
<table class="am-table am-table-bordered">
<tr>
	<?php for($i=0;$i<=7;$i++):?>
		<?php if($i==0):?>
			<td class="am-text-centered am-text-middle" width="5%">课程</td><td>&nbsp;</td>
		<?php else:?>
			<td class="am-text-centered am-text-middle" width="13.57%">星期<?php echo $i;?></td>
		<?php endif;?>
	<?php endfor;?>
<?php for($z=0;$z<11;$z++):?>
<!-- 处理单周 -->
	<?php for($i=7*$z;$i<7*($z+1);$i++):?>
	<?php $result=null;?>
	<?php if($i%7==0):$rows=$i/7+1;?>
		</tr><tr><td class="am-text-middle" align="center" rowspan="2" width="20px" style="font-size:10px;">第<?php echo $rows;?>节</td>
				 <td class="am-text-middle" width="10px">单</td>
	<?php endif;?>
	<?php
		$class=(int)($i/7)+1;
		$weekday=$i%7+1;
		@$vals=mysql::query('name','dm_ecs',"ecid='{$ecid}' and class='{$class}' and weekday='{$weekday}' and sdb=10",'mul',MYSQL_NUM);//此处为二维数组，需要单独处理
		if($vals){
			for($j=0;$j<sizeof($vals);$j++){
				$result[$j]=$vals[$j][0];
			}
			@$result=join('、',$result);
		}
	?>
	<td class="am-text-left"><?php echo $result;?></td>
	<?php endfor;?>
<!-- 处理双周 -->
	<?php for($i=7*$z;$i<7*($z+1);$i++):?>
	<?php $result=null;?>
	<?php if($i%7==0):$rows=$i/7+1;?>
		</tr><tr><td class="am-text-middle" width="10px">双</td>
	<?php endif;?>
	<?php
		$class=(int)($i/7)+1;
		$weekday=$i%7+1;
		@$vald=mysql::query('name','dm_ecs',"ecid='{$ecid}' and class='{$class}' and weekday='{$weekday}' and sdb=20",'mul',MYSQL_NUM);//此处为二维数组，需要单独处理
		if($vald){
			for($j=0;$j<sizeof($vald);$j++){
				$result[$j]=$vald[$j][0];
			}
			@$result=join('、',$result);
		}
	?>
	<td class="am-text-left"><?php echo $result;?></td>
	<?php endfor;?>
<?php endfor;?>
</tr>
</table>
<!-- 单双周分离显示 单周 -->
<div>
<div class="am-text-cneter" style="font-size: 20px;margin:20px 0px 5px 0px;">
单双周课表分离显示
</div>
<table class="am-table am-table-bordered am-text-middle">
<tr>
	<!-- 处理表头 -->
	<?php for($i=0;$i<=7;$i++):?>
		<?php if($i==0):?>
			<td class="am-text-centered am-text-middle" style="color:red;font-size:20px;width:5%">单周</td>
		<?php else:?>
			<td class="am-text-centered am-text-middle" width="13.57%">星期<?php echo $i;?></td>
		<?php endif;?>
	<?php endfor;?>
	<?php for($i=0;$i<77;$i++):?>
		<?php $result=null;?>
		<?php if($i%7==0):$rows=$i/7+1;?>
			</tr><tr><td class="am-text-centered am-text-middle" style="font-size:10px;">第<?php echo $rows;?>节</td>
		<?php endif;?>
		<?php
			$class=(int)($i/7)+1;
			$weekday=$i%7+1;
			@$vals=mysql::query('name','dm_ecs',"ecid='{$ecid}' and class='{$class}' and weekday='{$weekday}' and sdb=10",'mul',MYSQL_NUM);//此处为二维数组，需要单独处理
			if($vals){
				for($j=0;$j<sizeof($vals);$j++){
					$result[$j]=$vals[$j][0];
				}
				@$result=join('、',$result);
			}
			?>
		<td class="am-text-left"><?php echo $result;?></td>
	<?php endfor;?>
</table>
</div>
<!-- 单双周分离显示 双周 -->
<div>
<table class="am-table am-table-bordered am-text-middle">
<tr>
	<!-- 处理表头 -->
	<?php for($i=0;$i<=7;$i++):?>
		<?php if($i==0):?>
			<td class="am-text-centered am-text-middle" style="color:red;font-size:20px;width:5$">双周</td>
		<?php else:?>
			<td class="am-text-centered am-text-middle" width="13.57%">星期<?php echo $i;?></td>
		<?php endif;?>
	<?php endfor;?>
	<?php for($i=0;$i<77;$i++):?>
		<?php $result=null;?>
		<?php if($i%7==0):$rows=$i/7+1;?>
			</tr><tr><td class="am-text-centered am-text-middle" style="font-size:10px;">第<?php echo $rows;?>节</td>
		<?php endif;?>
		<?php
			$class=(int)($i/7)+1;
			$weekday=$i%7+1;
			@$vald=mysql::query('name','dm_ecs',"ecid='{$ecid}' and class='{$class}' and weekday='{$weekday}' and sdb=20",'mul',MYSQL_NUM);//此处为二维数组，需要单独处理
			if($vald){
				for($j=0;$j<sizeof($vald);$j++){
					$result[$j]=$vald[$j][0];
				}
				@$result=join('、',$result);
			}
			?>
		<td class="am-text-left"><?php echo $result;?></td>
	<?php endfor;?>

<!--	教务导入处理方法	-->
<?php elseif($ecs['sdb']==2):?>
<table class="am-table am-table-bordered am-text-middle">
<tr>
	<?php for($i=0;$i<=7;$i++):?>
		<?php if($i==0):?>
			<td class="am-text-centered am-text-middle" width="6%">课程</td>
		<?php else:?>
			<td class="am-text-centered am-text-middle" width="13.57%">星期<?php echo $i;?></td>
		<?php endif;?>
	<?php endfor;?>
<?php for($i=0;$i<84;$i++):?>
	<?php $result=null;?>
	<?php if($i%7==0):$rows=$i/7+1;?>
		</tr><tr><td class="am-text-centered am-text-middle" style="font-size:10px;">第<?php echo $rows;?>节</td>
	<?php endif;?>
	<?php
		$class=(int)($i/7)+1;
		$weekday=$i%7+1;
		@$val=mysql::query('name','dm_ecs',"ecid='{$ecid}' and class='{$class}' and weekday='{$weekday}' and sdb=30",'mul',MYSQL_NUM);//此处为二维数组，需要单独处理
		if($val){
			for($j=0;$j<sizeof($val);$j++){
				$result[$j]=$val[$j][0];
			}
			@$result=join('、<br>',$result);
		}
	?>
	<td class="am-text-left"><?php echo $result;?></td>
<?php endfor;?>
</tr>
</table>
<?php endif;?>
</table>
</div>
</div>
</div>
</body>
</html>