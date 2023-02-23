<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	session_destroy();
	echo "<script>alert('退出账号成功');location='index.php';</script>";

?>