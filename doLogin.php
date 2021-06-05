<?php
//1903010226创建连接
include "./inc/data/conn.php";
//1903010226设置sql查询字符串
//1903010226取用户登录信息
$userId = $_POST["userid"];
$userPa = md5($_POST["password"]);
$role = $_POST["status"];
if($role == "teacher"){
	//1903010226查询教师
	$sql = "select tepic,tename,depname from lizj_te where teid = ? and tepa = ?";
}
else{
	//1903010226查询同学
	$sql = "select stupic,lizj_stu.stuname,lizj_stu.stuclass,depname 
			from lizj_stu,lizj_stuclass,lizj_major
			where stuid = ? and stupa = ? and lizj_stu.stuclass = lizj_stuclass.stuclass and lizj_stuclass.majorname = lizj_major.majorname";
}
//1903010226执行查询
//$re = $conn->query($sql);
if(! $stmt = $conn->prepare($sql)){
	die("查询失败，请稍后再试");
}
//1903010226绑定参数
$stmt->bind_param("ss",$userId,$userPa);
//1903010226执行查询
$stmt->execute();
//1903010226绑定结果
if($role == "teacher"){
	$stmt->bind_result($Pic,$userName,$depName);
}
else{
	$stmt->bind_result($Pic,$userName,$stuClass,$depName);
}
//1903010226保存结果
$stmt->store_result();
//1903010226判断结果
if($stmt->num_rows==1){
	//1903010226获取第一条记录
	$stmt->fetch();
	//发放用户登录凭证
	session_start();
	$_SESSION["Role"] = $role;
	$_SESSION["uName"] = $userName;
	$_SESSION["uId"] = $userId;
	$_SESSION["Dep"] = $depName;
	$_SESSION["Pic"] = $Pic;
	if($role == "student"){
		$_SESSION["uClass"] = $stuClass;
	}
	echo <<<END
	<script>
		alert("欢迎你，$userName");
		location = "index.php";
	</script>
END;
}
else{
	echo <<<END
		<script>
			alert("登录失败");
			history.back();
		</script>
END;
}