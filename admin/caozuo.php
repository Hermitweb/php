<?php
  include_once("int.php");
  Security::requireLogin('log/login.php');
  
  $count = get_rows('wen', $where=" 1 ");
  $page_size = 10;

  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  $page = !is_numeric($page) ? 1 : $page;

  $pages = ceil($count / $page_size);
  $offset = ($page - 1) * $page_size;

  $list = getList('wen', $where=' 1 ', $limit=$page_size, $offset);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>操作文章 - News Platform</title>
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
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;"><i class="fas fa-edit"></i> 文章管理</a>
          <dl class="layui-nav-child">
            <dd><a href="caozuo.php" class="layui-this"><i class="fas fa-cog"></i> 操作文章</a></dd>
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
        <h3><i class="fas fa-edit"></i> 文章管理</h3>
        <a href="fabu.php" class="btn-primary">
          <i class="fas fa-plus"></i> 发布文章
        </a>
      </div>
      <div class="card-body">
        <div class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th width="60">序号</th>
                <th>作者</th>
                <th>文章标题</th>
                <th width="120">文章类别</th>
                <th width="150">发布时间</th>
                <th width="200">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($list)): ?>
                <tr>
                  <td colspan="6" class="empty-row">
                    <div class="empty-state">
                      <i class="fas fa-newspaper"></i>
                      <p>暂无文章</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($list as $key => $value): ?>
                <tr>
                  <td><?php echo $value['id'] ?></td>
                  <td>
                    <div class="user-cell">
                      <div class="user-avatar-sm"><?php echo mb_substr($value['user'], 0, 1); ?></div>
                      <span><?php echo htmlspecialchars($value['user']); ?></span>
                    </div>
                  </td>
                  <td><strong class="text-truncate" style="max-width: 300px;"><?php echo htmlspecialchars($value['title']); ?></strong></td>
                  <td><span class="tag"><?php echo htmlspecialchars($value['leibie']); ?></span></td>
                  <td><?php echo $value['regtime']; ?></td>
                  <td>
                    <div class="action-buttons" style="display: flex; gap: 6px;">
                      <a href="xiugai.php?id=<?php echo $value['id']; ?>" class="btn-icon btn-primary" title="编辑">
                        <i class="fas fa-edit"></i>
                      </a>
                      <button class="btn-icon btn-secondary pinglun" data-id="<?php echo $value['id']; ?>" data-status="<?php echo $value['pinglun']; ?>" title="<?php echo $value['pinglun'] == 1 ? '禁止评论' : '允许评论'; ?>">
                        <i class="fas fa-<?php echo $value['pinglun'] == 1 ? 'message-circle' : 'ban'; ?>"></i>
                      </button>
                      <button class="btn-icon btn-secondary remen" data-id="<?php echo $value['id']; ?>" data-status="<?php echo $value['remen']; ?>" title="<?php echo $value['remen'] == 1 ? '取消热门' : '设为热门'; ?>">
                        <i class="fas fa-<?php echo $value['remen'] == 1 ? 'star' : 'star-o'; ?>"></i>
                      </button>
                      <button class="btn-icon btn-danger del" data-id="<?php echo $value['id']; ?>" title="删除">
                        <i class="fas fa-trash"></i>
                      </button>
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
            <a href="caozuo.php?page=1" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-double-left"></i>
            </a>
            <a href="caozuo.php?page=<?php echo max(1, $page - 1); ?>" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-left"></i>
            </a>
            <span class="page-current"><?php echo $page; ?></span>
            <a href="caozuo.php?page=<?php echo min($pages, $page + 1); ?>" class="page-link <?php echo $page >= $pages ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-right"></i>
            </a>
            <a href="caozuo.php?page=<?php echo $pages; ?>" class="page-link <?php echo $page >= $pages ? 'disabled' : ''; ?>">
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
<script src="js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
layui.use('element', function(){
  var element = layui.element;
});

$(".pinglun").click(function(){
    var id = $(this).data('id');
    var status = $(this).data('status');
    var obj = $(this);
    var action = status == 1 ? '禁止评论' : '允许评论';
    
    Swal.fire({
      title: '确认操作',
      text: '确定要' + action + '这篇文章吗？',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '确定',
      cancelButtonText: '取消'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: 'ajax.php',
          data: { id: id, type: 'pinglun' },
          dataType: 'json',
          success: function(msg) {
            if (msg.code == 100) {
              var newStatus = status == 1 ? 0 : 1;
              obj.data('status', newStatus);
              obj.find('i').removeClass().addClass('fas fa-' + (newStatus == 1 ? 'message-circle' : 'ban'));
              Swal.fire('操作成功', action + '成功', 'success');
            }
          }
        });
      }
    });
});

$(".remen").click(function(){
    var id = $(this).data('id');
    var status = $(this).data('status');
    var obj = $(this);
    var action = status == 1 ? '取消热门' : '设为热门';
    
    Swal.fire({
      title: '确认操作',
      text: '确定要' + action + '这篇文章吗？',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '确定',
      cancelButtonText: '取消'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: 'ajax.php',
          data: { id: id, type: 'remen' },
          dataType: 'json',
          success: function(msg) {
            if (msg.code == 100) {
              var newStatus = status == 1 ? 0 : 1;
              obj.data('status', newStatus);
              obj.find('i').removeClass().addClass('fas fa-' + (newStatus == 1 ? 'star' : 'star-o'));
              Swal.fire('操作成功', action + '成功', 'success');
            }
          }
        });
      }
    });
});

$(".del").click(function(){
    var id = $(this).data('id');
    var obj = $(this);
    
    Swal.fire({
      title: '确认删除',
      text: '该文章将被永久删除，无法恢复！',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f5576c',
      cancelButtonColor: '#6c757d',
      confirmButtonText: '确定删除',
      cancelButtonText: '取消'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: 'ajax.php',
          data: { id: id, type: 'del' },
          dataType: 'json',
          success: function(msg) {
            if (msg.code == 100) {
              obj.parents('tr').fadeOut(300, function() {
                $(this).remove();
              });
              Swal.fire('已删除', '文章已被删除', 'success');
            }
          }
        });
      }
    });
});
</script>
</body>
</html>