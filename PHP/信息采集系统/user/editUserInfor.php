<?php
	require_once '../config.php';
	checkLogin();
	@$ui=mysql::query('*','dm_userinfor',"uid='{$_SESSION['uid']}'",'one',MYSQL_ASSOC);
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-6 am-u-sm-centered">
		<form class="am-form" action="action.php?act=61" method="post" enctype="appliction/x-www-form-urlencode">
		  <fieldset class="am-form-set">
				<div class="am-input-group">
				  <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
				  <input type="text" class="am-form-field" name="name" value="<?php echo $ui['name'];?>" placeholder="姓名">
				</div>

				<div class="am-input-group">
					<span class="am-input-group-label"><i class="am-icon-exchange am-icon-fw"></i></span>
					<select name="sex" class="am-form-field">
					  <option value="女" selected>女</option>
					  <option value="男">男</option>
					</select>
				</div>

				<div class="am-input-group">
				  <span class="am-input-group-label"><i class="am-icon-tree am-icon-fw"></i></span>
				  <input type="text" class="am-form-field" name="age" value="<?php echo $ui['age'];?>" placeholder="年龄">
				</div>
				
				<div class="am-input-group">
				  <span class="am-input-group-label"><i class="am-icon-mail-forward am-icon-fw"></i></span>
				  <input type="email" class="am-form-field" name="email" value="<?php echo $ui['email'];?>" placeholder="邮箱">
				</div>

				<div class="am-input-group">
				  <span class="am-input-group-label"><i class="am-icon-volume-control-phone am-icon-fw"></i></span>
				  <input type="text" class="am-form-field" name="tel" value="<?php echo $ui['tel'];?>" placeholder="电话">
				</div>
				
				<div class="am-input-group">
				  <span class="am-input-group-label"><i class="am-icon-qq am-icon-fw"></i></span>
				  <input type="text" class="am-form-field" name="oicq" value="<?php echo $ui['qq'];?>" placeholder="QQ">
				</div>
				
				<div class="am-input-group">
				  <span class="am-input-group-label"><i class="am-icon-wechat am-icon-fw"></i></span>
				  <input type="text" class="am-form-field" name="wechat" value="<?php echo $ui['wechat'];?>" placeholder="微信">
				</div>
		  </fieldset>
		  <button type="submit" class="am-btn am-btn-primary am-btn-block">保存修改</button>
		</form>
	</div>
</div>