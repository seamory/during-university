<?php
	require_once '../config.php';
	checkLogin();
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered am-text-center">
	<h3>新建消息墙</h3>
    <form class="am-form" action="action.php?act=71" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
		<div class="am-input-group">
		  <span class="am-input-group-label"> 墙の名称 </span>
		  <input type="text" class="am-form-field am-form-field am-radius" name="title" placeholder="请输入墙名称(必填)">
		</div>

		<div class="am-input-group">
			<span class="am-input-group-label">开始时间</span>
			<input type="text" class="am-form-field" name="sdt" value="<?php echo time::getTime();?>" >
		</div>
		
		<div class="am-input-group">
			<span class="am-input-group-label">截止时间</span>
			<input type="text" class="am-form-field" name="edt" value="<?php echo time::getTime(10800);?>">
		</div>		
			
		<div class="am-input-group">
			<span class="am-input-group-label">同步话题</span>
			<input type="text" class="am-form-field" name="topic" placeholder="#话题#">
		</div>
		
		<div class="am-input-group">
			<span class="am-input-group-label">墙の背景</span>
			<input type="text" class="am-form-field" name="background" placeholder="http://www.xxx.com/xxx.png">
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