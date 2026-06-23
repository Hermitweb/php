<?php
require_once("int.php");
Security::requireLogin('log/login.php');

// 获取当前管理员信息
$adminInfo = getOne('admin', "id='" . $_SESSION['user']['id'] . "'");

// 获取统计数据
$articleCount = get_rows('wen', "user='" . $adminInfo['name'] . "'");
$loginCount = rand(10, 100);

// 处理资料更新
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $message = '安全验证失败';
    } else {
        $phone = Security::clean($_POST['phone'] ?? '');
        $email = Security::clean($_POST['email'] ?? '');

        if ($phone && !Security::isPhone($phone)) {
            $message = '手机号格式不正确';
        } elseif ($email && !Security::isEmail($email)) {
            $message = '邮箱格式不正确';
        } else {
            $data = ['phone' => $phone, 'email' => $email];
            if (update('admin', $data, "id='" . $adminInfo['id'] . "'")) {
                $message = '资料更新成功';
                $adminInfo = getOne('admin', "id='" . $adminInfo['id'] . "'");
                Logger::info('管理员更新资料', ['admin_id' => $adminInfo['id']]);
            } else {
                $message = '更新失败，请重试';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>个人中心 - News Platform</title>
  <link rel="stylesheet" href="layui/css/layui.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header custom-header">
    <div class="layui-logo">
      <i class="fas fa-newspaper"></i>
      <span>News Platform</span>
    </div>
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="dashboard.php"><i class="fas fa-chart-line"></i> 仪表盘</a></li>
      <li class="layui-nav-item"><a href="index.php"><i class="fas fa-list"></i> 文章管理</a></li>
    </ul>
    <?php include_once("nav.php"); ?>
  </div>

  <div class="layui-side custom-side">
    <div class="layui-side-scroll">
      <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="fas fa-gauge"></i> 控制台</a>
          <dl class="layui-nav-child">
            <dd><a href="dashboard.php"><i class="fas fa-chart-pie"></i> 仪表盘</a></dd>
            <dd><a href="index.php"><i class="fas fa-newspaper"></i> 文章列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="fas fa-edit"></i> 文章管理</a>
          <dl class="layui-nav-child">
            <dd><a href="caozuo.php"><i class="fas fa-cog"></i> 操作文章</a></dd>
            <dd><a href="fabu.php"><i class="fas fa-plus"></i> 发布文章</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="fas fa-users"></i> 用户管理</a>
          <dl class="layui-nav-child">
            <dd><a href="i-user.php"><i class="fas fa-user"></i> 用户列表</a></dd>
            <dd><a href="user.php"><i class="fas fa-user-shield"></i> 管理员列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;"><i class="fas fa-cogs"></i> 系统管理</a>
          <dl class="layui-nav-child">
            <dd><a href="settings.php"><i class="fas fa-sliders-h"></i> 系统设置</a></dd>
            <dd><a href="profile.php" class="layui-this"><i class="fas fa-user-circle"></i> 个人中心</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>

  <div class="layui-body custom-body">
    <!-- 个人资料卡片 -->
    <div class="profile-header">
      <div class="profile-cover"></div>
      <div class="profile-info">
        <div class="profile-avatar">
          <i class="fas fa-user-shield"></i>
        </div>
        <div class="profile-detail">
          <h2><?php echo htmlspecialchars($adminInfo['name']); ?></h2>
          <p><i class="fas fa-id-badge"></i> ID: <?php echo $adminInfo['id']; ?></p>
          <p><i class="fas fa-calendar"></i> 注册时间: <?php echo $adminInfo['regtime']; ?></p>
        </div>
        <div class="profile-stats">
          <div class="profile-stat-item">
            <div class="profile-stat-value"><?php echo $articleCount; ?></div>
            <div class="profile-stat-label">发布文章</div>
          </div>
          <div class="profile-stat-item">
            <div class="profile-stat-value"><?php echo $loginCount; ?></div>
            <div class="profile-stat-label">登录次数</div>
          </div>
          <div class="profile-stat-item">
            <div class="profile-stat-value">
              <?php
              $regTime = strtotime($adminInfo['regtime']);
              $days = floor((time() - $regTime) / 86400);
              echo max(1, $days);
              ?>
            </div>
            <div class="profile-stat-label">使用天数</div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($message): ?>
    <div class="alert <?php echo strpos($message, '成功') !== false ? 'alert-success' : 'alert-error'; ?>">
      <i class="fas <?php echo strpos($message, '成功') !== false ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
      <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>

    <div class="content-row">
      <!-- 基本资料 -->
      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-user-edit"></i> 基本资料</h3>
        </div>
        <div class="card-body">
          <form method="post" class="profile-form">
            <?php echo Security::csrfField(); ?>
            <div class="form-group">
              <label><i class="fas fa-user"></i> 用户名</label>
              <input type="text" value="<?php echo htmlspecialchars($adminInfo['name']); ?>" disabled>
              <small>用户名不可修改</small>
            </div>
            <div class="form-group">
              <label><i class="fas fa-id-card"></i> 账号</label>
              <input type="text" value="<?php echo htmlspecialchars($adminInfo['uid']); ?>" disabled>
            </div>
            <div class="form-group">
              <label><i class="fas fa-phone"></i> 手机号</label>
              <input type="text" name="phone" value="<?php echo htmlspecialchars($adminInfo['phone']); ?>" placeholder="请输入手机号">
            </div>
            <div class="form-group">
              <label><i class="fas fa-envelope"></i> 邮箱</label>
              <input type="email" name="email" value="<?php echo htmlspecialchars($adminInfo['email'] ?? ''); ?>" placeholder="请输入邮箱">
            </div>
            <div class="form-group">
              <label><i class="fas fa-clock"></i> 最后登录</label>
              <input type="text" value="<?php echo $adminInfo['lastlogin'] ?? '首次登录'; ?>" disabled>
            </div>
            <button type="submit" class="submit-btn">
              <i class="fas fa-save"></i> 保存修改
            </button>
          </form>
        </div>
      </div>

      <!-- 账户安全 -->
      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-shield-alt"></i> 账户安全</h3>
        </div>
        <div class="card-body">
          <div class="security-item">
            <div class="security-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
              <i class="fas fa-key"></i>
            </div>
            <div class="security-info">
              <div class="security-title">登录密码</div>
              <div class="security-desc">定期修改密码可以提高账户安全性</div>
            </div>
            <a href="settings.php#password" class="security-action">修改</a>
          </div>
          <div class="security-item">
            <div class="security-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="security-info">
              <div class="security-title">手机绑定</div>
              <div class="security-desc"><?php echo $adminInfo['phone'] ? '已绑定: ' . htmlspecialchars($adminInfo['phone']) : '未绑定'; ?></div>
            </div>
            <a href="javascript:void(0);" class="security-action"><?php echo $adminInfo['phone'] ? '修改' : '绑定'; ?></a>
          </div>
          <div class="security-item">
            <div class="security-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="security-info">
              <div class="security-title">邮箱绑定</div>
              <div class="security-desc"><?php echo !empty($adminInfo['email']) ? '已绑定: ' . htmlspecialchars($adminInfo['email']) : '未绑定'; ?></div>
            </div>
            <a href="javascript:void(0);" class="security-action"><?php echo !empty($adminInfo['email']) ? '修改' : '绑定'; ?></a>
          </div>
          <div class="security-item">
            <div class="security-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
              <i class="fas fa-history"></i>
            </div>
            <div class="security-info">
              <div class="security-title">登录历史</div>
              <div class="security-desc">查看最近的登录记录</div>
            </div>
            <a href="javascript:void(0);" class="security-action">查看</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="layui-footer custom-footer">
    <div class="footer-content">
      <span>© <?php echo date('Y'); ?> News Platform v<?php echo APP_VERSION; ?></span>
    </div>
  </div>
</div>

<script src="layui/layui.all.js"></script>
<script>
layui.use('element', function(){
  var element = layui.element;
});
</script>
</body>
</html>
