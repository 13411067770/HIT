<?php
//连接数据库
include "../../inc/data/conn.php";

//教学任务查询
//type=1 学年学期+学院
//type=2 学年学期+班级名称
//type=3 学年学期+课程
//type=4 学年学期+教师
$type = $_GET["type"];
if($type == 2){
	//1903010226教学任务查询：学年学期+班级名称
	//单表查询
	//$sql = "select stuclass,teid,cid from lizj_task where taskterm = ? and stuclass = ?";
	//多表查询
	$sql = "select stuclass,ctype,tename,cname,cweekh,cweek,ctotalh,cexam
			from lizj_task,lizj_te,lizj_course
			where taskterm = ? and stuclass = ? 
			and lizj_te.teid = lizj_task.teid 
			and lizj_task.cid = lizj_course.cid";
	if ($stmt_task = $conn->prepare($sql)){
		//1903010226绑定参数，给参数赋值
		$stmt_task->bind_param("ss",$taskTerm,$stuClass);
		$taskTerm = $_GET["str1"];
		$stuClass = $_GET["str2"];
	}
}
elseif($type == 3){
	//1903010226教学任务查询：学年学期+课程
	//单表查询
	//$sql = "select stuclass,teid,cid from lizj_task where taskterm = ? and teid = ?";
	//多表查询
	$sql = "select lizj_task.stuclass,ctype,tename,cname,cweekh,cweek,ctotalh,cexam
			from lizj_te,lizj_task,lizj_course
			where taskterm = ? and lizj_course.cid = ? 
			and lizj_te.teid = lizj_task.teid 
			and lizj_task.cid = lizj_course.cid";
	if ($stmt_task = $conn->prepare($sql)){
		//1903010226绑定参数，给参数赋值
		$stmt_task->bind_param("ss",$taskTerm,$cId);
		$taskTerm = $_GET["str1"];
		$cId = $_GET["str2"];
	}
}
elseif($type == 4){
	//1903010226教学任务查询：学年学期+教师
	//单表查询
	//$sql = "select stuclass,teid,cid from lizj_task where taskterm = ? and teid = ?";
	//多表查询
	$sql = "select lizj_task.stuclass,ctype,tename,cname,cweekh,cweek,ctotalh,cexam
			from lizj_te,lizj_task,lizj_course
			where taskterm = ? and lizj_te.teid = ? 
			and lizj_te.teid = lizj_task.teid 
			and lizj_task.cid = lizj_course.cid";
	if ($stmt_task = $conn->prepare($sql)){
		//1903010226绑定参数，给参数赋值
		$stmt_task->bind_param("ss",$taskTerm,$teId);
		$taskTerm = $_GET["str1"];
		$teId = $_GET["str2"];
	}
}
//1903010226执行
$stmt_task->execute();
//1903010226绑定结果
$stmt_task->bind_result($stuClass,$cType,$teName,$cName,$cWeekh,$cWeek,$cTotalh,$cExam);
//1903010226保存结果
$stmt_task->store_result();
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
	<from>
		<div id="output">
			<input type="button" value="导出EXCEL" class="buton">
			<span>点击导出EXCEL没有反应，请先关掉上网助手或者按住ctrl键点击按钮！！</span>
		</div>
		<!-- 1903010226教学任务输出 -->
			<?php
			if ($stmt_task->num_rows > 0){
			?>
			<table border="1" id="data" >
				<tr>
					<th>班级名称</th>
					<th>任课教师</th>
					<th>课程名称</th>
					<th>课程类型</th>
					<th>周课时</th>
					<th>起止周</th>
					<th>总课时</th>
					<th>考核方式</th>
				</tr>
			<?php
			while($stmt_task->fetch()){
				echo <<< END
				<tr>
					<td>$stuClass</td>
					<td>$teName</td>
					<td>$cName</td>
					<td>$cType</td>
					<td>$cWeekh</td>
					<td>$cWeek</td>
					<td>$cTotalh</td>
					<td>$cExam</td>
				</tr>
END;
			}
			?>
			</table>
			<?php
			}
			else{
				echo "查询结果为空！";
			}
			?>
	</from>
</body>
</html>