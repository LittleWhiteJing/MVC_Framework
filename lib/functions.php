<?php
!defined('TOKEN') && exit("Access denied!");

//将数据写入文件，返回文件的大小
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

//生成控制器链接，方便在视图中使用
function controlmap($controller,$method){
	$pathstr = SITE_URL . "index.php?c=" . $controller . "&m=" . $method;
	return $pathstr;
}



//控制器重定向，方便控制器跳转操作
function redirect($controller,$method){
	$pathstr = SITE_URL . "index.php?c=" . $controller . "&m=" . $method;
	header('Location:'.$pathstr);
}

//获取当前所在的控制器和方法，返回数组
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