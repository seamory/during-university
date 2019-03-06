<?php 
require_once '../config.php';
checkLogin();
checkAuthority();
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
//$rows=mysql::query('dm_user.uid,username,mwid,title,topic,sdt,edt,state','dm_user,dm_msgwall','dm_user.uid=dm_msgwall.uid','mul',MYSQL_ASSOC);
$pageControl = new pageControl;
$pageControl -> setSql('dm_user.uid,username,mwid,title,topic,sdt,edt,state', 'dm_user,dm_msgwall', "dm_user.uid=dm_msgwall.uid", $_REQUEST['query'], 10);
$rows = $pageControl -> getRows();
//$rows=getAllAdmin();
?>
<div class="am-g" style="margin:30px 10px 30px 10px;">
<div class="am-scrollable-horizontal">
	<!--表格-->
	<table class="am-table am-table-bordered am-table-radius am-text-center">
		<thead>
			<tr>
				<th class="am-text-center">编号</th>
				<th class="am-text-center">墙编号</th>
				<th class="am-text-center">用户</th>
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
				<td><?php echo $row['mwid'];?></td>
				<td><?php echo $row['username'];?></td>
				<td><?php echo $row['title'];?></td>
				<td><?php echo $row['sdt'];?></td>
				<td><?php echo $row['edt'];?></td>
				<td><?php $out=$row['state']?'启用中':'关闭中'; echo $out?></td>
				<td align="center">
					<a class="am-btn am-btn-primary am-radius" onclick="delUserMsgWall(<?php echo $row['mwid'];?>)">删除</a>
				</td>
			</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="8"><?php $pageControl -> showPage('?page=54&', 'query');?></td>
			</tr>
		</tbody>
	</table>
</div>
</div>

<script type="text/javascript">
	function delUserMsgWall(id){
			if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！！")){
				window.location="action.php?act=74&id="+id;
			}
	}
</script>
</body>
</html>