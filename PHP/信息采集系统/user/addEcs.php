<?php
	require_once '../config.php';
	checkLogin();
?>
<div class="am-g" style="margin:30px 0px 30px 0px">
  <div class="am-u-md-8 am-u-sm-centered am-text-center">
	<h3>新建空课表</h3>
    <form class="am-form" action="action.php?act=31" method="post" enctype="application/x-www-form-urlencode">
      <fieldset class="am-form-set">
		<div class="am-input-group">
		  <span class="am-input-group-label"><i class="am-icon-file am-icon-fw"></i></span>
		  <input type="text" class="am-form-field am-form-field am-radius" name="name" placeholder="请输入空课表名称(必填)">
		</div>

		<div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-calendar-check-o am-icon-fw"></i></span>
			<input type="text" class="am-form-field" name="date" value="<?php echo time::getTime();?>" disabled>
		</div>
		
        <div class="am-input-group">
			<span class="am-input-group-label"><i class="am-icon-calendar-check-o am-icon-fw"></i></span>
			<select name="sdb" class="am-form-field">
			  <option value="2" selected>从教务系统导入(仅川大锦城)</option>
			  <option value="1" >总课表</option>
			  <option value="0" >单双周</option>
			</select>
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