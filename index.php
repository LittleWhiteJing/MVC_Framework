<?php
/* 入口文件 */
error_reporting(E_ALL);
//定义入口标识
define('TOKEN',TRUE);
//定义根目录
define('ROOT_DIR', str_replace(array('\\','//'), '/', dirname(__FILE__) . '/'));  
//包含核心类
require ROOT_DIR . "core/core.class.php";
//实例化核心类
$coreobj = new core();
$coreobj->run(); 

?>