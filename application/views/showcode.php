<html>
<head>
	<title>验证码使用</title>
	<meta http-equiv = "content-type" content = "text/html;charset=utf-8"/>
</head>
<body>
	<form action = "<?php echo controlmap('user','checkcode');?>" method = "post">
		<img src = "<?php echo $url;?>">
		<input type = "text" name = "checkcode"/>
		<input type = "submit" value = "提交"/>
	</form>
</body>
</html>