<?php
!defined('TOKEN') && exit("Access denied!");

//������д���ļ��������ļ��Ĵ�С
function writetofile($filename, &$data) {
	
    if ($fp = @fopen($filename, 'wb')) {
        
		if (PHP_VERSION >= '4.3.0' && function_exists('file_put_contents')) {
            return @file_put_contents($filename, $data);
        } else {
            flock($fp, LOCK_EX);
            $bytes = fwrite($fp, $data);
            flock($fp, LOCK_UN);
            fclose($fp);
            return $bytes;
        }
    } else {
        return 0;
    }
}

//���ɿ��������ӣ���������ͼ��ʹ��
function controlmap($controller,$method){
	$pathstr = SITE_URL . "index.php?c=" . $controller . "&m=" . $method;
	return $pathstr;
}



//�������ض��򣬷����������ת����
function redirect($controller,$method){
	$pathstr = SITE_URL . "index.php?c=" . $controller . "&m=" . $method;
	header('Location:'.$pathstr);
}

?>