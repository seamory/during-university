<?php 
	require_once '../config.php';
    header("Content-type: text/html; charset=UTF-8");  //转换字符编码集
    function login_post($url,$cookie,$post){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  //不自动输出数据，要echo才行
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //重要，抓取跳转后数据
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 'http://jwweb.scujcc.cn/');  //重要，302跳转需要referer，可以在Request Headers找到 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);  //post提交数据
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    $_SESSION['xh']=$_POST['xh'];
    $xh=$_POST['xh'];
    $pw=$_POST['pw'];
    $code= $_POST['code'];
	$ecid= $_REQUEST['id'];
    $cookie = dirname(__FILE__) . '/cookie/'.$_SESSION['id'].'.txt';
    $url="http://jwweb.scujcc.cn/default2.aspx";  //教务处地址
    $con1=login_post($url,$cookie,'');
    preg_match_all('/<input type="hidden" name="__VIEWSTATE" value="([^<>]+)" \/>/', $con1, $view); //获取__VIEWSTATE字段并存到$view数组中
    $post=array(
        '__VIEWSTATE'=>$view[1][0],
        'txtUserName'=>$xh,
		'TextBox1'=>$xh,
        'TextBox2'=>$pw,
        'txtSecretCode'=>$code,
        'RadioButtonList1'=>urlencode(mb_convert_encoding('学生', 'gbk', 'UTF-8')),  //“学生”的gbk编码
        'Button1'=>'',
        'lbLanguage'=>'',
        'hidPdrs'=>'',
        'hidsc'=>''
    );
    $con2=login_post($url,$cookie,http_build_query($post)); //将数组连接成字符串
	if(!preg_match('/<span id="xhxm">([^<>]+)/', $con2)){
		$eclass='eclass.php?act=4&id='.$ecid;
		$img='./cookie/'.$_SESSION['id'].'.jpg';
		unlink($img);
		common::alertMsg('用户名或密码错误',$eclass);
	}else{
		preg_match_all('/<span id="xhxm">([^<>]+)/', $con2, $xm);   //正则出的数据存到$xm数组中
		$xm[1][0]=substr($xm[1][0],0,-4);  //字符串截取，获得姓名
		$_SESSION['name']=mb_convert_encoding($xm[1][0], 'UTF-8', 'GBK');
		$xm=urlencode(mb_convert_encoding($xm[1][0], 'gbk', 'UTF-8'));	//将获取的UTF-8编码为GBK
		$ch=curl_init();
		$url='http://jwweb.scujcc.cn/xskbcx.aspx?xh='.$xh.'&xm='.$xm.'&gnmkdm=N121602';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		$result=curl_exec($ch);
		curl_close($ch);
		$result=mb_convert_encoding($result, 'UTF-8', 'GBK');	//将结果转码为UTF-8字符集；
		$pattern='/<td (.+?)>(.*?)<\/td>/';
		preg_match_all($pattern, $result, $out, PREG_SET_ORDER);
		for($i=0,$j=0;$i<sizeof($out);$i++){
			if(strlen($out[$i][2])>10){
				$array[$j++]=$out[$i][2];
			}
		}
		$pattern='/周(.*?)第(.*?)节\{第(\d+)-(\d+)周\|(.*?)周\}/';
		$pattern1='/周(.*?)第(.*?)节\{第(\d+)-(\d+)周\}/';
		//$pattern=mb_convert_encoding($pattern, 'gbk', 'UTF-8');
		//$pattern1=mb_convert_encoding($pattern1, 'gbk', 'UTF-8');
		for($i=0,$j=0;$i<sizeof($array);$i++){
			//if(preg_match(mb_convert_encoding('/单周|双周/', 'gbk', 'UTF-8'),$array[$i])){
			if(preg_match('/单周|双周/', $array[$i])){
				preg_match_all($pattern, $array[$i], $out, PREG_SET_ORDER);
				$class[$j++]=$out;
			}else{
				preg_match_all($pattern1, $array[$i], $out, PREG_SET_ORDER);
				$class[$j++]=$out;
			}
		}
		function countClass($start, $end, $type=null)
		{
			if($type=='单'){
				for($i=$start,$j=0; $i<=$end; $i++){
					if($i%2!=0){
						$result[$j++]=$i;
					}
				 }
			}elseif($type=='双'){
				for($i=$start,$j=0; $i<=$end; $i++){
					if($i%2==0){
						$result[$j++]=$i;
					}
				}
			}else{
				for($i=$start,$j=0; $i<=$end; $i++){
					$result[$j++]=$i;
				}
			}
			return join(',', $result);
		}
		function strToNum($str)
		{
			switch($str){
				case '一' : $num=1; break;
				case '二' : $num=2; break;
				case '三' : $num=3; break;
				case '四' : $num=4; break;
				case '五' : $num=5; break;
				case '六' : $num=6; break;
				case '日' : $num=7; break;
				case '七' : $num=7; break;
			}
			return $num;
		}	 
		// detail
		for($i=0,$x=0; $i<sizeof($class); $i++){
			if( sizeof($class[$i]) > 1 ){
				for($j=0; $j<sizeof($class[$i]) ;$j++){
					$detail[$x][0]=strToNum($class[$i][$j][1]);
					$detail[$x][1]=explode(',',$class[$i][$j][2]);
					$detail[$x][2]=countClass($class[$i][$j][3], $class[$i][$j][4],$class[$i][$j][5]);
					$x++;
				}
			}else{
				$detail[$x][0]=strToNum($class[$i][0][1]);
				$detail[$x][1]=explode(',',$class[$i][0][2]);
				$detail[$x][2]=countClass($class[$i][0][3], $class[$i][0][4],$class[$i][0][5]);
				$x++;
			}
		}
		// process detaill
		for($i=0,$x=0;$i<sizeof($detail);$i++){
			for($j=0;$j<sizeof($detail[$i][1]);$j++,$x++){
				$obj[$x]['weekday']=$detail[$i][0];
				$obj[$x]['class']=$detail[$i][1][$j];
				$obj[$x]['week']=$detail[$i][2];
			}
		}
		 // data
		unset($array);
		for($i=0;$i<7;$i++){
			for($j=0;$j<11;$j++){
				for($k=0;$k<sizeof($obj);$k++){
					if($i+1==$obj[$k]['weekday'] && $j+1==$obj[$k]['class']){
						if(!$array[$i][$j]){
							$array[$i][$j]=$obj[$k]['week'];
						}else{
							$array[$i][$j]=$array[$i][$j].','.$obj[$k]['week'];
						}
					}
				}
			}
		}
		$info=$array;
		function getComSet($str, $maxWeek=16)
		{
			$x=0;
			$array=explode(',',$str);
			for($i=1;$i<=$maxWeek;$i++){
				for($j=0,$k=0;$j<sizeof($array);$j++){
					 if($array[$j]!=$i){
						$k++;
					}
				}
				if($k==sizeof($array)){
					$result[$x++]=$i;
				}
			}
			if(sizeof($result)>1){
				return $result=join(',',$result);
			}else{
				return $result=$result[0];
			}
		}
		// product the result;
		$res=mysql::query('name', 'dm_ecs',"jw_name='{$_SESSION['name']}'", one);
		if($res){
			mysql::del('dm_ecs', "jw_name='{$_SESSION['name']}'");
		}
		$_SESSION['class']=$array;
		for($i=0;$i<7;$i++){
			for($j=0;$j<11;$j++){
				if(!isset($array[$i][$j])){
					$weekday=$i+1;
					$class=$j+1;
					$result=mysql::insert("'{$ecid}','{$_SESSION['name']}','{$_SESSION['name']}','30','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
				}else{
					$temp=getComSet($array[$i][$j]);
					if($temp){
						$weekday=$i+1;
						$class=$j+1;
						$name=$_SESSION['name'].'('.$temp.')';
						$result=mysql::insert("'{$ecid}','{$name}','{$_SESSION['name']}','30','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
					}else{//满课结果不予存储
						 //echo $_SESSION['name'].'(满课)'.'<br>';
					}
				}
			}
		}
		$img='./cookie/'.$_SESSION['id'].'.jpg';
		unlink($cookie);
		unlink($img);
		//var_dump($_SESSION);
		//echo 'ok';
		print_r($_SESSION['class']);
		//header('location:view.php');
		//echo '<pre>';
		//var_dump($detail);
		//var_dump($array);
		//echo '</pre>';
	}
?>