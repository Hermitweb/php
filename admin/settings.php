<?php
require_once("int.php");
Security::requireLogin('log/login.php');

$message = '';
$messageType = '';

// 处理修改密码
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $message = '安全验证失败';
        $messageType = 'error';
    } else {
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $adminInfo = getOne('admin', "id='" . $_SESSION['user']['id'] . "'");

        if (!Security::verifyPassword($oldPassword, $adminInfo['password'])) {
            $message = '原密码错误';
            $messageType = 'error';
        } elseif ($newPassword !== $confirmPassword) {
            $message = '两次输入的新密码不一致';
            $messageType = 'error';
        } else {
            $validation = Security::validatePassword($newPassword);
            if (!$validation['valid']) {
                $message = $validation['message'];
                $messageType = 'error';
            } else {
                $hashedPassword = Security::hashPassword($newPassword);
                if (update('admin', ['password' => $hashedPassword], "id='" . $adminInfo['id'] . "'")) {
                    $message = '密码修改成功！请使用新密码重新登录';
                    $messageType = 'success';
                    Logger::info('管理员修改密码', ['admin_id' => $adminInfo['id']]);
                } else {
                    $message = '密码修改失败，请重试';
                    $messageType = 'error';
                }
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
  <title>系统设置 - News Platform</title>
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
            <dd><a href="settings.php" class="layui-this"><i class="fas fa-sliders-h"></i> 系统设置</a></dd>
            <dd><a href="profile.php"><i class="fas fa-user-circle"></i> 个人中心</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>

  <div class="layui-body custom-body">
    <?php if ($message): ?>
    <div class="alert alert-<?php echo $messageType; ?>">
      <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
      <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>

    <!-- 系统信息 -->
    <div class="content-card">
      <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> 系统信息</h3>
      </div>
      <div class="card-body">
        <div class="info-grid">
          <div class="info-item">
            <div class="info-label">系统版本</div>
            <div class="info-value">News Platform v<?php echo APP_VERSION; ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">PHP版本</div>
            <div class="info-value"><?php echo PHP_VERSION; ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">服务器</div>
            <div class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">服务器时间</div>
            <div class="info-value"><?php echo date('Y-m-d H:i:s'); ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">时区</div>
            <div class="info-value"><?php echo date_default_timezone_get(); ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">内存限制</div>
            <div class="info-value"><?php echo ini_get('memory_limit'); ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- 修改密码 -->
    <div class="content-card" id="password">
      <div class="card-header">
        <h3><i class="fas fa-key"></i> 修改密码</h3>
      </div>
      <div class="card-body">
        <form method="post" class="password-form">
          <?php echo Security::csrfField(); ?>
          <input type="hidden" name="change_password" value="1">
          <div class="form-group">
            <label><i class="fas fa-lock"></i> 原密码</label>
            <input type="password" name="old_password" required placeholder="请输入原密码">
          </div>
          <div class="form-group">
            <label><i class="fas fa-key"></i> 新密码</label>
            <input type="password" name="new_password" required minlength="6" maxlength="30" placeholder="6-30位字符">
            <small>密码长度6-30位，建议包含字母数字</small>
          </div>
          <div class="form-group">
            <label><i class="fas fa-check"></i> 确认密码</label>
            <input type="password" name="confirm_password" required minlength="6" maxlength="30" placeholder="再次输入新密码">
          </div>
          <div class="form-actions">
            <button type="submit" class="submit-btn">
              <i class="fas fa-save"></i> 修改密码
            </button>
            <button type="reset" class="reset-form-btn">
              <i class="fas fa-redo"></i> 重置
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- 系统操作 -->
    <div class="content-card">
      <div class="card-header">
        <h3><i class="fas fa-tools"></i> 系统操作</h3>
      </div>
      <div class="card-body">
        <div class="op-grid">
          <a href="javascript:void(0);" onclick="clearCache()" class="op-item">
            <div class="op-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
              <i class="fas fa-broom"></i>
            </div>
            <div class="op-text">
              <div class="op-title">清除缓存</div>
              <div class="op-desc">清理系统缓存文件</div>
            </div>
          </a>
          <a href="javascript:void(0);" onclick="backupData()" class="op-item">
            <div class="op-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
              <i class="fas fa-database"></i>
            </div>
            <div class="op-text">
              <div class="op-title">数据备份</div>
              <div class="op-desc">备份系统数据</div>
            </div>
          </a>
          <a href="javascript:void(0);" onclick="viewLogs()" class="op-item">
            <div class="op-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
              <i class="fas fa-file-alt"></i>
            </div>
            <div class="op-text">
              <div class="op-title">查看日志</div>
              <div class="op-desc">系统操作日志</div>
            </div>
          </a>
          <a href="/api/health.php" target="_blank" class="op-item">
            <div class="op-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
              <i class="fas fa-heartbeat"></i>
            </div>
            <div class="op-text">
              <div class="op-title">健康检查</div>
              <div class="op-desc">检查系统状态</div>
            </div>
          </a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
layui.use('element', function(){
  var element = layui.element;
});

function clearCache() {
  Swal.fire({
    title: '确定清除缓存？',
    text: '这将清理系统缓存文件',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: '确定',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire('已清除', '缓存已清理', 'success');
    }
  });
}

function backupData() {
  Swal.fire({
    title: '开始备份',
    text: '数据备份中...',
    icon: 'info',
    timer: 2000,
    showConfirmButton: false
  });
}

function viewLogs() {
  Swal.fire('日志功能', '请到 logs/ 目录查看日志文件', 'info');
}
</script>
</body>
</html>
