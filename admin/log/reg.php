<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理员注册 - News Platform</title>
  <link href="style/authority/login_css.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/jquery-1.7.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div id="login_center">
    <div id="login_area">
      <div class="login-left">
        <div class="login-brand">
          <h1><i class="fas fa-newspaper"></i> News Platform</h1>
          <p>专业的新闻管理平台，助力内容创作与发布</p>
        </div>
        <div class="login-features">
          <h3>平台特色</h3>
          <ul>
            <li><i class="fas fa-shield-alt"></i> 安全可靠的登录验证</li>
            <li><i class="fas fa-chart-line"></i> 数据统计实时分析</li>
            <li><i class="fas fa-mobile-alt"></i> 响应式界面设计</li>
            <li><i class="fas fa-lock"></i> 严格的权限管理</li>
          </ul>
        </div>
      </div>
      <div id="login_box">
        <div id="login_form">
          <div class="login-header">
            <h2>创建管理员账号</h2>
            <p>请填写以下信息完成注册</p>
          </div>
          <?php if (!empty($message)): ?>
          <div id="login_tip2">
            <span id="login_err"><?php echo htmlspecialchars($message); ?></span>
          </div>
          <?php endif; ?>
          <form id="submitForm" action="reg.php" method="post">
            <div class="form-group">
              <label><i class="fas fa-user"></i> 用户名称</label>
              <input type="text" name="name" class="username" id="name" placeholder="建议用中文，长度不超过6位">
            </div>
            <div class="form-group">
              <label><i class="fas fa-id-card"></i> 登录账号</label>
              <input type="text" name="username" class="username" id="uid" placeholder="3-12位字母数字下划线">
            </div>
            <div class="form-group">
              <label><i class="fas fa-lock"></i> 密码</label>
              <input type="password" name="password" class="pwd" id="pwd" placeholder="6-12位字符">
            </div>
            <div class="form-group">
              <label><i class="fas fa-check"></i> 确认密码</label>
              <input type="password" name="r_password" class="pwd" id="pwd2" placeholder="再次输入密码">
            </div>
            <div class="form-group">
              <label><i class="fas fa-phone"></i> 手机号码</label>
              <input type="text" name="phone" class="phone" id="phone" placeholder="11位手机号码">
            </div>
            <div id="btn_area">
              <button type="submit" class="login_btn" id="login_sub"><i class="fas fa-user-plus"></i> 注册</button>
              <button type="button" class="login_btn" id="login_ret"><i class="fas fa-sign-in-alt"></i> 返回登录</button>
            </div>
          </form>
          <div class="login-footer">
            <p>已有账号？<a href="login.php">立即登录</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    $("#login_ret").click(function() {
      window.location = "login.php";
    });

    $("#name").on('input', function() {
      var val = $(this).val();
      if (val && val.length > 6) {
        alert('用户名称长度不能超过6位');
        $(this).val(val.substring(0, 6));
      }
    });

    $("#uid").on('input', function() {
      var val = $(this).val();
      if (val && !/^[a-zA-Z0-9_]{3,12}$/.test(val)) {
        $(this).addClass('input-error');
      } else {
        $(this).removeClass('input-error');
      }
    });

    $("#pwd, #pwd2").on('input', function() {
      var val = $(this).val();
      if (val && (val.length < 6 || val.length > 12)) {
        $(this).addClass('input-error');
      } else {
        $(this).removeClass('input-error');
      }
    });

    $("#phone").on('input', function() {
      var val = $(this).val();
      if (val && !/^1[3-9]\d{9}$/.test(val)) {
        $(this).addClass('input-error');
      } else {
        $(this).removeClass('input-error');
      }
    });

    $("#submitForm").submit(function(e) {
      var name = $("#name").val().trim();
      var uid = $("#uid").val().trim();
      var pwd = $("#pwd").val();
      var pwd2 = $("#pwd2").val();
      var phone = $("#phone").val().trim();

      if (!name) {
        e.preventDefault();
        alert('请输入用户名称');
        return false;
      }

      if (name.length > 6) {
        e.preventDefault();
        alert('用户名称长度不能超过6位');
        return false;
      }

      if (!uid) {
        e.preventDefault();
        alert('请输入登录账号');
        return false;
      }

      if (!/^[a-zA-Z0-9_]{3,12}$/.test(uid)) {
        e.preventDefault();
        alert('账号格式不正确（3-12位字母数字下划线）');
        return false;
      }

      if (!pwd) {
        e.preventDefault();
        alert('请输入密码');
        return false;
      }

      if (pwd.length < 6 || pwd.length > 12) {
        e.preventDefault();
        alert('密码长度应为6-12位');
        return false;
      }

      if (pwd !== pwd2) {
        e.preventDefault();
        alert('两次密码不一致');
        return false;
      }

      if (!phone) {
        e.preventDefault();
        alert('请输入手机号码');
        return false;
      }

      if (!/^1[3-9]\d{9}$/.test(phone)) {
        e.preventDefault();
        alert('手机号码格式不正确');
        return false;
      }

      $("#login_sub").prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> 注册中...');
      return true;
    });
  });
  </script>
