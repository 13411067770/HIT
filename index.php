<?php
//1903010226检验登录凭证
$loginPath = "./login.html";
include "./inc/data/session.php";
//1903010226连接数据库
include "./inc/data/conn.php";
//1903010226查询学生
$sql = "select stuclass,stuid,stuname from lizj_stu where stuclass = ?";
if ($stmt = $conn->prepare($sql)){
	//绑定参数
	$stmt->bind_param("s",$stuClass);
	//获取班级信息
	$stuClass = "19计算机应用3-2班";
	//绑定结果
	$stmt->bind_result($stuClass,$stuId,$stuName);
	//执行预处理查询
	$stmt->execute();
	//获取所有信息
	$stmt->store_result();
	//1903010226打印结果记录数
	//$stmt->num_rows();
	//1903010226获取第一条记录
	// $stmt->fetch();
	//1903010226打印记录
	// echo "$stuClass,$stuId,$stuName";
	//1903010226释放内存，关闭连接
	// $stmt->free_result();
	// $stmt->close();
};
// 1903010226查询班级
$sql_class = "select stuclass,majorname from lizj_stuclass where majorname = ?";
if ($stmt_class = $conn->prepare($sql_class)){
	//1903010226绑定参数
	$stmt_class->bind_param("s",$majorName);
	//1903010226获取班级信息
	$majorName = "计算机应用技术";
	//1903010226绑定结果
	$stmt_class->bind_result($stuClass,$majorName);
	//1903010226执行预处理查询
	$stmt_class->execute();
	//1903010226获取所有信息
	$stmt_class->store_result();
	//1903010226打印结果记录数
	//$stmt->num_rows();
	//1903010226获取第一条记录
	// $stmt->fetch();
	//1903010226打印记录
	// echo "$majorName,$stuId,$stuName";
	//1903010226释放内存，关闭连接
	// $stmt->free_result();
	// $stmt->close();
};
?>
<!DOCTYPE html>
<html>
	<head>
		<title>哈尔滨工业大学</title>
		<link rel="stylesheet" type="text/css" href="./inc/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="./inc/css/style_index.css" />
	</head>
	<body>
		<!-- 1903010226头部 -->
		<div id="header">
			<!-- 1903010226logo -->
			<div id="logo">
				<a href=" ">
					<img src="./inc/pic/logo.png" alt="">
				</a>
			</div>
			<!-- 1903010226菜单栏 -->
			<div id="meun_header">
				<ul>
					<li><a href="#">首页</a></li>
					<li><a href="#">学校概况</a></li>
					<li><a href="#">国际合作</a></li>
					<li><a href="#">院系部门</a></li>
					<li><a href="#">科学研究</a></li>
					<li><a href="#">教师队伍</a></li>
					<li><a href="#">人才培养</a></li>
					<li><a href="#">人才招聘</a></li>
					<li><a href="#">招生就业</a></li>
				</ul>
			</div>
		</div>
		<!-- 1903010226内容 -->
		<div id="sth">
			<!-- 1903010226用户详情 -->
			<div id="user">
				<?php
				echo <<< END
				<img src="./inc/portrait/{$_SESSION['Pic']}">
