<?php
//检验登录凭证
$loginPath = "../login.html";
include "../inc/data/session.php";

//引入资源
require "../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

$src = "../inc/data/";
//准备文件，创建对象
//1903010226获取临时文件
$upFile = $_FILES["excel"]["name"];
$upFile = $src . $upFile;
echo $upFile;
//1903010226判断新文件是否已经存在
if($_FILES["excel"]["error"] > 0){
	#上传失败
	// die("文件上传失败，请稍后再试")
	echo <<<END
	<script>
		alert("文件上传失败，请稍后再试！");
		history.back();
	</script>
END;
}
$spreadSheet = IOFactory::load($upFile);
//1903010226获取第一张表
$workSheet = $spreadSheet->getsheet(0);
//1903010226取得总行数
$rows = $workSheet -> getHighestRow();

//插入学生记录
//1903010226连接数据库
include "../inc/data/conn.php";
$sql = "insert into lizj_score(taskid,stuid,scnormal,scfinal,scoverall)
		values(2,?,?,?,?)";
if(!$stmt = $conn->prepare($sql)){
	die("失败");
}
//循环读取每一个学生的成绩，在表中插入记录
$count = 0;
for($i = 2;$i <= $rows;$i++){
	$stuId = $workSheet->getCell("A$i")->getValue();
	$scNormal = $workSheet->getCell("E$i")->getValue();
	$scFinal = $workSheet->getCell("F$i")->getValue();
	$scOverall = $scNormal * 0.5 + $scFinal * 0.5;
	
	if($stuId == ""){
	  break;
	 }
	$stmt->bind_param("sddd",$stuId,$scNormal,$scFinal,$scOverall);
	$stmt->execute();
	if($stmt->affected_rows == 1){
		$count++;
	}
}
if ($count > 0){
echo <<<END
	<script>
	alert("成功添加{$count}个学生的记录");
	location = "./tScoreln.php";
	</script>
  
END;
}
else{
echo <<<END
	<script>
	alert("添加记录失败!");
	location = "./tScoreln.php";
	</script>
END;
}
?>