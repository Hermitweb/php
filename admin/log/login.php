<?php
	session_start();
	include_once(__DIR__ . "/../int.php");
	
	// 处理登录请求
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$data = $_POST;
		
		if(!empty($data['uid']) && !empty($data['password'])) {
			$shuju = array(
				'uid' => $data['uid'],
				'password' => md5($data['password'])
			);
			
			$kuid = getOne("admin", "uid='{$shuju['uid']}'");
			
			if($kuid) {
				$kustutas = $kuid['stutas'];
				
				if($kustutas != 1) {
					echo "<script>alert('该账号已失效');location='login.php';</script>";
					exit();
				} else if($shuju['password'] === $kuid['password']) {
					$session = array(
						'name' => $kuid['name'],
						'uid' => $kuid['uid']
					);
					$_SESSION['user'] = $session;
					echo "<script>alert('登录成功');location='../index.php';</script>";
					exit();
				} else {
					echo "<script>alert('账号或密码错误');</script>";
				}
			} else {
				echo "<script>alert('账号或密码错误');</script>";
			}
		}
	}
?>
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
		
		$("#submitForm").submit(function(e) {
			e.preventDefault();
			var uid = $("#name").val();
			var password = $("#pwd").val();
			
			if(uid === '' || password === '') {
				alert('请输入账号和密码');
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: "login.php",
				data: $(this).serialize(),
				success: function(response) {
					// 检查是否包含登录成功
					if(response.indexOf('登录成功') !== -1) {
						window.location.href = '../index.php';
					} else if(response.indexOf('账号或密码错误') !== -1) {
						alert('账号或密码错误');
					} else if(response.indexOf('该账号已失效') !== -1) {
						alert('该账号已失效');
					}
				},
				error: function() {
					// 如果AJAX失败，使用传统表单提交
					$("#submitForm")[0].submit();
				}
			});
		});
	});
</script>
</head>
<body>
	<div id="login_center">
		<div id="login_area">
			<div id="login_box">
				<div id="login_form">
					<form id="submitForm" method="post">
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
