<?php
/* ����ļ� */
error_reporting(E_ALL);
//������ڱ�ʶ
define('TOKEN',TRUE);
//�����Ŀ¼
define('ROOT_DIR', str_replace(array('\\','//'), '/', dirname(__FILE__) . '/'));  
//����������
require ROOT_DIR . "core/core.class.php";
//ʵ����������
$coreobj = new core();
$coreobj->run(); 

?>