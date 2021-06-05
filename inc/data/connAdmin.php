<?php
	//1903010226配置连接参数
	$servername = "localhost";
	$username = "lizjadmin";
	$password = "12345678";
	$db = "lizj_edu_sys";
	//1903010226创建连接
	$conn = new mysqli($servername, $username, $password ,$db);
	//1903010226检测连接
	if ($conn->connect_error){
		die("Connection fail:" .$conn->connect_error);
		exit();
	}
?>