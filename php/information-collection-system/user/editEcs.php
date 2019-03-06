<?php 
require_once '../config.php';
checkLogin();
$ecid=$_REQUEST['id'];
$uid=$_SESSION['uid'];
@$row=mysql::query('*','dm_eclass',"ecid=$ecid and uid=$uid",'one',MYSQL_ASSOC);
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered am-text-center">
	<h3>编辑空课表基本信息</h3>
    <form class="am-form" action="action.php?act=32&id=<?php echo $ecid;?>" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
		<div class="am-input-group">
		  <span class="am-input-group-label"><i class="am-icon-file am-icon-fw"></i></span>
		  <input type="text" class="am-form-field" name="name" value="<?php echo $row['ecname'];?>" placeholder="请输入空课表名称(必填)">
		</div>

		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-calendar-check-o am-icon-fw"></i></span>
			<input type="text" class="am-form-field" name="date" value="<?php echo $row['dt'];?>" disabled>
		</div>
		
		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-check am-icon-fw"></i></span>
			<input type="text" class="am-form-field" name="date" value="<?php $out=$row['sdb']?'总课表':'单双周';echo $out;?>" disabled>
		</div>
		
		<div class="am-container am-text-middle am-text-center">
			<label class="am-radio am-secondary" style="display:inline;">
			  <input type="radio" name="switch" value="1" data-am-ucheck checked>
			  发布
			</label>
			<label class="am-radio am-secondary" style="display:inline;">
			  <input type="radio" name="switch" value="0" data-am-ucheck>
			  关闭
			</label>
		</div>
      </fieldset>
      <button type="submit" class="am-btn am-btn-primary am-btn-block">保存</button>
    </form>
  </div>
</div>