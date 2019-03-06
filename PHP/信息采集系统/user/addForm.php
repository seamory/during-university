<?php
	require_once '../config.php';
	checkLogin();
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered am-text-center">
	<h3>新建问卷</h3>
    <form class="am-form" action="action.php?act=21" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
		<div class="am-input-group">
		  <span class="am-input-group-label"><i class="am-icon-file am-icon-fw"></i></span>
		  <input type="text" class="am-form-field am-form-field am-radius" name="fm" placeholder="请输入问卷名称(必填)">
		</div>

		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-calendar-check-o am-icon-fw"></i></span>
			<input type="text" class="am-form-field" name="date" value="<?php echo time::getTime();?>" disabled>
		</div>
		
        <div class="am-input-group">
			<span class="am-input-group-label">问卷表单描述</span>
			<textarea name="depiction" rows="5" placeholder="简述问卷、表单的发布目的，不超过200字，可以留空"></textarea>
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
	  <input type="hidden" name="date" value="<?php echo time::getTime();?>">
      <button type="submit" class="am-btn am-btn-primary am-btn-block">保存</button>
    </form>
  </div>
</div>