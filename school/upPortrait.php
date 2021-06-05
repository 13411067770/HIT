<?php
//1903010226检验登录凭证
$loginPath = "../login.html";
include "../inc/data/session.php";

//1903010226限制文件上传格式大小
// if($_FILES["mypic"]["size"] > 102400){
// echo <<<END
// 	<script>
// 		alert("文件大小超过100k,上传失败！请重新上传！");
// 		history.back();
// 	</script>   	
// END;
// }
// elseif(($_FILES["mypic"]["type"] != "image/jpg")&&($_FILES["mypic"]["type"] != "image/png")&&($_FILES["mypic"]["type"] != "image/gif")){
// echo <<<END
// 	 <script>
// 		alert("文件格式不正确,上传失败！请重新上传！");
// 		history.back();
// 	 </script>
// END;
// }
// else{
	//1903010226规划文件保存信息
	//1903010226获取临时文件
	$upFile = $_FILES["mypic"]["tmp_name"];
	//1903010226判断新文件是否已经存在
	if($_FILES["mypic"]["error"] > 0){
		#上传失败
		// die("文件上传失败，请稍后再试")
		echo <<<END
		<script>
			alert("文件上传失败，请稍后再试！");
			history.back();
		</script>
END;
	}
	//1903010226获取新文件的保存路径和文件名
	$fileName = md5(time());
	$saveName = date("Ymd")."/";
	$pathName = "../inc/portrait/".$saveName.$fileName;

	//1903010226判断日期文件夹是否存在
	if(file_exists($pathName)) {
		//1903010226如果存在就退出
		echo <<<END
			<script>
				alert("文件上传失败，请稍后再试！");
				history.back();
			</script>
END;
	}
	//1903010226否则创建文件
	if(!file_exists("../inc/portrait/".$saveName)){
		mkdir("../inc/portrait/".$saveName);
	}

	//1903010226移动
	if(move_uploaded_file($upFile,$pathName)){
		//1903010226移动成功
		// echo "上传成功";
		//1903010226更新用户的头像
		//1903010226连接对象
		include "../inc/data/conn.php";
		//1903010226识别身份,更新字符串
		if($_SESSION['Role'] == "teacher"){
			$sql = "update lizj_te SET tepic = '$saveName$fileName'
					where teid = {$_SESSION['uId']}";
		}
		else{
			$sql = "update lizj_stu SET stupic = '$saveName$fileName'
					where stuid = {$_SESSION['uId']}";
		}
		//1903010226执行更新
		$conn->query($sql);
		//1903010226获取更新结束
		if($conn->affected_rows == 1){
			//1903010226删除原头像文件
			if($_SESSION["Pic"] != "student.png" && $_SESSION["Pic"] != "teacher.png"){
				unlink("../inc/portrait/".$_SESSION["Pic"]);
			}
			//1903010226成功，提示，跳转
			$_SESSION['Pic'] = $saveName.$fileName;
			echo <<<END
			<script>
				alert("头像更新成功！");
				location = "../index.php";
			</script>
END;
		}
		else{
			echo <<<END
			<script>
				alert("头像更新失败，请稍后再试！");
				history.back();
			</script>
END;
			//1903010226删除已生成的文件和文件夹
			unlink($pathName);
			// echo "已删除文件";
			if(!count(glob("../inc/portrait/".$saveName."*"))){
				rmdir("../inc/portrait/".$saveName);
				// echo "已删除文件夹";
			}
		}
	}
// }
?>