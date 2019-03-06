<?php 
require_once '../config.php';
checkLogin();
checkAuthority();
$uid=$_REQUEST['id'];
$row=mysql::query('*','dm_user',"uid=$uid",'one',MYSQL_ASSOC);
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered am-text-center">
	<h3>编辑用户密码及状态</h3>
    <form class="am-form" action="action.php?act=53&id=<?php echo $uid;?>" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
		<div class="am-input-group">
		  <span class="am-input-group-label"><i class="am-icon-file am-icon-fw"></i></span>
		  <input type="text" class="am-form-field am-form-field am-radius" name="name" value="<?php echo $row['username'];?>" disabled>
		</div>

		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-calendar-check-o am-icon-fw"></i></span>
			<input type="text" class="am-form-field" name="password" placeholder="请输入修改后的密码" >
		</div>
		
		<div class="am-container am-text-middle am-text-center">
			<label class="am-radio am-secondary" style="display:inline;">
			  <input type="radio" name="switch" value="1" data-am-ucheck checked>
			  启用
			</label>
			<label class="am-radio am-secondary" style="display:inline;">
			  <input type="radio" name="switch" value="0" data-am-ucheck>
			  停用
			</label>
		</div>
      </fieldset>
      <button type="submit" class="am-btn am-btn-primary am-btn-block">保存</button>
    </form>
  </div>
</div>