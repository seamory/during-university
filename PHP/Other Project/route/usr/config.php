<?php
#DEFINE THE CONFIG OF MYSQL
function debugMysql($selectType='local')
{
	if($selectType=='remote')
	{
		define('DB_HOST','');
		define('DB_USERNAME', '');
		define('DB_PASSWORD', '');
		define('DB_CHARSET', 'utf8');
		define('DB_CHOSE', '');
	}
	else if($selectType=='local')
	{
		define('DB_HOST','localhost');
		define('DB_USERNAME', '');
		define('DB_PASSWORD', '');
		define('DB_CHARSET', 'utf8');
		define('DB_CHOSE', 'debug');
	}
	else
		die('SYSTEM ERROR!');
}
?>