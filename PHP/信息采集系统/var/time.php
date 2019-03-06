<?php
class time
{
	function getTime($fix=0)
	{
		date_default_timezone_set('Asia/Shanghai');
		return date('Y-m-d H:i:s',time()+$fix);
	}
}
?>