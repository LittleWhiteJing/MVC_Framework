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

function sayhello(){
	
	return "hello world!!";
}
?>