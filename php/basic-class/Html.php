<?php
/*
 * Create by VS code
 * User : Brocade
 * Html类主要用户处理网页，获取网页数据，分析转换网页内容 
 */

class Html{
	static public function getHtml($url, $cookie = null, $referer = null, $post = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);  //不自动输出数据，要echo才行
		curl_setopt($curl, CURLOPT_COOKIE, $cookie);
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($curl, CURLOPT_REFERER, $referer);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);  //重要，302跳转需要referer，可以在Request Headers找到
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //重要，抓取跳转后数据
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$post);  //post提交数据
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    static public function getCookieToFile($url, $cookiePath){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiePath);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_exec($curl);
	    curl_close($curl);
    }

    static public function getCookieToVariable($url){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HEADER, 1);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    preg_match_all('/set\-cookie:([^\r\n]*)/i', curl_exec($curl), $cookie);
	    curl_close($curl);
	    return join(";", $cookie[1]);
    }

    static public function getVerifyCodeAndCookieToFile($url, $cookiePath, $imgPath){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiePath);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $img = curl_exec($curl);
	    curl_close($curl);
	    $fp = fopen($imgPath,"w");
	    fwrite($fp, $img);
	    fclose($fp);
    }

    static public function getVerifyCodeAndCookieToVariable($url){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HEADER, 1);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $content = curl_exec($curl);
	    curl_close($curl);
	    list($header, $body) = explode("\r\n\r\n", $content);
	    preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $cookie);
	    return array(
	    	'cookie'=> join(";", $cookie[1]),
		    'verifyCodeImg'=>$body
	    );
    }

	static public function tableToArrayByTrans($html, $offset = 0, $trans = false){
		$TABLE = array();
		$html = str_replace(array("<",">","[th","[/th]", "\r","\n"), array("[", "]","[td","[/td]","",""), $html);
		$MatchRules = array(
					'/				#开始捕捉
					\[table(.*?)\]	#起始table
					(.*?)			#table之间的内容
					\[\/table\]		#结束table标签
					/isxS',
					'/			#开始捕捉
					\[tr(.*?)\]		#起始tr
					(.*?)		#tr之间的内容
					\[\/tr\]	#结束tr
					/isxS'
		);

		preg_match_all($MatchRules[0], $html, $tables, PREG_SET_ORDER);
		preg_match_all($MatchRules[1], $tables[$offset][0], $trs, PREG_SET_ORDER);

		for($i = 0; $i < count($trs); $i++){
			$tr[$i] = explode('#!!#!!#!!#', str_replace('[/td][td', '[/td]#!!#!!#!!#[td', $trs[$i][2]));
		}

		for($x = 0, $y = 0; $y < sizeof($tr); $x = 0, $y++){
			foreach($tr[$y] as $key => $val){
				$row = preg_match('/(rowspan)/i', $val);
				$col = preg_match('/(colspan)/i', $val);
				preg_match_all('/\](.*)\[/s', $val, $tdValue, PREG_SET_ORDER);
				if ( $row || $col ) {
					if ($row && $col) {
						$TABLE[$y][$x] = $trans ? $tdValue[0][1] : str_replace(array('[', ']'), array('<','>'), $tdValue[0][1]);
						preg_match_all('/rowspan=\"(\d+)\"/i', $val, $rowValue, PREG_SET_ORDER);
						preg_match_all('/colspan=\"(\d+)\"/i', $val, $colValue, PREG_SET_ORDER);
						for ($i = 0; $i < $rowValue[0][1]; $i++) {
							$TABLE[$y+$i][$x] = $trans ? $tdValue[0][1] : str_replace(array('[', ']'), array('<','>'), $tdValue[0][1]);
						}
						for ($i = 0; $i < $colValue[0][1]; $i++) {
							$TABLE[$y][$x++] = $trans ? $tdValue[0][1] : str_replace(array('[', ']'), array('<','>'), $tdValue[0][1]);
						}
					} elseif  ($row) {
						preg_match_all('/rowspan=\"(\d+)\"/i', $val, $rowValue, PREG_SET_ORDER);
						for ($i = 0; $i < $rowValue[0][1]; $i++) {
							$TABLE[$y+$i][$x] = $trans ? $tdValue[0][1] : str_replace(array('[', ']'), array('<','>'), $tdValue[0][1]);
						}
						$x++;
					} elseif ($col) {
						preg_match_all('/colspan=\"(\d+)\"/i', $val, $colValue, PREG_SET_ORDER);
						for ($i = 0; $i < $colValue[0][1]; $i++) {
							$TABLE[$y][$x++] = $trans ? $tdValue[0][1] : str_replace(array('[', ']'), array('<','>'), $tdValue[0][1]);
						}
					}
				} else {
					while ( isset($TABLE[$y][$x]) || $TABLE[$y][$x] ) {
						$x++;
					}
					$TABLE[$y][$x++] = $trans ? $tdValue[0][1] : str_replace(array('[', ']'), array('<','>'), $tdValue[0][1]);
				}
			}
		}

		for ($i = 0; $i < count($TABLE); $i++) {
			ksort($TABLE[$i]);
		}
		return $TABLE;
	}

	static public function tableToArray($html, $offset = 0) {
		$TABLE = array();
		$html = str_replace(array("<th","</th>", "\r","\n"), array("<td","</td>","",""), $html);
		$MatchRules = array(
			'/				#开始捕捉
			<table(.*?)>	#起始table
			(.*?)			#table之间的内容
			<\/table>		#结束table标签
			/isxS',
			'/			#开始捕捉
			<tr(.*?)>		#起始tr
			(.*?)		#tr之间的内容
			<\/tr>	#结束tr
			/isxS',
			'/
			<td(.*?)>
			(.*?)
			<\/td>
			/isxS'
		);

		preg_match_all($MatchRules[0], $html, $tables, PREG_SET_ORDER);
		preg_match_all($MatchRules[1], $tables[$offset][0], $trs, PREG_SET_ORDER);

		for($i = 0; $i < count($trs); $i++){
			preg_match_all($MatchRules[2], $trs[$i][0], $tds, PREG_SET_ORDER);
			for($j = 0; $j < count($tds); $j++){
				$tr[$i][] = $tds[$j][0];
			}
		}

		for($x = 0, $y = 0; $y < sizeof($tr); $x = 0, $y++){
			foreach($tr[$y] as $key => $val){
				$row = preg_match('/(rowspan)/i', $val);
				$col = preg_match('/(colspan)/i', $val);
				preg_match_all('/<td(?:.*?)>(.*?)<\/td>/s', $val, $tdValue, PREG_SET_ORDER);
				if ( $row || $col ) {
					if ($row && $col) {
						$TABLE[$y][$x] = $tdValue[0][1];
						preg_match_all('/rowspan=\"(\d+)\"/i', $val, $rowValue, PREG_SET_ORDER);
						preg_match_all('/colspan=\"(\d+)\"/i', $val, $colValue, PREG_SET_ORDER);
						for ($i = 0; $i < $rowValue[0][1]; $i++) {
							$TABLE[$y+$i][$x] = $tdValue[0][1];
						}
						for ($i = 0; $i < $colValue[0][1]; $i++) {
							$TABLE[$y][$x++] = $tdValue[0][1];
						}
					} elseif  ($row) {
						preg_match_all('/rowspan=\"(\d+)\"/i', $val, $rowValue, PREG_SET_ORDER);
						for ($i = 0; $i < $rowValue[0][1]; $i++) {
							$TABLE[$y+$i][$x] = $tdValue[0][1];
						}
						$x++;
					} elseif ($col) {
						preg_match_all('/colspan=\"(\d+)\"/i', $val, $colValue, PREG_SET_ORDER);
						for ($i = 0; $i < $colValue[0][1]; $i++) {
							$TABLE[$y][$x++] = $tdValue[0][1];
						}
					}
				} else {
					while ( isset($TABLE[$y][$x]) || $TABLE[$y][$x] ) {
						$x++;
					}
					$TABLE[$y][$x++] =$tdValue[0][1];
				}
			}
		}

		for ($i = 0; $i < count($TABLE); $i++) {
			ksort($TABLE[$i]);
		}
		return $TABLE;
	}

	static public function getTagA($html){
		$MatchRules = array(
			'/
			<a(?:.*?)href="(?:.*?)"(?:.*?)>
			(.*?)
			<\/a>
			/isxS'
		);
		preg_match_all($MatchRules[0], $html, $tagA,PREG_SET_ORDER);
		return $tagA;
	}

	static public function getTagInput($html){
		$MatchRules = array(
			'/
			<input(.*?)>
			/isxS'
		);
		preg_match_all($MatchRules[0], $html, $inputs, PREG_SET_ORDER);
		return $inputs;
	}
}}