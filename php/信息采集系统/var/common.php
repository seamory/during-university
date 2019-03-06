<?php
class common
{
	public static function alertMsg($msg,$url)
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		echo '<script>alert("'.$msg.'");window.location.assign("'.$url.'")</script>';
	}
	public static function alert($msg)
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		echo '<script>alert("'.$msg.'")</script>';
	}
	public static function local($url)
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		echo '<script>window.location.assign("'.$url.'")</script>';
	}
}
?>
