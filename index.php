<?php
/* ����ļ� */
error_reporting(E_ALL);
//������ڱ�ʶ
define('TOKEN',TRUE);
//��������ļ�
define('IN_FILE','index.php');
//�����Ŀ¼
define('ROOT_DIR', str_replace(array('\\','//'), '/', dirname(__FILE__) . '/'));
//������վĿ¼
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, -9));
//����Ӧ��Ŀ¼
define('APP_DIR', ROOT_DIR . "application/");
//���������Ŀ¼
define('CONTROLLERS_DIR', APP_DIR . "controllers");
//����ģ��Ŀ¼
define('MODELS_DIR', APP_DIR . "models/");
//������ͼĿ¼
define('VIEWS_DIR', APP_DIR . "views/");
//����������
require ROOT_DIR . "core/core.class.php";
//ʵ����������
$coreobj = new core();
$coreobj->run(); 

?>