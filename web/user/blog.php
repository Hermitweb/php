<!DOCTYPE html>
<html lang="zh-CN">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>登录</title>

<link rel="stylesheet" href="css/style.css">

<body>
<a href="../index.php" class="fanhui"><img src="images/cha.png" alt=""></a>
<div class="login-container">
	<h1>登录</h1>
	
	<div class="connect">
		<p>进入自己的世界！</p>
	</div>
	
	<form action="blog.php" method="post" id="loginForm">
		<div>
			<input type="text" name="username" class="username" placeholder="用户名" autocomplete="off"/>
		</div>
		<div>
			<input type="password" name="password" class="password" placeholder="密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<button id="submit" type="submit">登 陆</button>
	</form>

	<a href="reg.php">
		<button type="button" class="register-tis">还有没有账号？</button>
	</a>

</div>

<script src="js/jquery.min.js"></script>
<!-- <script src="js/common.js"></script> -->
<!--背景图片自动更换-->
<script src="js/supersized.3.2.7.min.js"></script>
<script src="js/supersized-init.js"></script>
<!--表单验证-->
<!-- <script src="js/jquery.validate.min.js?var1.14.0"></script> -->

<?php
	include_once("../int.php");
	$data=$_POST;
	if(empty($data)){
		die();
	}
	$shuju=array(
		'uid'=>$data['username'],
		'password'=>MD5($data['password'])
	);
	$kuid=getOne("user","uid='$shuju[uid]'");
	$kustutas=$kuid['stutas'];
	
	if($kustutas!=1){
		echo "<script> alert('该账号已失效');location='blog.php';</script>";
	}else if($shuju['password'] = $kuid['password']){
		session_start();
		$_SESSION['user']= $shuju['uid'];
		echo "<script>alert('登录成功');location='../index.php';</script>";
	}else{
		echo "<script> alert('账号或密码错误');location='blog.php';</script>";
	}
?>
</div>
</body>
</html>