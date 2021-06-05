<?php
//1903010226连接数据库
include "../../inc/data/conn.php";

if($_GET["type"] == 2){
	//1903010226查询班级
	$sql = "select lizj_task.stuclass from lizj_stuclass,lizj_task,lizj_major 
			where taskterm = ? and depname = ? 
			and lizj_task.stuclass=lizj_stuclass.stuclass
			and lizj_stuclass.majorname=lizj_major.majorname
			group by stuclass";
	if($stmt_class = $conn->prepare($sql)) {
		//1903010226绑定参数,,给参数赋值
		$stmt_class-> bind_param("ss",$taskTerm,$depName);
		$taskTerm = $_GET["str1"];
		$depName = $_GET["str2"];
		//1903010226绑定结果
		$stmt_class->bind_result($stuClass);
		//1903010226执行
		$stmt_class->execute();
		//1903010226保存结果
		$stmt_class->store_result();
	}
}
elseif($_GET["type"] == 4){
	//1903010226查询教师
	$sql = "select tename,lizj_task.teid from lizj_te,lizj_task
			where taskterm = ? and depname = ?
			and lizj_task.teid= lizj_te.teid
			group by tename";
	if($stmt_te = $conn->prepare($sql)) {
		//1903010226绑定参数,给参数赋值
		$stmt_te-> bind_param("ss",$taskTerm,$depName);
		$taskTerm = $_GET["str1"];
		$depName = $_GET["str2"];
		//1903010226绑定结果
		$stmt_te->bind_result($teName,$teId);
		//1903010226执行
		$stmt_te->execute();
		//1903010226保存结果
		$stmt_te->store_result();
	}
}
elseif($_GET["type"] == 3){
	//1903010226查询课程
	$sql = "select cname,lizj_task.cid from lizj_course,lizj_task,lizj_major
			where taskterm = ? and depname = ?
			and lizj_task.cid=lizj_course.cid
			and lizj_course.majorname=lizj_major.majorname
			group by cname";
	if($stmt_course = $conn->prepare($sql)) {
		//1903010226绑定参数,给参数赋值
		$stmt_course-> bind_param("ss",$taskTerm,$depName);
		$taskTerm = $_GET["str1"];
		$depName = $_GET["str2"];
		//1903010226绑定结果
		$stmt_course->bind_result($cName,$cId);
		//1903010226执行
		$stmt_course->execute();
		//1903010226保存结果
		$stmt_course->store_result();
	}
}
?>
	
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title></title>
</head>
<body>
<?php
if($_GET["type"] == 2){
//1903010226班级下拉列表输出
	if ($stmt_class->num_rows >0) {
		while($stmt_class->fetch()){
			echo <<<END
				<option value="$stuClass">$stuClass</option>
END;
		}
	}
	else{
		echo <<<END
			<option value="">暂无记录</option>
END;
	}
}
elseif($_GET["type"] == 3){
//1903010226课程下拉列表输出
	if ($stmt_course->num_rows >0){
		while ($stmt_course->fetch()){
			echo <<<END
			<option value="$cId">$cName</option>
END;
		}
	}
	else{
		echo <<<END
			<option value="">暂无记录</option>
END;
	}
}
elseif($_GET["type"] == 4){
//1903010226教师下拉列表输出
	if ($stmt_te->num_rows >0){
		while ($stmt_te->fetch()){
			echo <<<END
			<option value="$teId">$teName</option>
END;
		}
	}
	else{
		echo <<<END
			<option value="">暂无记录</option>
END;
	}
}

?>
</body>
</html>