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
//$rows=mysql::query('*','dm_user',"usergroup='users'",'mul',MYSQL_ASSOC);
$pageControl = new pageControl;
$pageControl -> setSql('*', 'dm_user', "usergroup='users'", $_REQUEST['query'], 10);
$rows = $pageControl -> getRows();
//$rows=getAllAdmin();
?>
<div class="am-g" style="margin:30px 10px 30px 10px;">
<div class="am-scrollable-horizontal">
	<div style="margin:0px 0px 10px 30px">
		<a class="am-btn am-btn-primary am-radius" href="index.php?page=41">
		  <i class="am-icon-cog"></i>
		  添加
		</a>
	</div>
	<!--表格-->
	<table class="am-table am-table-bordered am-table-radius am-text-center">
		<thead>
			<tr>
				<th class="am-text-center">ID</th>
				<th class="am-text-center">UID</th>
				<th class="am-text-center">用户名</th>
				<th class="am-text-center">账户状态</th>
				<th class="am-text-center">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php  $i=1;if($rows)foreach($rows as $row):?>
			<tr>
				<td><?php echo $i++;?></label></td>
				<td><?php echo $row['uid'];?></td>
				<td><?php echo $row['username'];?></td>
				<td><?php $out=$row['licence']?'启用中':'关闭中'; echo $out?></td>
				<td align="center">
					<a class="am-btn am-btn-primary am-radius" href="index.php?page=40&id=<?php echo $row['uid'];?>">修改</a>
					<a class="am-btn am-btn-primary am-radius" onclick="delUser(<?php echo $row['uid'];?>)">删除</a>
				</td>
			</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="5"><?php $pageControl -> showPage('?page=42&', 'query');?></td>
			</tr>
		</tbody>
	</table>
</div>
</div>
<script type="text/javascript">
	function delUser(id){
			if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！！")){
				window.location="action.php?act=52&id="+id;
			}
	}
</script>
</body>
</html>