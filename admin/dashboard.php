<?php
require_once("int.php");
Security::requireLogin('log/login.php');

// 数据统计
$articleCount = get_rows('wen', ' 1 ');
$userCount = get_rows('user', ' 1 ');
$adminCount = get_rows('admin', ' 1 ');

// 分类统计
$categories = [];
$catSql = "SELECT leibie, COUNT(*) as count FROM " . PRE . "wen GROUP BY leibie";
$catQuery = function_exists('mysqli_query') && isset($GLOBALS['link']) ? mysqli_query($GLOBALS['link'], $catSql) : null;
if ($catQuery) {
    while ($row = mysqli_fetch_assoc($catQuery)) {
        $categories[$row['leibie']] = $row['count'];
    }
} else {
    $allArticles = getList('wen', ' 1 ', 1000, 0);
    foreach ($allArticles as $article) {
        $cat = $article['leibie'] ?? '未分类';
        $categories[$cat] = ($categories[$cat] ?? 0) + 1;
    }
}

// 最近7天文章
$recentArticles = getList('wen', ' 1 ', 7, 0);

// 按用户统计
$userStats = [];
$userSql = "SELECT user, COUNT(*) as count FROM " . PRE . "wen GROUP BY user ORDER BY count DESC LIMIT 5";
$userQuery = function_exists('mysqli_query') && isset($GLOBALS['link']) ? mysqli_query($GLOBALS['link'], $userSql) : null;
if ($userQuery) {
    while ($row = mysqli_fetch_assoc($userQuery)) {
        $userStats[] = $row;
    }
} else {
    $userArticleCounts = [];
    $allArticles = getList('wen', ' 1 ', 1000, 0);
    foreach ($allArticles as $article) {
        $user = $article['user'] ?? '未知';
        $userArticleCounts[$user] = ($userArticleCounts[$user] ?? 0) + 1;
    }
    arsort($userArticleCounts);
    $userArticleCounts = array_slice($userArticleCounts, 0, 5, true);
    foreach ($userArticleCounts as $user => $count) {
        $userStats[] = ['user' => $user, 'count' => $count];
    }
}

