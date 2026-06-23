<?php
require_once("int.php");
Security::requireLogin('log/login.php');

$id = $_GET['id'] ?? '';
$user = null;
if (!empty($id) && is_numeric($id)) {
    $user = getOne('user', "id=$id");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>用户详情 - News Platform</title>
  <link rel="stylesheet" href="layui/css/layui.css">
  <link rel="stylesheet" href="css/index.css">
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
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;"><i class="fas fa-users"></i> 用户管理</a>
          <dl class="layui-nav-child">
            <dd><a href="i-user.php"><i class="fas fa-user"></i> 用户列表</a></dd>
            <dd><a href="user.php"><i class="fas fa-user-shield"></i> 管理员列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="fas fa-cogs"></i> 系统管理</a>
          <dl class="layui-nav-child">
            <dd><a href="settings.php"><i class="fas fa-sliders-h"></i> 系统设置</a></dd>
            <dd><a href="profile.php"><i class="fas fa-user-circle"></i> 个人中心</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body custom-body">
    <?php if ($user): ?>
    <div class="content-card">
      <div class="card-header">
        <h3><i class="fas fa-user"></i> 用户详情</h3>
        <a href="i-user.php" class="btn-secondary">
          <i class="fas fa-arrow-left"></i> 返回列表
        </a>
      </div>
      <div class="card-body">
        <div class="profile-header" style="margin-bottom: 24px;">
          <div class="profile-cover"></div>
          <div class="profile-info">
            <div class="profile-avatar">
              <i class="fas fa-user"></i>
            </div>
            <div class="profile-detail">
              <h2><?php echo htmlspecialchars($user['uid']); ?></h2>
              <p><i class="fas fa-id-badge"></i> 用户ID: <?php echo $user['id']; ?></p>
              <p><i class="fas fa-calendar"></i> 注册时间: <?php echo $user['regtime']; ?></p>
            </div>
          </div>
        </div>

        <div class="info-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
          <div class="info-item">
            <div class="info-label">用户名</div>
            <div class="info-value"><?php echo htmlspecialchars($user['uid']); ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">手机号码</div>
            <div class="info-value"><?php echo htmlspecialchars($user['phone']); ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">邮箱</div>
            <div class="info-value"><?php echo htmlspecialchars($user['email'] ?? '未填写'); ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">状态</div>
            <div class="info-value">
              <span class="tag <?php echo $user['stutas'] == 1 ? 'tag-success' : 'tag-warning'; ?>">
                <?php echo $user['stutas'] == 1 ? '正常' : '禁用'; ?>
              </span>
            </div>
          </div>
          <div class="info-item">
            <div class="info-label">注册时间</div>
            <div class="info-value"><?php echo $user['regtime']; ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">最后登录</div>
            <div class="info-value"><?php echo !empty($user['lastlogin']) ? $user['lastlogin'] : '首次登录'; ?></div>
          </div>
        </div>

        <div style="margin-top: 24px; display: flex; gap: 12px;">
          <?php if ($user['stutas'] == 1): ?>
          <button class="btn-danger" onclick="toggleUserStatus(<?php echo $user['id']; ?>, 1)">
            <i class="fas fa-ban"></i> 禁用用户
          </button>
          <?php else: ?>
          <button class="btn-primary" onclick="toggleUserStatus(<?php echo $user['id']; ?>, 0)">
            <i class="fas fa-check"></i> 启用用户
          </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="content-card">
      <div class="card-body">
        <div class="empty-state">
          <i class="fas fa-user"></i>
          <p>用户不存在</p>
        </div>
        <div style="text-align: center; margin-top: 16px;">
          <a href="i-user.php" class="btn-primary">
            <i class="fas fa-arrow-left"></i> 返回用户列表
          </a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
  
  <div class="layui-footer custom-footer">
    <div class="footer-content">
      <span>© <?php echo date('Y'); ?> News Platform v<?php echo APP_VERSION; ?></span>
      <span class="footer-divider">|</span>
      <span>Powered by PHP <?php echo PHP_VERSION; ?></span>
    </div>
  </div>
</div>
<script src="layui/layui.all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
layui.use('element', function(){
  var element = layui.element;
});

function toggleUserStatus(id, status) {
  var action = status == 1 ? '禁用' : '启用';
  
  Swal.fire({
    title: '确认操作',
    text: '确定要' + action + '该用户吗？',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: '确定',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'ajax.php?action=toggleUserStatus&id=' + id;
    }
  });
}
</script>
</body>
</html>