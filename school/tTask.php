<?php
//检验登录凭证
$loginPath = "../login.html";
include "../inc/data/session.php";

//1903010226连接数据库
include "../inc/data/conn.php";

// 1903010226查询学院
$sql = "select depname from lizj_dep";
if($stmt_dep = $conn->prepare($sql)) {
	//1903010226执行
	$stmt_dep->execute();
	//1903010226绑定结果
	$stmt_dep->bind_result($depName);
	//1903010226保存结果
	$stmt_dep->store_result();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>哈尔滨工业大学</title>
		<link rel="stylesheet" type="text/css" href="../inc/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../inc/css/style_tTask.css?15613145" />
		<script type="text/javascript" src="../inc/js/ajax.js"></script>
	</head>
	<body>
		<!-- 1903010226头部 -->
		<div id="header">
			<!-- 1903010226logo -->
			<div id="logo">
				<a href=" ">
					<img src="../inc/pic/logo.png" alt="">
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
			<!-- 1903010226用户信息区域 -->
			<div id="user">
				<?php
				echo <<< END
					<img src="../inc/portrait/{$_SESSION['Pic']}">
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
					<li><a href="../index.php">个人主页</a></li>
					<li><a href="./tScoreln.php">教师成绩录入</a></li>
					<li><a href="./tTask.php">教学任务查询</a></li>
					<li><a href="#">学生成绩查询</a></li>
					<li><a href="#">学生课表查询</a></li>
					<li><a href="./user.php">更改密码</a></li>
					<li><a href="./portrait.php">更换头像</a></li>
				</ul>
				<ul id="sth_meun_right">
					<li><a href="../exit.php">注销</a></li>
				</ul>
			</div>
			<!-- 1903010226用户位置 -->
			<span id="place">
				<?php
				if($_SESSION['Role'] == "teacher"){
					echo <<< END
						当前位置：教师-教师用户查询
END;
				}
				else{
					echo <<< END
						当前位置：学生-教师用户查询
END;
				}
				?>
			</span>
			<!-- 1903010226查询条件区域 -->
			<div id="class_serach">
				<h2>查询条件</h2>
				<form action="" method="post" name="taskForm">
					<div>
					<!-- 1903010226学年学期学院下拉列表 -->
						学年
						<select class="" name="studyY" onchange="show('ajax/search.php','class',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,2);
																	show('ajax/search.php','course',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,3);
																	show('ajax/search.php','te',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,4)">
							<?php
							$stmt_year = 2002;
							$stmt_Year = (int)date("Y");
							if((int)date("M")<7){
								while($stmt_year < $stmt_Year){
								?>
									<option value="<?php echo substr($stmt_year,-2).substr($stmt_year+1,-2) ?>"><?php echo "$stmt_year-".($stmt_year+1) ?></option>
									<?php
									$stmt_year++;
								}
							}
							else{
								?>
								<?php
								while($stmt_year < $stmt_Year+1){
								?>
									<option value="<?php echo substr($stmt_year,-2).substr($stmt_year+1,-2) ?>"><?php echo "$stmt_year-".($stmt_year+1) ?></option>
									<?php
									$stmt_year++;
								}
							}
							?>
						</select>
						学期
						<select class="" name="term" onchange="show('ajax/search.php','class',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,2);
																show('ajax/search.php','course',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,3);
																show('ajax/search.php','te',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,4)">
							<option value="01">1</option>
							<option value="02">2</option>
						</select>
						系：
						<select class="" name="college" onchange="show('ajax/search.php','class',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,2);
																	show('ajax/search.php','course',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,3);
																	show('ajax/search.php','te',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.college.value,4)">
							<option value="">-请选择学院-</option>
							<?php
								if ($stmt_dep->num_rows >0) {
									while($stmt_dep->fetch()){
										echo <<<END
											<option value="$depName">$depName</option>
END;
									}
								}
								else{
									echo <<<END
										<option value="">暂无记录</option>
END;
								}
							?>
						</select>
						<input type="submit" value="查询" class="button">
					</div>
					<div>
					<!-- 1903010226班级下拉列表 -->
						按班级查询>>班级：
						<select class="" name="stuclass" id="class">
							<option value="">暂无记录</option>
						</select>
						<input type="button" value="查询" class="button" onclick="show('ajax/showTask.php','class_table',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.stuclass.value,2)">
					</div>
					<div>
					<!-- 1903010226课程下拉列表 -->
						按课程查询>>课程：
						<select class="" name="cid" id="course">
							<option value="">暂无记录</option>
						</select>
						<input type="button" value="查询" class="button" onclick="show('ajax/showTask.php','class_table',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.cid.value,3)">
					</div>
					<div>
					<!-- 1903010226教师下拉列表 -->
						按教师查询>>教师：
						<select class="" name="teid" id="te">
							<option value="">暂无记录</option>
						</select>
						<input type="button" value="查询" class="button" onclick="show('ajax/showTask.php','class_table',document.taskForm.studyY.value+''+document.taskForm.term.value,document.taskForm.teid.value,4)">
					</div>
				</form>
			</div>
			<!-- 1903010226查询输出区域 -->
			<div id="class_table">
			</div>
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
			<a href="#"><img src="../inc/pic/img1.png"></a>
			<span>
				哈尔滨市南岗区西大直街92号 查号台：+86-451-86412114 P.C.:150001 Copyright © 2020 哈尔滨工业大学网络与信息中心
				<a href="#">黑ICP备05006863号</a>
			</span>
		</div>
	</body>
