<?php
require_once '../config.php';
checkLogin();

/**
 * @return array['sum']['eclass']
 */
function ecsGet()
{
	$uid=$_SESSION['uid'];
	@$eclass=mysql::query('*', 'dm_eclass', "uid='{$uid}'", 'mul', MYSQL_ASSOC);
	$array['sum']=sizeof($eclass);
	$array['eclass']=$eclass;
	return $array;
}

/**
 * @param int $ecid
 * @return array['presons']['sum']
 */
function ecsGetPreson($ecid)
{
	@$presons=mysql::query('jw_name','dm_ecs',"ecid='{$ecid}' group by jw_name",'mul');
	for($i=0; $i<sizeof($presons); $i++){
		$array[$i]=$presons[$i][0];
	}
	if(sizeof($array)>1){
		$array['presons']=join('、',$array);
	}else{
		$array['presons']=$array[0];
	}
	$array['sum']=$i;
	return $array;
}

/**
 *	@return array['sum']['form']
 */
function formGet()
{
	$uid=$_SESSION['uid'];
	@$form=mysql::query('*', 'dm_form', "uid='{$uid}'", 'mul', MYSQL_ASSOC);
	$array['sum']=sizeof($form);
	$array['form']=$form;
	return $array;
}

/**
 * @param int $fmid
 * @return int sum
 */
function formGetPreson($fmid)
{
	@$formPreson=mysql::query('*', 'dm_formresult', "fmid='{$fmid}' group by ip", 'mul', MYSQL_ASSOC);
	return sizeof($formPreson);
}

/**
 * @return array['sum']['walls']
 */
function wallGet()
{
	$uid=$_SESSION['uid'];
	@$wall=mysql::query('*', 'dm_msgwall', "uid='{$uid}'", 'mul', MYSQL_ASSOC);
	$array['sum']=sizeof($wall);
	$array['walls']=$wall;
	return $array;
}
?>
<div class="am-g" style="margin-top:30px;">
<div class="am-u-sm-12 am-u-md-10 am-u-lg-10 am-u-sm-centered">
	<div class="am-panel-group" id="accordion">
	  <div class="am-panel am-panel-default">
	    <div class="am-panel-hd">
	      <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-1'}">
	       	<i class="am-icon-file am-margin-left-sm"></i> 
	       		问卷/表单
	       	<span class="am-badge am-badge-primary am-round"><?php echo formGet()['sum']?></span>
	       	<i class="am-icon-angle-right am-fr am-margin-right"></i>
	      </h4>
	    </div>
	    <div id="do-not-say-1" class="am-panel-collapse am-collapse">
	      <div class="am-panel-bd">
	        <table class="am-table am-table-centered am-text-middle">
	        <tbody>
	        	<tr>
		        	<th width="80%">名称</th>
		        	<th>填写人数</th>
		        </tr>
		        <?php 
		        	$forms=formGet();
		        	for($i=0;$i<$forms['sum'];$i++):
		        ?>
		        <tr>
			        <td><?php echo $forms['form'][$i]['fmname'] ;?></td>
			        <td><?php echo formGetPreson($forms['form'][$i]['fmid'])?></td>
		        </tr>
		        <?php endfor;?> 
		    </tbody>
	        </table>
	      </div>
	    </div>
	  </div>
	  <div class="am-panel am-panel-default">
	    <div class="am-panel-hd">
	      <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-2'}">
	      	<i class="am-icon-table am-margin-left-sm"></i> 
	        	空课表
	        <span class="am-badge am-badge-primary am-round"><?php echo ecsGet()['sum']?></span>
	        <i class="am-icon-angle-right am-fr am-margin-right"></i>
	      </h4>
	    </div>
	    <div id="do-not-say-2" class="am-panel-collapse am-collapse">
	      <div class="am-panel-bd">
	        <table class="am-table am-table-centered am-text-middle">
	        <tbody>
	        	<tr>
		        	<th width="80%">名称</th>
		        	<th>填写人数</th>
		        </tr>
		        <?php 
		        	$ecs=ecsGet();
		        	for($i=0;$i<$ecs['sum'];$i++):
		        	$ecsPreson=ecsGetPreson($ecs['eclass'][$i]['ecid']);
		        ?>
		        <tr>
			        <td><?php echo $ecs['eclass'][$i]['ecname'] ;?></td>
			        <td>
				        <button class="am-btn am-btn-primary" data-am-modal="{target: '#ecs-<?php echo $i;?>'}">
				        	<?php echo $ecsPreson['sum'];?>
				        </button>
				        
				        <div class="am-modal am-modal-alert" tabindex="-1" id="ecs-<?php echo $i;?>">
						  <div class="am-modal-dialog">
						    <div class="am-modal-hd">
						    	当前已填写<?php echo $ecsPreson['sum'];?>人
						    </div>
						    <div class="am-modal-bd am-text-left" style="text-indent:2em;">
						      <?php echo $ecsPreson['presons'];?>
						    </div>
						    <div class="am-modal-footer">
						      <span class="am-modal-btn">我已了解</span>
						    </div>
						  </div>
						</div>
			        </td>
		        </tr>
		        <?php endfor;?> 
		    </tbody>
	        </table>
	      </div>
	    </div>
	  </div>
	  <div class="am-panel am-panel-default">
	    <div class="am-panel-hd">
	      <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-3'}">
	        <i class="am-icon-comment-o am-margin-left-sm"></i>
	      		消息墙
	      	<span class="am-badge am-badge-primary am-round"><?php echo wallGet()['sum']?></span>
	      	<i class="am-icon-angle-right am-fr am-margin-right"></i>
		  </h4>
	    </div>
	    <div id="do-not-say-3" class="am-panel-collapse am-collapse">
	      <div class="am-panel-bd">
	        <table class="am-table am-table-centered am-text-middle">
	        <tbody>
	        	<tr>
	        		<th>名称</th>
	        	</tr>
	        	<?php 
		        	$walls=wallGet();
		        	for($i=0;$i<$walls['sum'];$i++):
	       		 ?>
	        	<tr><td><?php echo $walls['walls'][$i]['title']?></td></tr>
	        	<?php endfor;?>
	        </tbody>
	        </table>
	      </div>
	    </div>
	  </div>
	</div>
</div>
</div>