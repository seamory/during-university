<?php
class arrayFunction
{
	function sepArray( $arr )
	{
		if( sizeof($arr) )
		{
			//获取二维数组rows
			$in=array('rows' => sizeof($arr), 'cols' =>sizeof($arr[0]));
			return $in;
		}
	}
}

?>