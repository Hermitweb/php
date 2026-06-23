<?php
  require_once("int.php");
  // 验证登录
  if (!defined('SKIP_AUTH_CHECK')) {
    Security::requireLogin('log/login.php');
  }

  // 数据统计
  $articleCount = get_rows('wen', ' 1 ');
  $userCount = get_rows('user', ' 1 ');
  $adminCount = get_rows('admin', ' 1 ');

  // 分类统计
  $categories = [];
  $catSql = "SELECT leibie, COUNT(*) as count FROM " . PRE . "wen GROUP BY leibie";
  $catQuery = mysqli_query($GLOBALS['link'], $catSql);
  if ($catQuery) {
    while ($row = mysqli_fetch_assoc($catQuery)) {
      $categories[$row['leibie']] = $row['count'];
    }
  }

  // 最新文章
  $latestArticles = getList('wen', ' 1 ', 5, 0);

  // 分页
  $page_size = 10;
  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  $page = !is_numeric($page) ? 1 : $page;
  $pages = ceil($articleCount / $page_size);
  $offset = ($page - 1) * $page_size;
  $list = getList('wen', ' 1 ', $page_size, $offset);

  // 搜索
  $search = Security::clean($_GET['search'] ?? '');
  $catFilter = Security::clean($_GET['category'] ?? '');

  if ($search || $catFilter) {
    $where = ' 1 ';
    if ($search) {
      $where .= " AND (title LIKE '%$search%' OR jianjie LIKE '%$search%')";
    }
    if ($catFilter) {
      $where .= " AND leibie = '$catFilter'";
    }
    $articleCount = get_rows('wen', $where);
    $pages = ceil($articleCount / $page_size);
    $offset = ($page - 1) * $page_size;
    $list = getList('wen', $where, $page_size, $offset);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>仪表盘 - News Platform</title>
  <link rel="stylesheet" href="layui/css/layui.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/dashboard.css">
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
            <dd><a href="dashboard.php" class="layui-this"><i class="fas fa-chart-pie"></i> 仪表盘</a></dd>
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
    <!-- 数据统计卡片 -->
    <div class="stats-grid">
      <div class="stat-card stat-card-blue">
        <div class="stat-icon">
          <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value"><?php echo $articleCount; ?></div>
          <div class="stat-label">文章总数</div>
          <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 较昨日 <span>+12%</span>
          </div>
        </div>
      </div>

      <div class="stat-card stat-card-green">
        <div class="stat-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value"><?php echo $userCount; ?></div>
          <div class="stat-label">注册用户</div>
          <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 较昨日 <span>+5%</span>
          </div>
        </div>
      </div>

      <div class="stat-card stat-card-orange">
        <div class="stat-icon">
          <i class="fas fa-user-shield"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value"><?php echo $adminCount; ?></div>
          <div class="stat-label">管理员</div>
          <div class="stat-trend">
            <i class="fas fa-check-circle"></i> 状态 <span>正常</span>
          </div>
        </div>
      </div>

      <div class="stat-card stat-card-purple">
        <div class="stat-icon">
          <i class="fas fa-eye"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value"><?php echo rand(1000, 9999); ?></div>
          <div class="stat-label">总访问量</div>
          <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 较昨日 <span>+8%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- 快捷操作 -->
    <div class="quick-actions">
      <h3 class="section-title">
        <i class="fas fa-bolt"></i> 快捷操作
      </h3>
      <div class="action-grid">
        <a href="fabu.php" class="action-item">
          <div class="action-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <i class="fas fa-plus"></i>
          </div>
          <div class="action-text">发布文章</div>
        </a>
        <a href="caozuo.php" class="action-item">
          <div class="action-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <i class="fas fa-edit"></i>
          </div>
          <div class="action-text">管理文章</div>
        </a>
        <a href="i-user.php" class="action-item">
          <div class="action-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <i class="fas fa-users"></i>
          </div>
          <div class="action-text">用户管理</div>
        </a>
        <a href="user.php" class="action-item">
          <div class="action-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <i class="fas fa-user-shield"></i>
          </div>
          <div class="action-text">管理员</div>
        </a>
        <a href="settings.php" class="action-item">
          <div class="action-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <i class="fas fa-cog"></i>
          </div>
          <div class="action-text">系统设置</div>
        </a>
        <a href="profile.php" class="action-item">
          <div class="action-icon" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
            <i class="fas fa-user"></i>
          </div>
          <div class="action-text">个人中心</div>
        </a>
      </div>
    </div>

    <!-- 内容区域 -->
    <div class="content-row">
      <!-- 分类分布 -->
      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-chart-pie"></i> 分类分布</h3>
        </div>
        <div class="card-body">
          <?php if (empty($categories)): ?>
            <div class="empty-state">
              <i class="fas fa-folder-open"></i>
              <p>暂无数据</p>
            </div>
          <?php else: ?>
            <div class="category-list">
              <?php
              $colors = ['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a', '#ffc107'];
              $i = 0;
              foreach ($categories as $cat => $count):
                $color = $colors[$i % count($colors)];
                $percent = $articleCount > 0 ? round(($count / $articleCount) * 100, 1) : 0;
              ?>
              <div class="category-item">
                <div class="category-info">
                  <span class="category-dot" style="background: <?php echo $color; ?>"></span>
                  <span class="category-name"><?php echo htmlspecialchars($cat); ?></span>
                </div>
                <div class="category-progress">
                  <div class="progress-bar" style="width: <?php echo $percent; ?>%; background: <?php echo $color; ?>"></div>
                </div>
                <div class="category-count"><?php echo $count; ?> 篇</div>
              </div>
              <?php $i++; endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- 最新文章 -->
      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-clock"></i> 最新文章</h3>
          <a href="index.php" class="more-link">查看更多 <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body">
          <?php if (empty($latestArticles)): ?>
            <div class="empty-state">
              <i class="fas fa-newspaper"></i>
              <p>暂无文章</p>
            </div>
          <?php else: ?>
            <ul class="article-list">
              <?php foreach ($latestArticles as $article): ?>
              <li class="article-item">
                <div class="article-avatar">
                  <i class="fas fa-file-alt"></i>
                </div>
                <div class="article-info">
                  <div class="article-title"><?php echo htmlspecialchars($article['title']); ?></div>
                  <div class="article-meta">
                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($article['user']); ?></span>
                    <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($article['leibie']); ?></span>
                    <span><i class="fas fa-calendar"></i> <?php echo $article['regtime']; ?></span>
                  </div>
                </div>
                <a href="caozuo.php?id=<?php echo $article['id']; ?>" class="article-action">
                  <i class="fas fa-edit"></i>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- 文章列表 -->
    <div class="content-card">
      <div class="card-header">
        <h3><i class="fas fa-list"></i> 文章列表</h3>
      </div>
      <div class="card-body">
        <!-- 搜索栏 -->
        <div class="search-bar">
          <form method="get" action="index.php" class="search-form">
            <div class="search-input">
              <i class="fas fa-search"></i>
              <input type="text" name="search" placeholder="搜索文章标题或简介..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <select name="category" class="category-select">
              <option value="">全部分类</option>
              <?php foreach (array_keys($categories) as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $catFilter === $cat ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($cat); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="search-btn">
              <i class="fas fa-search"></i> 搜索
            </button>
            <?php if ($search || $catFilter): ?>
            <a href="index.php" class="reset-btn">
              <i class="fas fa-redo"></i> 重置
            </a>
            <?php endif; ?>
          </form>
        </div>

        <!-- 文章表格 -->
        <div class="table-wrapper">
          <table class="article-table">
            <thead>
              <tr>
                <th width="60">序号</th>
                <th width="100">作者</th>
                <th>文章标题</th>
                <th width="200">文章简介</th>
                <th width="150">展示图片</th>
                <th width="100">分类</th>
                <th width="150">发布时间</th>
                <th width="150">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($list)): ?>
                <tr>
                  <td colspan="8" class="empty-row">
                    <div class="empty-state">
                      <i class="fas fa-inbox"></i>
                      <p>暂无文章</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($list as $key => $value): ?>
                <tr>
                  <td><?php echo $value['id']; ?></td>
                  <td>
                    <div class="user-cell">
                      <div class="user-avatar-sm"><?php echo mb_substr($value['user'], 0, 1); ?></div>
                      <span><?php echo htmlspecialchars($value['user']); ?></span>
                    </div>
                  </td>
                  <td><strong><?php echo htmlspecialchars($value['title']); ?></strong></td>
                  <td><span class="text-truncate"><?php echo htmlspecialchars($value['jianjie']); ?></span></td>
                  <td>
                    <?php if ($value['image']): ?>
                      <img src="<?php echo htmlspecialchars($value['image']); ?>" class="article-thumb" alt="">
                    <?php else: ?>
                      <span class="no-image">无图片</span>
                    <?php endif; ?>
                  </td>
                  <td><span class="tag"><?php echo htmlspecialchars($value['leibie']); ?></span></td>
                  <td><?php echo $value['regtime']; ?></td>
                  <td>
                    <div class="action-buttons">
                      <a href="caozuo.php?id=<?php echo $value['id']; ?>" class="btn-icon btn-edit" title="编辑">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="javascript:void(0);" onclick="deleteArticle(<?php echo $value['id']; ?>)" class="btn-icon btn-delete" title="删除">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- 分页 -->
        <div class="pagination-wrapper">
          <div class="pagination-info">
            共 <strong><?php echo $articleCount; ?></strong> 条记录，当前第 <strong><?php echo $page; ?></strong> / <strong><?php echo max(1, $pages); ?></strong> 页
          </div>
          <div class="pagination">
            <a href="index.php?page=1<?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $catFilter ? '&category=' . urlencode($catFilter) : ''; ?>" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-double-left"></i>
            </a>
            <a href="index.php?page=<?php echo max(1, $page-1); ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $catFilter ? '&category=' . urlencode($catFilter) : ''; ?>" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-left"></i>
            </a>
            <span class="page-current"><?php echo $page; ?></span>
            <a href="index.php?page=<?php echo min($pages, $page+1); ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $catFilter ? '&category=' . urlencode($catFilter) : ''; ?>" class="page-link <?php echo $page >= $pages ? 'disabled' : ''; ?>">
              <i class="fas fa-angle-right"></i>
            </a>
            <a href="index.php?page=<?php echo $pages; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $catFilter ? '&category=' . urlencode($catFilter) : ''; ?>" class="page-link <?php echo $page >= $pages ? 'disabled' : ''; ?>">
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
      <span class="footer-divider">|</span>
      <span>用户: <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Guest'); ?></span>
    </div>
  </div>
</div>

<script src="layui/layui.all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
layui.use('element', function(){
  var element = layui.element;
});

function deleteArticle(id) {
  Swal.fire({
    title: '确定删除？',
    text: '该文章将被永久删除，无法恢复！',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#f5576c',
    cancelButtonColor: '#6c757d',
    confirmButtonText: '确定删除',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire('已删除！', '文章已被删除。', 'success');
    }
  });
}
</script>
</body>
</html>
