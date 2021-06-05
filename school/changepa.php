<?php 
//1903010226查票
$loginPath = "../login.html";
include "../inc/data/session.php";

//1903010226创建连接
include "../inc/data/conn.php";

//1903010226获取用户输入的数据：旧密码，新密码
$oldPa = md5($_POST["oldpa"]);
$newPa = md5($_POST["newpa1"]);

//获取当前用户密码
if ($_SESSION["Role"] == "teacher"){
	$sql = "select tepa from lizj_tea
				where teid = ?";
}
else{
	$sql = "select stupa from lizj_stu
				where stuid = ?";
	}
	
if (!($stmt = $conn->prepare($sql))){
	# 创建失败
	die("修改失败，请稍后再试！");
}
$stmt -> bind_param("s",$_SESSION['uId']);
$stmt -> execute();
//1903010226绑定结果
$stmt -> bind_result($pwd);
//1903010226保存结果
$stmt -> store_result();
$stmt -> fetch();

//1903010226修改密码
if ($_SESSION["Role"] == "teacher"){
	$sql = "update lizj_tea 
			set tepa = ? 
			where tepa = ? and teid = ?";
}
else{
	$sql = "update lizj_stu
			set stupa = ? 
			where stupa = ? and stuid =?";
}
if (!($stmt = $conn->prepare($sql))){
	# 1903010226创建失败
	die("修改失败，请稍后再试！");
}
$stmt -> bind_param("sss",$newPa,$oldPa,$_SESSION['uId']);
$stmt -> execute();

//1903010226根据sql返回的修改记录条数判断有无修改成功
if ($stmt -> affected_rows == 1){
	echo <<<END
	<script>
		alert("密码修改成功！");
		location = "../exit.php";
	</script>
	
END;
}
elseif($oldPa != $pwd){
	echo <<<END
		<script>
			alert("密码修改失败：旧密码输入有误！");
			location = "./user.php";
		</script>
END;
}
else{
	echo <<<END
			<script>
				alert("密码修改失败：新密码和旧密码不能一样！");
				location = "./user.php";
			</script>
END;
}
?>