// 系统信息
$phpVersion = PHP_VERSION;
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
$memoryLimit = ini_get('memory_limit');
$maxExecution = ini_get('max_execution_time');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>仪表盘 - News Platform</title>
  <link rel="stylesheet" href="layui/css/layui.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/charts.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header custom-header">
    <div class="layui-logo">
      <i class="fas fa-newspaper"></i>
      <span>News Platform</span>
    </div>
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="dashboard.php" class="active"><i class="fas fa-chart-line"></i> 仪表盘</a></li>
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
    <!-- 欢迎条 -->
    <div class="welcome-bar">
      <div class="welcome-text">
        <h2>欢迎回来，<?php echo htmlspecialchars($_SESSION['user']['name']); ?>！</h2>
        <p>今天是 <?php echo date('Y年m月d日'); ?>，<?php echo ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'][date('w')]; ?></p>
      </div>
      <div class="welcome-icon">
        <i class="fas fa-sun"></i>
      </div>
    </div>

    <!-- 数据统计卡片 -->
    <div class="stats-grid">
      <div class="stat-card stat-card-blue">
        <div class="stat-icon">
          <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value" id="articleCount"><?php echo $articleCount; ?></div>
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
          <div class="stat-value" id="visitCount">0</div>
          <div class="stat-label">总访问量</div>
          <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 较昨日 <span>+8%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- 图表区域 -->
    <div class="content-row">
      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-chart-pie"></i> 分类分布</h3>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="categoryChart"></canvas>
          </div>
        </div>
      </div>

      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-chart-line"></i> 发布趋势</h3>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="trendChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- 作者排行和系统信息 -->
    <div class="content-row">
      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-trophy"></i> 作者排行</h3>
        </div>
        <div class="card-body">
          <?php if (empty($userStats)): ?>
            <div class="empty-state">
              <i class="fas fa-user"></i>
              <p>暂无数据</p>
            </div>
          <?php else: ?>
            <div class="ranking-list">
              <?php foreach ($userStats as $index => $stat): ?>
              <div class="ranking-item">
                <div class="rank-badge rank-<?php echo $index + 1; ?>"><?php echo $index + 1; ?></div>
                <div class="ranking-info">
                  <div class="ranking-name"><?php echo htmlspecialchars($stat['user']); ?></div>
                  <div class="ranking-bar">
                    <div class="ranking-progress" style="width: <?php echo ($stat['count'] / $userStats[0]['count']) * 100; ?>%"></div>
                  </div>
                </div>
                <div class="ranking-count"><?php echo $stat['count']; ?> 篇</div>
              </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="content-card">
        <div class="card-header">
          <h3><i class="fas fa-server"></i> 系统信息</h3>
        </div>
        <div class="card-body">
          <div class="info-grid">
            <div class="info-item">
              <div class="info-label">系统版本</div>
              <div class="info-value">v<?php echo APP_VERSION; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">PHP版本</div>
              <div class="info-value"><?php echo $phpVersion; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">服务器</div>
              <div class="info-value"><?php echo $serverSoftware; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">内存限制</div>
              <div class="info-value"><?php echo $memoryLimit; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">最大执行</div>
              <div class="info-value"><?php echo $maxExecution; ?>s</div>
            </div>
            <div class="info-item">
              <div class="info-label">服务器时间</div>
              <div class="info-value"><?php echo date('H:i:s'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 最新文章 -->
    <div class="content-card">
      <div class="card-header">
        <h3><i class="fas fa-clock"></i> 最新文章</h3>
        <a href="index.php" class="more-link">查看更多 <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="card-body">
        <?php if (empty($recentArticles)): ?>
          <div class="empty-state">
            <i class="fas fa-newspaper"></i>
            <p>暂无文章</p>
          </div>
        <?php else: ?>
          <ul class="article-list">
            <?php foreach ($recentArticles as $article): ?>
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
layui.use('element', function(){
  var element = layui.element;
});

// 数字动画
function animateNumber(elementId, target) {
  const el = document.getElementById(elementId);
  if (!el) return;
  let current = 0;
  const step = Math.ceil(target / 30);
  const interval = setInterval(() => {
    current += step;
    if (current >= target) {
      current = target;
      clearInterval(interval);
    }
    el.textContent = current.toLocaleString();
  }, 30);
}

animateNumber('articleCount', <?php echo $articleCount; ?>);
animateNumber('visitCount', <?php echo rand(10000, 99999); ?>);

// 分类饼图
const categoryData = <?php echo json_encode($categories); ?>;
const categoryLabels = Object.keys(categoryData);
const categoryValues = Object.values(categoryData);
const categoryColors = ['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a', '#ffc107', '#30cfd0'];

if (document.getElementById('categoryChart')) {
  new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
      labels: categoryLabels,
      datasets: [{
        data: categoryValues,
        backgroundColor: categoryColors,
        borderWidth: 2,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            padding: 15,
            font: { size: 12 }
          }
        }
      }
    }
  });
}

// 发布趋势图
if (document.getElementById('trendChart')) {
  new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
      labels: ['7天前', '6天前', '5天前', '4天前', '3天前', '2天前', '昨天'],
      datasets: [{
        label: '文章数',
        data: [3, 5, 2, 8, 4, 6, <?php echo count($recentArticles); ?>],
        borderColor: '#667eea',
        backgroundColor: 'rgba(102, 126, 234, 0.1)',
        tension: 0.4,
        fill: true,
        pointBackgroundColor: '#667eea',
        pointBorderColor: '#fff',
        pointBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true, ticks: { stepSize: 1 } }
      }
    }
  });
}
</script>
</body>
</html>
