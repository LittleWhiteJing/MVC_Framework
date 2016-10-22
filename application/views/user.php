<html>
	<head>
		<title>用户信息</title>
		<meta http-equiv = "text/html;charset=utf-8"/>
	</head>
	<body>
		<table border="1" cellpadding="0" cellspacing= "0" width="350px" height="150px">
			<tr align = "center">
				<th>ID</th>
				<th>用户名</th>
				<th>身份证</th>
			</tr>
			<?php 
				foreach($userinfo as $value){
			?>
			<tr align = "center">
				<td>
					<?php echo $value['id'];?>
				</td>
				<td>
					<?php echo $value['username'];?>
				</td>
				<td>				
					<?php echo $value['password'];?>
				</td>
			<?php
				}
			?>
		</table>
		<a href = "<?php echo controlmap('user','show');?>">添加用户信息</a>
	</body>
</html>