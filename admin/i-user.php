<?php
require_once("int.php");
Security::requireLogin('log/login.php');

$count = get_rows('user', ' 1 ');
$page_size = 10;
$page = empty($_GET['page']) ? 1 : $_GET['page'];
$page = !is_numeric($page) ? 1 : $page;
$pages = ceil($count / $page_size);
$offset = ($page - 1) * $page_size;
$list = getList('user', ' 1 ', $page_size, $offset);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>用户管理 - News Platform</title>
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
        <li class="layui-nav-item layui-nav-itemed">
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
            <dd><a href="i-user.php" class="layui-this"><i class="fas fa-user"></i> 用户列表</a></dd>
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
    <div class="content-card">
      <div class="card-header">
        <h3><i class="fas fa-users"></i> 用户列表</h3>
        <span class="tag tag-success">共 <?php echo $count; ?> 位用户</span>
      </div>
      <div class="card-body">
        <div class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th width="60">序号</th>
                <th>用户名</th>
                <th width="150">电话</th>
                <th width="200">邮箱</th>
                <th width="150">注册时间</th>
                <th width="100">状态</th>
                <th width="120">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($list)): ?>
                <tr>
                  <td colspan="7" class="empty-row">
                    <div class="empty-state">
                      <i class="fas fa-users"></i>
                      <p>暂无用户</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($list as $value): ?>
                <tr>
                  <td><?php echo $value['id'] ?></td>
                  <td>
                    <div class="user-cell">
                      <div class="user-avatar"><?php echo mb_substr($value['uid'], 0, 1); ?></div>
                      <span><?php echo htmlspecialchars($value['uid']); ?></span>
                    </div>
                  </td>
                  <td><?php echo htmlspecialchars($value['phone']); ?></td>
                  <td><?php echo htmlspecialchars($value['email']); ?></td>
                  <td><?php echo $value['regtime']; ?></td>
                  <td>
                    <span class="tag <?php echo $value['stutas'] == 1 ? 'tag-success' : 'tag-warning'; ?>">
                      <?php echo $value['stutas'] == 1 ? '正常' : '禁用'; ?>
                    </span>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <a href="user_x.php?id=<?php echo $value['id']; ?>" class="btn-icon btn-edit" title="查看详情">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="javascript:void(0)" onclick="toggleUserStatus(<?php echo $value['id']; ?>, <?php echo $value['stutas']; ?>)" class="btn-icon btn-secondary" title="<?php echo $value['stutas'] == 1 ? '禁用' : '启用'; ?>">
                        <i class="fas fa-<?php echo $value['stutas'] == 1 ? 'ban' : 'check'; ?>"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="pagination-wrapper">
          <div class="pagination-info">
            共 <strong><?php echo $count; ?></strong> 条记录，当前第 <strong><?php echo $page; ?></strong> / <strong><?php echo max(1, $pages); ?></strong> 页
          </div>
          <div class="pagination">
            <a href="i-user.php?page=1" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-double-left"></i>
            </a>
            <a href="i-user.php?page=<?php echo max(1, $page-1); ?>" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-left"></i>
            </a>
            <span class="page-current"><?php echo $page; ?></span>
            <a href="i-user.php?page=<?php echo min($pages, $page+1); ?>" class="page-link <?php echo $page >= $pages ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-right"></i>
            </a>
            <a href="i-user.php?page=<?php echo $pages; ?>" class="page-link <?php echo $page >= $pages ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-double-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
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
<script>
function toggleUserStatus(id, status) {
  var action = status == 1 ? '禁用' : '启用';
  if (confirm('确定要' + action + '该用户吗？')) {
    window.location.href = 'ajax.php?action=toggleUserStatus&id=' + id;
  }
}
</script>
</body>
</html>
