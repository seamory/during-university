<?php
	require_once '../config.php';
	checkLogin();
	$user=mysql::query('password','dm_user',"uid='{$_SESSION['uid']}'",'one',MYSQL_ASSOC);
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered">
    <form class="am-form" action="action.php?act=62" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
			<div class="am-input-group">
			  <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
			  <input type="text" class="am-form-field" name="name" value="<?php echo $_SESSION['username'];?>" placeholder="用户名" disabled>
			</div>
			
			<div class="am-input-group">
			  <span class="am-input-group-label"><i class="am-icon-key am-icon-fw"></i></span>
			  <input type="password" class="am-form-field" name="opwd" value="<?php echo $user['password'];?>" placeholder="原密码">
			</div>
			
			<div class="am-input-group">
			  <span class="am-input-group-label"><i class="am-icon-key am-icon-fw"></i></span>
			  <input type="password" class="am-form-field" name="npwd[]" placeholder="新密码">
			</div>
			
			<div class="am-input-group">
			  <span class="am-input-group-label"><i class="am-icon-key am-icon-fw"></i></span>
			  <input type="password" class="am-form-field" onblur="check()" name="npwd[]" placeholder="确认新密码">
			</div>
      </fieldset>
      <button type="submit" class="am-btn am-btn-primary am-btn-block">确认修改</button>
    </form>
  </div>
</div>