<!-- 视图示例文件 -->
<html>
<head>
	<title>示例视图</title>
	<meta http-equiv = "content-type" content="text/html;charset=utf-8"/>
</head>
<body>
	<h2><?php echo isset($app) ? "应用:".$app : '';?></h2>
	<h2><?php echo isset($controller) ? "控制器:".$controller : '';?></h2>
	<h2><?php echo isset($method) ? "方法:".$method : '';?></h2>
	<?php 
		if(isset($info)){
			foreach($info as $key => $value){
				echo $value['username'];
				echo "======";
				echo $value['password'];
				echo "<br>";
			}
		}
	?>
</body>
</html>