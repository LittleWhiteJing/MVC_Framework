<html>
	<head>
		<title>添加信息</title>
		<meta http-equiv="text/html;charset=utf-8"/>
	</head>
	<body>
		<form action = "<?php echo controlmap('user','upload')?>" method = "post" enctype="multipart/form-data">
			用户名：<input type = "text" name = "username"/><br/>
			身份证：<input type = "text" name = "password"/><br/>
			上传文件：<input type = "file" name = "testfile"/><br/>
			验证码： <img src="<?php echo controlmap('user','checkcode');?>" onclick="this.src='<?php echo controlmap('user','checkcode');?>&id='+Math.random()"/><br><br>
			<input type = "submit" value = "提交"/>
		</form>
	</body>
</html>