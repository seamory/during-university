<?php
	require_once '../config.php';
	session_start();
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
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		$result=curl_exec($ch);
		curl_close($ch);
		$result=mb_convert_encoding($result, 'UTF-8', 'GBK');	//将结果转码为UTF-8字符集；
		
 		$pattern = '/				#开始捕捉
					<table(.*?)>	#起始table
					(.*?)			#table之间的内容
					<\/table>		#结束table标签
					/sxS';
		preg_match_all($pattern, $result, $timeTable, PREG_SET_ORDER);
		
		$search = array('<', '>');
		$replace = array('[', ']');
		$timeTable = str_replace($search, $replace, $timeTable[0][0]);
		$pattern = '/			#开始捕捉
					\[tr\]		#起始tr
					(.*?)		#tr之间的内容
					\[\/tr\]	#结束tr
					/sxS';		#
		preg_match_all($pattern, $timeTable, $ClassDayTime, PREG_SET_ORDER);
		
		for($i = 0; $i < sizeof($ClassDayTime); $i++){
			$ClassDayTime[$i][1] = str_replace('d][t', 'd]@@[t', $ClassDayTime[$i][1]);
			$tr[$i] = explode('@@', $ClassDayTime[$i][1]);
/* 			foreach($tr[$i] as $key => $val){
				$tr[$i] = str_replace('[br]', ',', $val);
			} */
		}
		
		//	处理colspan 和 rowspan
		for($y = 0, $x = 0; $y < sizeof($tr); $y++, $x = 0){
			foreach($tr[$y] as $key => $val){
				$row = preg_match('/(rowspan)/', $val);
				$col = preg_match('/(colspan)/', $val);
				preg_match_all('/\](.*)\[/s', $val, $tdValue, PREG_SET_ORDER);
				if( $row || $col ){
					if($row && $col){
						$TABLE[$y][$x] = $tdValue[0][1];
						preg_match_all('/rowspan=\"(\d+)\"/', $val, $rowValue, PREG_SET_ORDER);
						preg_match_all('/colspan=\"(\d+)\"/', $val, $colValue, PREG_SET_ORDER);
						for($i = 1; $i <= $rowValue[0][1]; $i++){
							$TABLE[$y+$i-1][$x] = $tdValue[0][1];
						}
						for($i = 1; $i <= $colValue[0][1]; $i++){
							$TABLE[$y][$x++] = $tdValue[0][1];
						}
					}elseif($row){
						preg_match_all('/rowspan=\"(\d+)\"/', $val, $rowValue, PREG_SET_ORDER);
						$TABLE[$y][$x] = $tdValue[0][1];
						for($i = 1; $i <= $rowValue[0][1]; $i++){
							$TABLE[$y+$i-1][$x] = $tdValue[0][1];
						}
						$x++;
					}elseif($col){
						preg_match_all('/colspan=\"(\d+)\"/', $val, $colValue, PREG_SET_ORDER);
						$TABLE[$y][$x] = $tdValue[0][1];
						for($i = 1; $i <= $colValue[0][1]; $i++){
							$TABLE[$y][$x++] = $tdValue[0][1];
						}
					}
				}else{
 					while(isset($TABLE[$y][$x]) || $TABLE[$y][$x]){
						$x++;
					}
					$TABLE[$y][$x++] = $tdValue[0][1];
				}
			}
		}
		
		//重新进行排序
/* 		for($i = 0; $i < sizeof($TABLE); $i++){
			ksort($TABLE[$i]);
		} */
		
		//	计算时间周期
		function countWeek($start, $end, $type = NULL){
			$j = 0;
			if( $type == '单'){
				for($i = $start; $i <= $end; $i++){
					if( $i % 2 != 0 ) $week[$j++] = $i;
				}
			}elseif( $type == '双'){
				for($i = $start; $i <= $end; $i++){
					if( $i % 2 == 0 ) $week[$j++] = $i;
				}
			}else{
				for($i = $start; $i <= $end; $i++){
					$week[$j++] = $i;
				}
			}
			return join(',', $week);
		}
		
		$res=mysql::query('name', 'dm_ecs',"jw_name='{$_SESSION['name']}'", one);
		if($res) mysql::del('dm_ecs', "jw_name='{$_SESSION['name']}'");
		$weekTotal = range(1,16);
		$regx[0] = '/第(\d+)-(\d+)周\|(.*?)周/';
		$regx[1] = '/第(\d+)-(\d+)周/';
		$regx[2] = '/周(.*?)第(.*?)节\{第(\d+)-(\d+)周\|(.*?)周\}/';
		$regx[3] = '/周(.*?)第(.*?)节\{第(\d+)-(\d+)周\}/';
		$regx[4] = '';
		for($y = 2; $y < sizeof($TABLE); $y++){
			for($x = 2; $x < sizeof($TABLE[$y]); $x++){
				if( $TABLE[$y][$x] == '&nbsp;' ){
					$weekday = $x-1;
					$class = $y-1;
					$ECS_TABLE[$y-1][$x-1] = $_SESSION['name'];
					mysql::insert("'{$ecid}','{$_SESSION['name']}','{$_SESSION['name']}','30','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
				}else{
					$TMP_num = $y - 1;
					$TMP_regx = '/' . $TMP_num . '/';
					$TD_CONTENT = explode('[br][br]', $TABLE[$y][$x]);
					foreach( $TD_CONTENT as $content){
						if(preg_match($regx[2], $content)){
							preg_match_all($regx[2], $content, $week, PREG_SET_ORDER);
							foreach($week as $key => $val){
								if(preg_match($TMP_regx, $val[2]))
									$weekResult = $weekResult ? $weekResult . ',' . countWeek($val[3], $val[4], $val[5]) : countWeek($val[3], $val[4], $val[5]);
							}
						}elseif(preg_match($regx[3], $content)){
							preg_match_all($regx[3], $content, $week, PREG_SET_ORDER);
							foreach($week as $key => $val){
								if( preg_match($TMP_regx, $val[2]) )
									$weekResult = $weekResult ? $weekResult . ',' . countWeek($val[3], $val[4]) : countWeek($val[3], $val[4]);
							}
						}elseif(preg_match($regx[0], $content)){
							preg_match_all($regx[0], $content, $week, PREG_SET_ORDER);
							foreach($week as $key => $val)
								$weekResult = $weekResult ? $weekResult . ',' . countWeek($val[1], $val[2], $val[3]) : countWeek($val[1], $val[2], $val[3]);
						}else{
							preg_match_all($regx[1], $content, $week, PREG_SET_ORDER);
							foreach($week as $key => $val)
								$weekResult = $weekResult ? $weekResult . ',' . countWeek($val[1], $val[2]) : countWeek($val[1], $val[2]);
						}
					}
					if( $temp = join(',' ,array_diff($weekTotal, explode(',' ,$weekResult))) ){
						$weekday = $x-1;
						$class = $y-1;
						$ECS_TABLE[$y-1][$x-1] = $_SESSION['name'] . '('. $temp . ')';
						mysql::insert("'{$ecid}','{$ECS_TABLE[$y-1][$x-1]}','{$_SESSION['name']}','30','{$weekday}','{$class}'",'dm_ecs(ecid,name,jw_name,sdb,weekday,class)');
					}else{
						$ECS_TABLE[$y-1][$x-1] = NULL;
					}
				}
				unset($weekResult);
			}
		}
		$_SESSION['class'] = $ECS_TABLE;
		$img='./cookie/'.$_SESSION['id'].'.jpg';
		unlink($cookie);
		unlink($img);
		header('location:view.php');
	}
?>