END;
				if($_SESSION['Role'] == "teacher"){
				echo <<< END
					<span>您好！{$_SESSION['uName']} 工号：{$_SESSION['uId']} 系：{$_SESSION['Dep']}</span>
END;
				}
				else{
					echo <<< END
					<span>您好！{$_SESSION['uName']} 学号：{$_SESSION['uId']} 系：{$_SESSION['Dep']} 班级：{$_SESSION['uClass']}</span>
END;
				}
				?>
			</div>
			<!-- 1903010226用户菜单栏 -->
			<div id="sth_meun">
				<ul id="sth_meun_left">
					<li><a href="./index.php">个人主页</a></li>
					<li><a href="./school/tScoreln.php">教师成绩录入</a></li>
					<li><a href="./school/tTask.php">教学任务查询</a></li>
					<li><a href="#">学生成绩查询</a></li>
					<li><a href="#">学生课表查询</a></li>
					<li><a href="./school/user.php">更改密码</a></li>
					<li><a href="./school/portrait.php">更换头像</a></li>
				</ul>
				<ul id="sth_meun_right">
					<li><a href="./exit.php">注销</a></li>
				</ul>
			</div>
			<!-- 1903010226用户位置 -->
			<span id="place">
				<?php
				if($_SESSION['Role'] == "teacher"){
					echo <<< END
						当前位置：教师-首页
END;
				}
				else{
					echo <<< END
						当前位置：学生-首页
END;
				}
				?>
			</span>
			<!-- 1903010226用户个人信息 -->
			<form action="" method="post">
			    <label style="font-size: 14px;">请选择班级：</label>
			    <select style="width: 150px;height: 22px;">
			     <?php while($stmt_class -> fetch()){?>
			     <option value ="" ><?php echo $stuClass ?></option>
			     <?php }; ?>
			    <input type="submit" value="提交" class="button">
			</from>
			<table border="1" id="data">
				<tr>
				<th>序号</th>
				<th>班级</th>
				<th>学号</th>
				<th>姓名</th>
				<th>二级学院</th>
				</tr>
				<?php
				for($i=1;$stmt -> fetch() && $i<=$stmt -> num_rows;$i++){ 
				?>
					<tr>
						<td><?= $i?></td>
						<td><?=$stuClass?></td>
						<td><?=$stuId?></td>
						<td><?=$stuName?></td>
						<td>计算机学院</td>
					</tr>
				<?php
				};
				?>
			</table>
		</div>
		<!-- 1903010226底部菜单栏 -->
		<div id="foot">
			<div id="meun_foot">
				<ul>
					<h2>学校概况</h2>
					<div id="con_l">
						<ul>
							<li><a herf="#">学校简介</a></li>
							<li><a herf="#">概况一览</a></li>
							<li><a herf="#">学校历史</a></li>
							<li><a herf="#">历任领导</a></li>
							<li><a herf="#">现任领导</a></li>
							<li><a herf="#">校长寄语</a></li>
						</ul>
					</div>
					<div id="con_r">
						<ul>
							<li><a herf="#">学校标志</a></li>
							<li><a herf="#">老照片</a></li>
							<li><a herf="#">校园导游</a></li>
							<li><a herf="#">校园地图</a></li>
							<li><a herf="#">城市概览</a></li>
							<li><a herf="#">工大映像</a></li>
						</ul>
					</div>
				</ul>
				<ul>
					<h2>国际合作</h2>
					<li><a herf="#">交流概况</a></li>
					<li><a herf="#">国际合作</a></li>
					<li><a herf="">国际学生</a></li>
				</ul>
				<ul>
					<h2>院系部门</h2>
					<li><a herf="">党群机构</a></li>
					<li><a herf="">管理与服务机构</a></li>
					<li><a herf="">教学与科研机构</a></li>
				</ul>
				<ul>
					<h2>科学研究</h2>
					<li><a herf="">科研概况</a></li>
					<li><a herf="">学科专业</a></li>
					<li><a herf="">重点学科</a></li>
					<li><a herf="">博士后</a></li>
					<li><a herf="">学术期刊</a></li>
				</ul>
				<ul>
					<h2>教师队伍</h2>
					<li><a herf="">总体介绍</a></li>
					<li><a herf="">杰出人才</a></li>
					<li><a herf="">博士生导师</a></li>
					<li><a herf="">教学带头人</a></li>
					<li><a herf="">教师搜索</a></li>
				</ul>
				<ul>
					<h2>人才培养</h2>
					<li><a herf="">人才培养概况</a></li>
					<li><a herf="">本科生教育</a></li>
					<li><a herf="">研究生教育</a></li>
					<li><a herf="">国际学生教育</a></li>
					<li><a herf="">继续教育</a></li>
					<li><a herf="">奖贷学金</a></li>
				</ul>
				<ul style="width: 100px;">
					<h2>人才招聘</h2>
					<li><a herf="">青年科学家工作室学术带头人</a></li>
					<li><a herf="">引才计划青年项目</a></li>
					<li><a herf="">青年拔尖人才及准聘岗教师</a></li>
					<li><a herf="">优秀博士后</a></li>
					<li><a herf="">应聘方式</a></li>
				</ul>
				<ul>
					<h2>招生就业</h2>
					<li><a herf="">本科生招生</a></li>
					<li><a herf="">研究生招生</a></li>
					<li><a herf="">国际学生招生</a></li>
					<li><a herf="">继续教育招生</a></li>
					<li><a herf="">就业服务</a></li>
				</ul>
			</div>
			<!-- 1903010226外部链接 -->
			<div id="expand">
				<select name="常用链接">
					<option value="">常用链接</option>
					<option value="校医院"><a herf="#">校医院</a></option>
					<option value="设备共享平台"><a herf="#">设备共享平台</a></option>
					<option value="哈工大报"><a herf="#">哈工大报</a></option>
					<option value="网络电视"><a herf="#">网络电视</a></option>
					<option value="学报编辑部"><a herf="#">学报编辑部</a></option>
					<option value="哈工大学报（社科版）"><a herf="#">哈工大学报（社科版）</a></option>
				</select>
				<select>
					<option value="">校内部门导航</option>
					<option value="党群机构">--党群机构--</option>
					<option value="学校办公室">学校办公室</option>
					<option value="组织部">组织部l</option>
					<option value="宣传部/教师工作部">宣传部/教师工作部</option>
					<option value="统战部">统战部</option>
					<option value="纪委办公室">纪委办公室</option>
					<option value="学生工作部">学生工作部</option>
					<option value="研究生工作部">研究生工作部</option>
					<option value="保卫部">保卫部</option>
					<option value="工会">工会</option>
					<option value="机关党委">机关党委</option>
				</select>
				<!-- 1903010226校区网页 -->
				<ul>
					<li id="weihai"><a href="#">哈尔滨工业大学（威海）</a></li>
					<li id="shenzhen"><a href="#">哈尔滨工业大学（深圳）</a></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<!-- 1903010226版权声明 -->
		<div id="copy">
			<a href="#"><img src="inc/pic/img1.png"></a>
			<span>
				哈尔滨市南岗区西大直街92号 查号台：+86-451-86412114 P.C.:150001 Copyright © 2020 哈尔滨工业大学网络与信息中心
				<a href="#">黑ICP备05006863号</a>
			</span>
		</div>
	</body>
