<?php
	// header('Content-Type: text/html; charset=utf-8');
	$db_host="localhost";
	$db_user="root";
	$db_password="root";
	$db_name="db_news";
	$link=mysqli_connect($db_host,$db_user,$db_password,$db_name);
	if($link===false){
		echo "<script>alert('连接数据库失败')</script>";
	}
	define('PRE','tb_');
	$sql=mysqli_query($link,"set names utf8");
	include_once("db.php");

?>