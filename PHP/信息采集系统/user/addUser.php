<?php
	require_once '../config.php';
	checkLogin();
	checkAuthority();
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered am-text-center">
	<h3>添加用户</h3>
    <form class="am-form" action="action.php?act=51" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-file am-icon-fw"></i></span>
			<input type="text" class="am-form-field" name="username" placeholder="请输入用户名">
		</div>

		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-calendar-check-o am-icon-fw"></i></span>
			<input type="password" class="am-form-field" name="password" placeholder="请输入密码">
		</div>
		
        <div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-indent am-icon-fw"></i></span>
			<select name="UG" class="am-form-field">
			  <option value="1" selected>用户</option>
			  <option value="0">管理员</option>
			</select>
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
      <button type="submit" class="am-btn am-btn-primary am-btn-block">添加</button>
    </form>
  </div>
</div>