<?php
/* 入口文件 */
error_reporting(E_ALL);
//定义入口标识
define('TOKEN',TRUE);
//定义入口文件
define('IN_FILE','index.php');
//定义根目录
define('ROOT_DIR', str_replace(array('\\','//'), '/', dirname(__FILE__) . '/'));
//定义网站目录
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, -9));
//定义应用目录
define('APP_DIR', ROOT_DIR . "application/");
//定义控制器目录
define('CONTROLLERS_DIR', APP_DIR . "controllers");
//定义模型目录
define('MODELS_DIR', APP_DIR . "models/");
//定义视图目录
define('VIEWS_DIR', APP_DIR . "views/");
//包含核心类
require ROOT_DIR . "core/core.class.php";
//实例化核心类
$coreobj = new core();
$coreobj->run(); 

?>