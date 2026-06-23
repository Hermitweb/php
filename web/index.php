<?php
    require_once('int.php');
    //读取文章列表
    $featuredList = getList('wen', $where=' pinglun= 1 ', $limit=3, $offset=0);
    $latestList = getList('wen', $where=' 1 ', $limit=9, $offset=0);
    $popularList = getList('wen', $where=' 1 ', $limit=5, $offset=0);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <base href="/web/">
    <title>News Platform - 现代化新闻资讯平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="News Platform - 您的新闻资讯首选平台">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/home-modern.css">
</head>
<body>
    <!-- 顶部公告栏 -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <span><i class="fas fa-bullhorn"></i> 欢迎访问 News Platform，您的新闻资讯首选平台</span>
                <div class="top-bar-links">
                    <a href="#"><i class="fas fa-envelope"></i> 订阅</a>
                    <a href="#"><i class="fas fa-user"></i> 登录</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 导航栏 -->
    <header>
        <div class="main-menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="index.php">
                        <i class="fas fa-newspaper"></i>
                        <span>News Platform</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a href="index.php" class="nav-link"><i class="fas fa-home"></i> 首页</a>
                            </li>
                            <li class="nav-item">
                                <a href="list.php" class="nav-link"><i class="fas fa-list"></i> 资讯列表</a>
                            </li>
                            <li class="nav-item">
                                <a href="category.php" class="nav-link"><i class="fas fa-th-large"></i> 分类</a>
                            </li>
                            <li class="nav-item">
                                <a href="contact.php" class="nav-link"><i class="fas fa-phone"></i> 联系我们</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0 search-form">
                            <input class="form-control" type="search" placeholder="搜索新闻..." aria-label="Search">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- 英雄区域 -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>洞察时事，<span>掌握未来</span></h1>
                <p>专业的新闻资讯平台，为您提供最新、最快、最全面的新闻报道</p>
                <div class="hero-buttons">
                    <a href="list.php" class="btn-primary">浏览资讯 <i class="fas fa-arrow-right"></i></a>
                    <a href="contact.php" class="btn-secondary">联系我们</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 特色文章 -->
    <?php if (!empty($featuredList)): ?>
    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-fire"></i> 头条推荐</h2>
                <a href="list.php" class="view-all">查看全部 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="row">
                <?php foreach ($featuredList as $key => $value): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="featured-card">
                        <div class="card-image" style="background: linear-gradient(135deg, <?php echo ['#667eea, #764ba2', '#f093fb, #f5576c', '#4facfe, #00f2fe'][$key % 3]; ?>);">
                            <i class="fas fa-newspaper"></i>
                            <span class="card-badge"><?php echo htmlspecialchars($value['leibie']); ?></span>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="post.php?id=<?php echo $value['id']; ?>">
                                    <?php echo htmlspecialchars($value['title']); ?>
                                </a>
                            </h3>
                            <p class="card-excerpt"><?php echo htmlspecialchars(mb_substr($value['jianjie'], 0, 80, 'utf-8')); ?>...</p>
                            <div class="card-meta">
                                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($value['user']); ?></span>
                                <span><i class="fas fa-calendar"></i> <?php echo $value['regtime']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 最新资讯 -->
    <section class="latest-section">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-clock"></i> 最新资讯</h2>
                <a href="list.php" class="view-all">查看全部 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="row">
                <?php foreach ($latestList as $key => $value): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="article-card">
                        <div class="article-thumb">
                            <?php if (!empty($value['image'])): ?>
                                <img src="<?php echo htmlspecialchars($value['image']); ?>" alt="">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                            <span class="article-category"><?php echo htmlspecialchars($value['leibie']); ?></span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">
                                <a href="post.php?id=<?php echo $value['id']; ?>">
                                    <?php echo htmlspecialchars($value['title']); ?>
                                </a>
                            </h3>
                            <p class="article-excerpt">
                                <?php echo htmlspecialchars(mb_substr($value['jianjie'] ?? '暂无简介', 0, 60, 'utf-8')); ?>...
                            </p>
                            <div class="article-footer">
                                <span class="article-author">
                                    <i class="fas fa-user-circle"></i>
                                    <?php echo htmlspecialchars($value['user']); ?>
                                </span>
                                <span class="article-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo $value['regtime']; ?>
                                </span>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 热门文章 -->
    <?php if (!empty($popularList)): ?>
    <section class="popular-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-header">
                        <h2><i class="fas fa-fire"></i> 热门文章</h2>
                    </div>
                    <div class="popular-list">
                        <?php foreach ($popularList as $index => $value): ?>
                        <div class="popular-item">
                            <div class="popular-rank"><?php echo $index + 1; ?></div>
                            <div class="popular-content">
                                <h3>
                                    <a href="post.php?id=<?php echo $value['id']; ?>">
                                        <?php echo htmlspecialchars($value['title']); ?>
                                    </a>
                                </h3>
                                <div class="popular-meta">
                                    <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($value['leibie']); ?></span>
                                    <span><i class="fas fa-eye"></i> <?php echo rand(100, 9999); ?> 阅读</span>
                                    <span><i class="fas fa-calendar"></i> <?php echo $value['regtime']; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-card">
                        <h3><i class="fas fa-info-circle"></i> 关于我们</h3>
                        <p>News Platform 是一个专注于提供高质量新闻资讯的现代化平台，致力于为用户带来及时、准确、有深度的新闻报道。</p>
                        <div class="sidebar-stats">
                            <div class="stat">
                                <div class="stat-num">1000+</div>
                                <div class="stat-label">文章数量</div>
                            </div>
                            <div class="stat">
                                <div class="stat-num">50+</div>
                                <div class="stat-label">作者</div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <h3><i class="fas fa-tags"></i> 分类导航</h3>
                        <div class="tag-cloud">
                            <a href="category.php" class="tag-item">科技</a>
                            <a href="category.php" class="tag-item">财经</a>
                            <a href="category.php" class="tag-item">体育</a>
                            <a href="category.php" class="tag-item">娱乐</a>
                            <a href="category.php" class="tag-item">政治</a>
                            <a href="category.php" class="tag-item">文化</a>
                            <a href="category.php" class="tag-item">教育</a>
                            <a href="category.php" class="tag-item">健康</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 订阅区域 -->
    <section class="subscribe-section">
        <div class="container">
            <div class="subscribe-content">
                <h2>订阅我们的周报</h2>
                <p>第一时间获取最新新闻资讯，不再错过任何重要动态</p>
                <form class="subscribe-form">
                    <input type="email" placeholder="输入您的邮箱地址" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i> 立即订阅</button>
                </form>
            </div>
        </div>
    </section>

    <!-- 页脚 -->
    <footer class="modern-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3><i class="fas fa-newspaper"></i> News Platform</h3>
                        <p>专业的新闻资讯平台，为您提供最新、最快、最全面的新闻报道。我们的使命是让每个人都能方便地获取真实、有价值的新闻信息。</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-weixin"></i></a>
                            <a href="#"><i class="fab fa-weibo"></i></a>
                            <a href="#"><i class="fab fa-qq"></i></a>
                            <a href="#"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3>快速链接</h3>
                        <ul>
                            <li><a href="index.php"><i class="fas fa-chevron-right"></i> 首页</a></li>
                            <li><a href="list.php"><i class="fas fa-chevron-right"></i> 资讯列表</a></li>
                            <li><a href="category.php"><i class="fas fa-chevron-right"></i> 分类</a></li>
                            <li><a href="contact.php"><i class="fas fa-chevron-right"></i> 联系我们</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3>分类</h3>
                        <ul>
                            <li><a href="category.php"><i class="fas fa-chevron-right"></i> 科技资讯</a></li>
                            <li><a href="category.php"><i class="fas fa-chevron-right"></i> 财经新闻</a></li>
                            <li><a href="category.php"><i class="fas fa-chevron-right"></i> 体育报道</a></li>
                            <li><a href="category.php"><i class="fas fa-chevron-right"></i> 娱乐八卦</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3>联系方式</h3>
                        <ul class="contact-info">
                            <li><i class="fas fa-map-marker-alt"></i> 中国 北京市</li>
                            <li><i class="fas fa-phone"></i> +86 188-XXXX-XXXX</li>
                            <li><i class="fas fa-envelope"></i> contact@news-platform.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; <?php echo date('Y'); ?> News Platform. 保留所有权利.</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p>Powered by PHP <?php echo PHP_VERSION; ?> | v<?php echo APP_VERSION; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
    <script>
    // 返回顶部
    window.addEventListener('scroll', function() {
        const btn = document.getElementById('backToTop');
        if (window.scrollY > 300) {
            btn.classList.add('show');
        } else {
            btn.classList.remove('show');
        }
    });
    document.getElementById('backToTop').addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    </script>
</body>
</html>
