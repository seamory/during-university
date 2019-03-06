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
//$rows=mysql::query('*','dm_msgwall',"uid='{$uid}'",'mul',MYSQL_ASSOC);
$pageControl = new pageControl;
$pageControl -> setSql('*', 'dm_msgwall', "uid='{$uid}'", $_REQUEST['query'], 10);
$rows = $pageControl -> getRows();
//$rows=getAllAdmin();

if(!$rows){
	common::alertMsg("还没有开始使用上墙功能呢","index.php?page=51");
	exit;
}
?>
<div class="am-g" style="margin:30px 10px 30px 10px;">
<div class="am-scrollable-horizontal">
	<div style="margin:0px 0px 10px 30px">
		<a class="am-btn am-btn-primary am-radius" href="index.php?page=31">
		  <i class="am-icon-cog"></i>
		  添加
		</a>
	</div>
	<!--表格-->
	<table class="am-table am-table-bordered am-table-radius am-text-center">
		<thead>
			<tr>
				<th class="am-text-center">编号</th>
				<th class="am-text-center">墙名称</th>
				<th class="am-text-center">创建时间</th>
				<th class="am-text-center">截止时间</th>
				<th class="am-text-center">发布状态</th>
				<th class="am-text-center">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php  $i=1;if($rows)foreach($rows as $row):?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['sdt'];?></td>
				<td><?php echo $row['edt'];?></td>
				<td><?php $out=$row['state']?'启用中':'关闭中'; echo $out?></td>
				<td align="center">
					<a class="am-btn am-btn-primary am-radius" href="index.php?page=53&id=<?php echo $row['mwid'];?>">修改</a>
					<a class="am-btn am-btn-primary am-radius" onclick="delMsgWall(<?php echo $row['mwid'];?>)">删除</a>
					<!-- <a class="am-btn am-btn-primary am-radius" href="share.php?act=4&id=<?php //echo $row['ecid'];?>">分享</a> -->
					<button type="button" class="am-btn am-btn-primary am-radius" data-am-modal="{target: '#my-share-<?php echo $row['mwid'];?>'}"> 上墙 </button>
					
					<div class="am-modal am-modal-alert" tabindex="-1" id="my-share-<?php echo $row['mwid'];?>">
					  <div class="am-modal-dialog">
						<div class="am-modal-hd">上墙链接</div>
						<div class="am-modal-bd">
						  <?php echo 'http://'.$_SERVER['SERVER_NAME'].'/index.php?act=5&id='.$row['mwid'];?>
						</div>
						<div class="am-modal-footer">
						  <span class="am-modal-btn">确定</span>
						</div>
					  </div>
					</div>
					
					<a class="am-btn am-btn-primary am-radius" href="msgWall.php?id=<?php echo $row['mwid'];?>" target="_blank"> 墙页面 </a>
				</td>
			</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="6"><?php $pageControl -> showPage('?page=52&', 'query');?></td>
			</tr>
		</tbody>
	</table>
</div>
</div>

<script type="text/javascript">
	function delMsgWall(id){
			if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！！")){
				window.location="action.php?act=73&id="+id;
			}
	}
</script>
</body>
</html>