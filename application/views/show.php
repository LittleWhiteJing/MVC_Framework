<html>
	<head>
		<title>添加信息</title>
		<meta http-equiv="text/html;charset=utf-8"/>
	</head>
	<body>
		<form action = "<?php echo controlmap('user','add')?>" method = "post">
			用户名：<input type = "text" name = "username"/><br/>
			身份证：<input type = "text" name = "password"/><br/>
			<input type = "submit" value = "提交"/>
		</form>
	</body>
</html>