</body>
</html>
<?php
  include_once("../int.php");
  
  $data = $_POST;
  if (empty($data)) {
    die();
  }

  $sql = array(
    'name' => $data['name'],
    'uid' => $data['username'],
    'password' => Security::hashPassword($data['password']),
    'regtime' => date('Y-m-d H:i:s'),
    'phone' => $data['phone'],
    'stutas' => 1
  );

  $length1 = strlen($data['username']);
  $length2 = strlen($data['password']);
  $length3 = strlen($data['phone']);
  $length4 = strlen($data['name']);
  
  $kuid = getOne("admin", "uid='" . Security::clean($sql['uid']) . "'");

  $message = '';

  if (empty($data['username'])) {
    $message = '账号不能为空';
  } else if (!($length1 >= 3 && $length1 <= 12)) {
    $message = '账号长度为3-12位';
  } else if ($length4 > 6) {
    $message = '用户名称长度不能超过6位';
  } else if (!preg_match('/^1[3-9]\d{9}$/', $data['phone'])) {
    $message = '手机号码格式错误';
  } else if (empty($data['password'])) {
    $message = '密码不能为空';
  } else if ($data['password'] != $data['r_password']) {
    $message = '两次密码不一致';
  } else if (!($length2 >= 6 && $length2 <= 12)) {
    $message = '密码长度为6-12位';
  } else if ($kuid) {
    $message = '该账户已存在';
  } else {
    $result = add("admin", $sql);
    if ($result) {
      Logger::info('管理员注册成功', ['uid' => $sql['uid']]);
      echo "<script>location='login.php';alert('注册成功');</script>";
      exit;
    } else {
      $message = '注册失败';
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理员注册 - News Platform</title>
  <link href="style/authority/login_css.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/jquery-1.7.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div id="login_center">
    <div id="login_area">
      <div class="login-left">
        <div class="login-brand">
          <h1><i class="fas fa-newspaper"></i> News Platform</h1>
          <p>专业的新闻管理平台，助力内容创作与发布</p>
        </div>
        <div class="login-features">
          <h3>平台特色</h3>
          <ul>
            <li><i class="fas fa-shield-alt"></i> 安全可靠的登录验证</li>
            <li><i class="fas fa-chart-line"></i> 数据统计实时分析</li>
            <li><i class="fas fa-mobile-alt"></i> 响应式界面设计</li>
            <li><i class="fas fa-lock"></i> 严格的权限管理</li>
          </ul>
        </div>
      </div>
      <div id="login_box">
        <div id="login_form">
          <div class="login-header">
            <h2>创建管理员账号</h2>
            <p>请填写以下信息完成注册</p>
          </div>
          <?php if (!empty($message)): ?>
          <div id="login_tip2">
            <span id="login_err"><?php echo htmlspecialchars($message); ?></span>
          </div>
          <?php endif; ?>
          <form id="submitForm" action="reg.php" method="post">
            <div class="form-group">
              <label><i class="fas fa-user"></i> 用户名称</label>
              <input type="text" name="name" class="username" id="name" placeholder="建议用中文，长度不超过6位" value="<?php echo htmlspecialchars($data['name'] ?? ''); ?>">
            </div>
            <div class="form-group">
              <label><i class="fas fa-id-card"></i> 登录账号</label>
              <input type="text" name="username" class="username" id="uid" placeholder="3-12位字母数字下划线" value="<?php echo htmlspecialchars($data['username'] ?? ''); ?>">
            </div>
            <div class="form-group">
              <label><i class="fas fa-lock"></i> 密码</label>
              <input type="password" name="password" class="pwd" id="pwd" placeholder="6-12位字符">
            </div>
            <div class="form-group">
              <label><i class="fas fa-check"></i> 确认密码</label>
              <input type="password" name="r_password" class="pwd" id="pwd2" placeholder="再次输入密码">
            </div>
            <div class="form-group">
              <label><i class="fas fa-phone"></i> 手机号码</label>
              <input type="text" name="phone" class="phone" id="phone" placeholder="11位手机号码" value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>">
            </div>
            <div id="btn_area">
              <button type="submit" class="login_btn" id="login_sub"><i class="fas fa-user-plus"></i> 注册</button>
              <button type="button" class="login_btn" id="login_ret"><i class="fas fa-sign-in-alt"></i> 返回登录</button>
            </div>
          </form>
          <div class="login-footer">
            <p>已有账号？<a href="login.php">立即登录</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    $("#login_ret").click(function() {
      window.location = "login.php";
    });

    $("#name").on('input', function() {
      var val = $(this).val();
      if (val && val.length > 6) {
        alert('用户名称长度不能超过6位');
        $(this).val(val.substring(0, 6));
      }
    });

    $("#uid").on('input', function() {
      var val = $(this).val();
      if (val && !/^[a-zA-Z0-9_]{3,12}$/.test(val)) {
        $(this).addClass('input-error');
      } else {
        $(this).removeClass('input-error');
      }
    });

    $("#pwd, #pwd2").on('input', function() {
      var val = $(this).val();
      if (val && (val.length < 6 || val.length > 12)) {
        $(this).addClass('input-error');
      } else {
        $(this).removeClass('input-error');
      }
    });

    $("#phone").on('input', function() {
      var val = $(this).val();
      if (val && !/^1[3-9]\d{9}$/.test(val)) {
        $(this).addClass('input-error');
      } else {
        $(this).removeClass('input-error');
      }
    });

    $("#submitForm").submit(function(e) {
      var name = $("#name").val().trim();
      var uid = $("#uid").val().trim();
      var pwd = $("#pwd").val();
      var pwd2 = $("#pwd2").val();
      var phone = $("#phone").val().trim();

      if (!name) {
        e.preventDefault();
        alert('请输入用户名称');
        return false;
      }

      if (name.length > 6) {
        e.preventDefault();
        alert('用户名称长度不能超过6位');
        return false;
      }

      if (!uid) {
        e.preventDefault();
        alert('请输入登录账号');
        return false;
      }

      if (!/^[a-zA-Z0-9_]{3,12}$/.test(uid)) {
        e.preventDefault();
        alert('账号格式不正确（3-12位字母数字下划线）');
        return false;
      }

      if (!pwd) {
        e.preventDefault();
        alert('请输入密码');
        return false;
      }

      if (pwd.length < 6 || pwd.length > 12) {
        e.preventDefault();
        alert('密码长度应为6-12位');
        return false;
      }

      if (pwd !== pwd2) {
        e.preventDefault();
        alert('两次密码不一致');
        return false;
      }

      if (!phone) {
        e.preventDefault();
        alert('请输入手机号码');
        return false;
      }

      if (!/^1[3-9]\d{9}$/.test(phone)) {
        e.preventDefault();
        alert('手机号码格式不正确');
        return false;
      }

      $("#login_sub").prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> 注册中...');
      return true;
    });
  });
  </script>
</body>
</html>