<!DOCTYPE html>
<html lang="zh-CN">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>注册</title>
<link rel="stylesheet" href="css/style.css">
<body>
<a href="../index.php" class="fanhui"><img src="images/cha.png" alt=""></a>
<div class="register-container">
	<h1>注册</h1>
	
	<div class="connect">
		<p>创造自己的世界！</p>
	</div>
	
	<form action="reg.php" method="post" id="registerForm">
		<div>
			<input type="text" name="username" class="username" placeholder="您的用户名" autocomplete="off"/>
		</div>
		<div>
			<input type="password" name="password" class="password" placeholder="输入密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div>
			<input type="password" name="confirm_password" class="confirm_password" placeholder="再次输入密码" oncontextmenu="return false" onpaste="return false" />
		</div>
		<div>
			<input type="text" name="phone_number" class="phone_number" placeholder="输入手机号码" autocomplete="off" id="number"/>
		</div>
		<div>
			<input type="email" name="email" class="email" placeholder="输入邮箱地址" oncontextmenu="return false" onpaste="return false" />
		</div>
		
		<button id="submit" type="submit">注 册</button>
	</form>
	<a href="blog.php">
		<button type="button" class="register-tis">已经有账号？</button>
	</a>

</div>

</body>
<script src="js/jquery.min.js"></script>
<!-- <script src="js/common.js"></script> -->
<!--背景图片自动更换-->
<script src="js/supersized.3.2.7.min.js"></script>
<script src="js/supersized-init.js"></script>
<!--表单验证-->
<!-- <script src="js/jquery.validate.min.js?var1.14.0"></script> -->
</html>
<?php
	include_once("../int.php");
	$data=$_POST;
	if(empty($data)){
		die();
	}

	$sql=array(
		'uid'=>$data['username'],
		'password'=>md5($data['password']),
		'regtime'=>time(),
		'phone'=>$data['phone_number'],
		'email'=>$data['email']
	);
	$length1 = strlen($data['username']); 
	$length2 = strlen($data['password']);
	$kuid=getOne("user","uid='$sql[uid]'");
	if(($data['username'])==''){   
		echo "<script> alert('账号不能为空');location='reg.php'; </script>";
		
	}
	else if(!($length1>=3 and $length1<12)){
			echo "<script> alert('用户名称长度为3位-12位之间!');location='reg.php';</script>";
	}
	else if(($data['password'])=='' || ($data['confirm_password'])==''){
			echo "<script> alert('密码不能为空');location='reg.php';</script>";
	}
	else if($data['password']!=$data['confirm_password']){
		echo "<script> alert('两次密码不一致');location='reg.php';</script>";
	}
	else if(!($length2>=6 and $length2<12)){
			echo "<script> alert('密码长度为6位-12位之间!');location='reg.php';</script>";
	}
	else if($kuid){
		echo "<script> alert('该账户已存在');location='reg.php';</script>";
	}
	else{
		$result=add("user",$sql);
		if($result){
			echo "<script> location='blog.php';alert('注册成功');</script>";
		}else{
			echo "<script> alert('注册失败');location='reg.php';</script>";
		}
	}
	


?>