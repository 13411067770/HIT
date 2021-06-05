<?php 
//1903010226引入资源
require "../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

//1903010226准备文件创建对象
$file = "../inc/data/3-2班.xlsx";
$spreadSheet = IOFactory::load($file);

//1903010226获取第一张表
$workSheet = $spreadSheet->getsheet(0);

//1903010226读学号
// $stuId = $workSheet->getCell("A2")->getValue();

//1903010226取得总行数
$rows = $workSheet -> getHighestRow();

//1903010226获取所有学生期末成绩
for($i = 2;$i <= $rows;$i++){
	// $stuId = $workSheet->getCell("B".$i)->getValue();
	// $stuSc = $workSheet->getCell("F".$i)->getValue();
	// echo "$stuId"."  "."$stuSc";
	// echo "<br>";
	$stu_final[] = $workSheet->getCell("B".$i)->getValue() . "  " . $workSheet->getCell("F".$i)->getValue();
}
var_dump($stu_final);
?>