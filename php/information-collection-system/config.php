<?php
/** 定义根目录 */
define('ROOT', dirname(__FILE__));

/** 定义插件目录(相对路径) */
define('PLUGIN', '/usr/plugins');

/** 定义模板目录(相对路径) */
define('THEME', '/usr/theme');

/** 后台路径(相对路径) */
define('ADMIN', '/admin/');

/* 开放平台接口 */
define('WB_KEY','');
define('WB_SEC','');
define('WB_CBU','http://mw.myworldbooks.cn/oAuth/weibo/callback.php');

/** 设置包含路径 */
@set_include_path(get_include_path() . PATH_SEPARATOR
. ROOT. '/var' . PATH_SEPARATOR
. ROOT . PLUGIN . PATH_SEPARATOR
. ROOT . '/var/function' . PATH_SEPARATOR
. ROOT . '/usr/theme' . PATH_SEPARATOR
);

/** 设置文件包含 */
/** CLASS */
//require_once 'debug.php';
require_once 'mysql.php';
require_once 'entry.php';
require_once 'common.php';
require_once 'userAction.php';
require_once 'array.php';
require_once 'time.php';
require_once 'formAction.php';
require_once 'verifyImage.php';
require_once 'saetv2.ex.class.php';
require_once 'pageControl.php';
/** FUNCTION */

/** 设置数据库连接 */
mysql::MysqlType('local');
/** 连接数据库 **/
mysql::connect();
/** 启动全局会话 */
session_start();
?>