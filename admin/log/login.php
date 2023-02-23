<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>admin-登录</title>
<link href="style/authority/login_css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#login_ret").click(function(){
			$(window).attr("location", "reg.php");
		});
	});
	
</script>
</head>
<body>
	<div id="login_center">
		<div id="login_area">
			<div id="login_box">
				<div id="login_form">
					<form id="submitForm" action="" method="post">
						<div id="login_tip2">
							<span id="login_err" class="sty_txt2"></span>
						</div>
						<div>
							账&nbsp;&nbsp;&nbsp;&nbsp;号：<input type="text" name="uid" class="username" id="name">
						</div>
						<div>
							密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="password" class="pwd" id="pwd">
						</div>
						<div id="btn_area">
							<input type="submit" class="login_btn" id="login_sub"  value="登  录">
							<input type="button" class="login_btn" id="login_ret" value="注  册">
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
	$shuju=array(
		'uid'=>$data['uid'],
		'password'=>MD5($data['password'])
	);
	$kuid=getOne("admin","uid='$shuju[uid]'");
	$kustutas=$kuid['stutas'];
	$session=array(
		'name'=>$kuid['name'],
		'uid'=>$kuid['uid']
	);
	if($kustutas!=1){
		echo "<script> alert('该账号已失效');location='login.php';</script>";
	}else if($shuju['password'] = $kuid['password']){
		session_start();
		$_SESSION['user']= $session;
		echo "<script>alert('登录成功');location='../index.php';</script>";
	}else{
		echo "<script> alert('账号或密码错误');</script>";
	}
?>