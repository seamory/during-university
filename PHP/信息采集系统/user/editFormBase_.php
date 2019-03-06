<?php 
require_once '../config.php';
checkLogin();
$fmid=$_REQUEST['id'];
@$topicRow=mysql::query('*','dm_formbase',"fmid=$fmid",'mul',MYSQL_ASSOC);
@$typeRow=mysql::query('*','dm_formstruct',"fmid=$fmid",'mul',MYSQL_ASSOC);
?> 
<div class="am-g">
	<div style="margin:10px 30px 20px 30px">
		<a class="am-btn am-btn-primary am-radius" onclick="addElement()"> 添加 </a>
		<a class="am-btn am-btn-danger am-radius" onclick="remove()"> 删除 </a>
		<span>请根据文本框内提示生成问卷元素，下拉选择框中值为用户的选择类型，多个用户选择值请用”//“分隔。</span>
	</div>
	<!--表格-->
	<div style="margin:0px 30px 30px 30px">
	<form action="action.php?act=22&id=<?php echo $fmid;?>" method="post" enctype="appliction/x-www-form-urlencode">
		<table class="table" cellspacing="0" cellpadding="0">
		<tbody>
			<?php if($topicRow)for($i=0;$i<sizeof($topicRow);$i++):?>
			<tr><td><div>第<?php echo $i+1;?>题：
			<input type="text" name="topic[<?php echo $i+1;?>]" value="<?php echo $topicRow[$i]['topic'];?>">
			<select class="am-form" name="intype[<?php echo $i+1;?>]">
				<option value="text" <?php echo $typeRow[$i]['type']=='text'?'selected':'';?>>普通文本框</option>
				<option value="radio" <?php echo $typeRow[$i]['type']=='radio'?'selected':'';?>>单选框</option>
				<option value="checkbox" <?php echo $typeRow[$i]['type']=='checkbox'?'selected':'';?>>复选框</option>
				<option value="select" <?php echo $typeRow[$i]['type']=='select'?'selected':'';?>>下拉选择框</option></select>
			<input type="text" name="value[<?php echo $i+1;?>]" value="<?php echo $typeRow[$i]['value'];?>"></td></tr>
			<?php endfor;?>
			<tr><td><input type="submit" value="保存"></td></tr>
		</tbody>
		</table>
	</form>
	</div>
</div>
<script type="text/javascript">
var i=<?php echo sizeof($topicRow)+1;?>;
function addElement()
{
	var tbody=document.getElementsByTagName('tbody')[0];
	var tr=document.getElementsByTagName('tr');
	var ntr=document.createElement('tr');
	//var ntr1=document.createElement('tr');
	//var ntd1=document.createElement('td');
	var finaltr=tr[tr.length-1];
	var ntd=document.createElement('td');
	var div=document.createElement('div');
	var input=document.createElement('input');
	input.type='text';
	input.name='topic['+i+']';
	input.placeholder='请在此输入题目内容';
	var select=document.createElement('select');
	select.name='intype['+i+']';
	select.options[0]=new Option('普通文本框', 'text');
	select.options[1]=new Option('单选框', 'radio');
	select.options[2]=new Option('复选框', 'checkbox');
	select.options[3]=new Option('下拉选择框', 'select');
	select.multiple=false;
	var inval=document.createElement('input');
	inval.type='text';
	inval.name='value['+i+']';
	inval.placeholder='请输入用户的选择值';
	var br=document.createElement('br');
	//ntd.innerHTML='第'+i+'题';
	div.innerHTML='第'+i+'题：';
	div.appendChild(input);
	//div.appendChild(br);
	div.appendChild(select);
	div.appendChild(inval);
	ntd.appendChild(div);
	ntr.appendChild(ntd);
	tbody.insertBefore(ntr,finaltr);
	//ntd.appendChild(input);
	//ntr.appendChild(ntd),
	//tbody.insertBefore(ntr,lasttr);
	//ntd1.appendChild(select);
	//ntd1.appendChild(inval);
	//ntr1.appendChild(ntd1),
	//tbody.insertBefore(ntr1,lasttr);
	i++;
}
function remove()
{
	if(i==1){
		alert("请添加内容");
	}else{
		var tbody=document.getElementsByTagName('tbody')[0];
		var tr=document.getElementsByTagName('tr');
		var ltr=tr[tr.length-2];
		tbody.removeChild(ltr);
		i--;
	}
}
</script>