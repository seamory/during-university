<?php

#DEFINE THE VERIFY STRING 
#ACCORDING TO 1 TO 3, THE LEAVEL OF VERIFY INCREASING
function generateVerifyString($type)
{
	if($type==1)
		$string=join('',range(0,9));
	else if($type==2)
		$string=join('',array_merge(range(0,9),range('a','z')));
	else if($type==3)
		$string=join('',array_merge(range(0,9),range('a','z'),range('A','Z')));
	return substr(str_shuffle($string),0,5);
}

#DEFINE CONFIG OF FONTS
//msyh.ttc CAN NOT TO USE
//Deng.ttf CAN NOT TO USE
function selFont($sel)
{
	$fonts=array('msyh.ttc','Deng.ttf','STXINGKA.TTF');
	switch($sel)
	{
		case 0 : $font='../resource/fonts/'.$fonts[0];
		break;
		case 1 : $font='../resource/fonts/'.$fonts[1];
		break;
		case 2 : $font='../resource/fonts/'.$fonts[2];
		break;
		default :
			$font='../resource/fonts/'.$fonts[mt_rand(0,count($fonts)-1)];
	}
	return $font;
}
?>