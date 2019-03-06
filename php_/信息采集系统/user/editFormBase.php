<?php 
require_once '../config.php';
checkLogin();
$fmid=$_REQUEST['id'];
@$topicRow=mysql::query('*','dm_formbase',"fmid=$fmid",'mul',MYSQL_ASSOC);
@$typeRow=mysql::query('*','dm_formstruct',"fmid=$fmid",'mul',MYSQL_ASSOC);
?> 
<div style="margin:20px 0px 10px 30px">

	<!-- <span>请根据文本框内提示生成问卷元素，下拉选择框中值为用户的选择类型，多个用户选择值请用”//“分隔。</span> -->
</div>
<div class="am-g">
	<div class="am-u-md-8 am-u-sm-centered">
	<form action="action.php?act=22&id=<?php echo $fmid;?>" method="post" enctype="appliction/x-www-form-urlencode" class="am-form" id="form">
			<?php if($topicRow):?>
			<?php for($i=0;$i<sizeof($topicRow);$i++):?>
			<div id="topic_<?php echo $i+1;?>" style="margin-bottom: 10px;">
			<div class="am-input-group am-input-group-danger">
			  <span class="am-input-group-label"> 第<?php echo $i+1;?>题 题目 </span>
			  <input type="text" name="topic[<?php echo $i+1;?>]" value="<?php echo $topicRow[$i]['topic'];?>" class="am-form-field" placeholder="请在此输入题目内容">
			</div>
			
			<div class="am-input-group">
				<span class="am-input-group-label">选择类型</span>
				<select class="am-form-field" name="intype[<?php echo $i+1;?>]">
					<option value="radio" <?php echo $typeRow[$i]['type']=='radio'?'selected':'';?>>单选</option>
					<option value="checkbox" <?php echo $typeRow[$i]['type']=='checkbox'?'selected':'';?>>复选</option>
					<option value="select" <?php echo $typeRow[$i]['type']=='select'?'selected':'';?>>下拉选择</option>
					<option value="text" <?php echo $typeRow[$i]['type']=='text'?'selected':'';?>>普通文本输入</option>
					<option value="textarea" <?php echo $typeRow[$i]['type']=='textarea'?'selected':'';?>>长文本输入</option>
				</select>
			</div>
			
			<div class="am-input-group">
				<span class="am-input-group-label">可选择值</span>
				<input type="text" name="value[<?php echo $i+1;?>]" value="<?php echo $typeRow[$i]['value'];?>" class="am-form-field" placeholder="请输入选择值，多个选择值之间用“//”隔开">
			</div>
			
			</div>
			<?php endfor;?>
			<?php else:?>
			<div id="topic_1" style="margin-bottom: 10px;">
				<div class="am-input-group am-input-group-danger">
				  <span class="am-input-group-label"> 第<?php echo $i+1;?>题 题目 </span>
				  <input type="text" name="topic[1]" class="am-form-field" placeholder="请在此输入题目内容">
				</div>
				<div class="am-input-group">
					<span class="am-input-group-label">选择类型</span>
					<select class="am-form-field" name="intype[1]">
						<option value="radio" >单选</option>
						<option value="checkbox" >复选</option>
						<option value="select" >下拉选择</option>
						<option value="text" >普通文本输入</option>
						<option value="textarea" >长文本输入</option>
					</select>
				</div>
				<div class="am-input-group">
					<span class="am-input-group-label">可选择值</span>
					<input type="text" name="value[1]" class="am-form-field" placeholder="请输入选择值，多个选择值之间用“//”隔开">
				</div>
			</div>
			<?php endif;?>
			<div id="final">
				<button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
				<a class="am-btn am-btn-primary am-radius" onclick="addElement()"> 添加 </a>
				<a class="am-btn am-btn-danger am-radius" onclick="remove()"> 删除 </a>
			</div>
	</form>
	</div>
</div>
<script type="text/javascript">
$(function() {
  $('select').selected();
});

var i=<?php echo sizeof($topicRow)+1;?>;
if(i==1){
	i=2;
}
function addElement()
{
	var root=document.getElementById('form');	//获得父容器
	var extDiv=document.createElement('div');	//定义子容器
	extDiv.style='margin-bottom:10px';
	extDiv.id='topic_'+i;	//子容器定义完成
	
	var topicDiv=document.createElement('div');	//定义子容器下的标题子容器
	topicDiv.className='am-input-group am-input-group-danger';
	var topicSpan=document.createElement('span');	
	topicSpan.className='am-input-group-label';	//span下添加内容
	var topicInput=document.createElement('input');
	topicInput.type='text';
	topicInput.name='topic['+i+']';
	topicInput.className='am-form-field';
	topicInput.placeholder="请在此输入题目内容";
	topicSpan.innerHTML=' 第'+i+'题 题目 '; 
	topicDiv.appendChild(topicSpan);
	topicDiv.appendChild(topicInput);	//标题子容器定义完成
	
	var selDiv=document.createElement('div');	//定义选择类型子容器
	selDiv.className='am-input-group';
	var selSpan=document.createElement('span');	
	selSpan.className='am-input-group-label';
	var select=document.createElement('select');
	select.className='am-form-field';
	select.name='intype['+i+']';
	//select.data-am-selected;
	select.options[0]=new Option('单选', 'radio');
	select.options[1]=new Option('复选', 'checkbox');
	select.options[2]=new Option('下拉选择', 'select');
	select.options[3]=new Option('普通文本输入', 'text');
	select.options[4]=new Option('长文本输入', 'textarea');
	select.multiple=false;
	selSpan.innerHTML=' 提交类型 ';
	selDiv.appendChild(selSpan);
	selDiv.appendChild(select);//选择类型子容器定义完成
	
	var valDiv=document.createElement('div');	//定义选择值子容器
	valDiv.className='am-input-group';
	var valSpan=document.createElement('span');	
	valSpan.className='am-input-group-label';
	var valInput=document.createElement('input');
	valInput.type='text';
	valInput.name='value['+i+']';
	valInput.className='am-form-field';
	valInput.placeholder='请输入选择值，多个选择值之间用“//”隔开';	
	valSpan.innerHTML=' 可选择值 ';
	valDiv.appendChild(valSpan);
	valDiv.appendChild(valInput);//选择值子容器定义完成
	
	extDiv.appendChild(topicDiv);
	extDiv.appendChild(selDiv);
	extDiv.appendChild(valDiv);
	
	var FE=document.getElementById('final');	//获得父容器下最后一个子容器
	root.insertBefore(extDiv,FE);	//插入一个新的子容器在最后一个子容器之前
	i++;
}

function remove()
{
	if(i==2){
		alert("没法再删除啦~");
	}else{
		var n=i-1;
		var topic='topic_'+(i-1);
		var root=document.getElementById('form');
		var div=document.getElementById(topic);
		root.removeChild(div);
		i--;
	}
}

function addElement2()
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
</script>