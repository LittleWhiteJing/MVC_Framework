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

//��ȡ��ǰ���ڵĿ������ͷ�������������
function getcurrcm(){
	$pathstr = $_SERVER['QUERY_STRING'];
	$posarr = explode('&',$pathstr);
	$pos1 = strrpos($posarr[0],'=');
	$pos2 = strrpos($posarr[1],'=');
	if($pos1 !== false)
		$arr['controller'] = substr($posarr[0],$pos1+1);
	if($pos2 !== false)
		$arr['method'] = substr($posarr[1],$pos2+1);
	return $arr;
}

?>