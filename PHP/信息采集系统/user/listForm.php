<?php 
require_once '../config.php';
checkLogin();
//$pageSize=2;
//$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
//$rows=getAdminByPage($page,$pageSize);
//$sql="select * from imooc_admin";
//$totalRows=getResultNum($sql);
//$pageSize=2;
//$totalPage=ceil($totalRows/$pageSize);
//$pageSize=2;
//$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
//if($page<1||$page==null||!is_numeric($page)){
//	$page=1;
//}
//if($page>=$totalPage)$page=$totalPage;
//$offset=($page-1)*$pageSize;
//$sql="select id,username,email from imooc_admin limit {$offset},{$pageSize}";
//$rows=fetchAll($sql);
$uid=$_SESSION['uid'];
//$rows=mysql::query('*','dm_form',"uid='{$uid}'",'mul',MYSQL_ASSOC);
$pageControl = new pageControl;
$pageControl -> setSql('*', 'dm_form', "uid='{$uid}'", $_REQUEST['query'], 10);
$rows = $pageControl -> getRows();
//$rows=getAllAdmin();

if(!$rows){
	common::alertMsg("你居然还没发布过问卷>_<","index.php?page=21");
	exit;
}
?>
<div class="am-g"  style="margin:30px 10px 30px 10px;">
<div class="am-scrollable-horizontal">
	<div style="margin:0px 0px 10px 30px">
		<a class="am-btn am-btn-primary am-radius" href="index.php?page=21">
		  <i class="am-icon-cog"></i>
		  添加
		</a>
	</div>
	<!--表格-->
	<table class="am-table am-table-bordered am-table-radius am-text-center">
		<thead>
			<tr>
				<th class="am-text-center"> 编号 </th>
				<th class="am-text-center"> 问卷名称 </th>
				<th class="am-text-center"> 创建时间 </th>
				<th class="am-text-center"> 状态 </th>
				<th class="am-text-center"> 操作 </th>
			</tr>
		</thead>
		<tbody>
		<?php  $i=1;if($rows)foreach($rows as $row):?>
			<tr>
				<td><?php echo $i++;//echo $row['fmid'];?></label></td>
				<td><?php echo $row['fmname'];?></td>
				<td><?php echo $row['dt'];?></td>
				<td><?php $out=$row['state']?'发放中':'关闭中'; echo $out?></td>
				<td align="center">
					<a class="am-btn am-btn-primary am-radius" href="index.php?page=23&id=<?php echo $row['fmid'];?>">内容</a>
					<a class="am-btn am-btn-primary am-radius" href="index.php?page=24&id=<?php echo $row['fmid'];?>">修改</a>
					<a class="am-btn am-btn-primary am-radius" onclick="delFrom(<?php echo $row['fmid'];?>)">删除</a>
					<!-- <a class="am-btn am-btn-primary am-radius" href="share.php?act=2&id=<?php echo $row['fmid'];?>">分享</a> -->
					<button type="button" class="am-btn am-btn-primary" data-am-modal="{target: '#my-share-<?php echo $row['fmid'];?>'}"> 分享 </button>
					
					<div class="am-modal am-modal-alert" tabindex="-1" id="my-share-<?php echo $row['fmid'];?>">
					  <div class="am-modal-dialog">
						<div class="am-modal-hd">分享链接</div>
						<div class="am-modal-bd">
						  <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/index.php?act=2&id='.$row['fmid'];?>
						</div>
						<div class="am-modal-footer">
						  <span class="am-modal-btn">确定</span>
						</div>
					  </div>
					</div>
					
					<a class="am-btn am-btn-primary am-radius" href="viewForm.php?id=<?php echo $row['fmid'];?>" target="_blank">导出</a>
				</td>
			</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="5"><?php $pageControl -> showPage('?page=22&', 'query');?></td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	function delFrom(id){
			if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！！")){
				window.location="action.php?act=24&id="+id;
			}
	}
</script>

