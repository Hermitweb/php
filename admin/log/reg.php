<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>admin-注册</title>
<link href="style/authority/login_css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
</head>
<body>
	<div id="login_center">
		<div id="login_area">
			<div id="login_box">
				<div id="login_form">
					<form id="submitForm" action="reg.php" method="post">
						<div id="login_tip">
							<span id="login_err" class="sty_txt2"></span>
						</div>
						<div>
							 用&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<input type="text" name="name" class="username" id="username" placeholder="建议用英文或数字,长度为6">
						</div>
						<div>
							账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：<input type="text" name="username" class="username" id="pwd">
						</div>
						<div>
							密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="password" class="pwd" id="pwd">
						</div>
						<div>
							再次输入密码：<input type="password" name="r_password" class="pwd" id="pwd">
						</div>
						<div>
							手&nbsp;&nbsp;机&nbsp;&nbsp;号&nbsp;&nbsp;码：&nbsp;<input type="text" name="phone" class="phone" id="name">
						</div>
						<div id="btn_area">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" class="login_btn" id="login_ret" value="注  册"><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="login.php" class="">已有账号？</a>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
<?php
	include_once("../int.php");
	$data=$_POST;
	if(empty($data)){
		die();
	}

	$sql=array(
		'name'=>$data['name'],
		'uid'=>$data['username'],
		'password'=>md5($data['password']),
		'regtime'=>time(),
		'phone'=>$data['phone']
		
	);
	$length1 = strlen($data['username']); 
	$length2 = strlen($data['password']);
	$length3 = strlen($data['phone']);
	$length4 = strlen($data['name']);
	$kuid=getOne("admin","uid='$sql[uid]'");
	if(($data['username'])==''){   
		echo "<script> alert('账号不能为空');</script>";	
	}
	else if(!($length1>=3 and $length1<12)){
			echo "<script> alert('账号长度为3位-12位之间!');</script>";
	}else if($length4>6){
			echo "<script> alert('用户名称长度为6');</script>";
	}
	else if($length3!=11){
			echo "<script> alert('手机号码格式错误');</script>";
	}
	else if(($data['username'])=='' || ($data['password'])==''){
			echo "<script> alert('密码不能为空');</script>";
	}
	else if($data['password']!=$data['r_password']){
		echo "<script> alert('两次密码不一致');</script>";
	}
	else if(!($length2>=6 and $length2<12)){
			echo "<script> alert('密码长度为6位-12位之间!');</script>";
	}
	else if($kuid){
		echo "<script> alert('该账户已存在');</script>";
	}
	else{
		$result=add("admin",$sql);
		if($result){
			echo "<script> location='login.php';alert('注册成功');</script>";
		}else{
			echo "<script> alert('注册失败');</script>";
		}
	}
	


?>