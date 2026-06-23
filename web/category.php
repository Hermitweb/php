<?php
    include_once('int.php');
    $categories = [
        ['id' => 'zhengzhi', 'name' => '政治', 'icon' => 'fas fa-landmark'],
        ['id' => 'jingji', 'name' => '经济', 'icon' => 'fas fa-chart-line'],
        ['id' => 'falu', 'name' => '法律', 'icon' => 'fas fa-gavel'],
        ['id' => 'junshi', 'name' => '军事', 'icon' => 'fas fa-shield-alt'],
        ['id' => 'keji', 'name' => '科技', 'icon' => 'fas fa-microchip'],
        ['id' => 'wenjiao', 'name' => '文教', 'icon' => 'fas fa-book-open'],
        ['id' => 'tiyu', 'name' => '体育', 'icon' => 'fas fa-trophy'],
        ['id' => 'shehui', 'name' => '社会', 'icon' => 'fas fa-users'],
    ];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <base href="/web/">
    <title>新闻分类 - News Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="News Platform - 新闻资讯分类">
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
                            <li class="nav-item">
                                <a href="index.php" class="nav-link"><i class="fas fa-home"></i> 首页</a>
                            </li>
                            <li class="nav-item">
                                <a href="list.php" class="nav-link"><i class="fas fa-list"></i> 资讯列表</a>
                            </li>
                            <li class="nav-item active">
                                <a href="category.php" class="nav-link"><i class="fas fa-th-large"></i> 分类</a>
                            </li>
                            <li class="nav-item">
                                <a href="contact.php" class="nav-link"><i class="fas fa-phone"></i> 联系我们</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0 search-form" method="get" action="list.php">
                            <input class="form-control" type="search" name="search" placeholder="搜索新闻...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- 面包屑导航 -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb-nav">
                <a href="index.php"><i class="fas fa-home"></i> 首页</a>
                <span class="separator">/</span>
                <span>分类</span>
            </nav>
        </div>
    </div>

    <!-- 分类导航标签 -->
    <section class="category-tabs-section">
        <div class="container">
            <div class="category-tabs">
                <ul class="nav nav-tabs">
                    <?php foreach ($categories as $cat): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#<?php echo $cat['id']; ?>" data-toggle="tab">
                            <i class="<?php echo $cat['icon']; ?>"></i>
                            <?php echo $cat['name']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- 分类内容区域 -->
    <section class="category-content">
        <div class="container">
            <div class="tab-content">
                <?php foreach ($categories as $cat): ?>
                <?php $catList = getList('wen', "pinglun=1 AND leibie='{$cat['name']}'", 6, 0); ?>
                <div id="<?php echo $cat['id']; ?>" class="tab-pane fade">
                    <div class="section-header">
                        <h2><i class="<?php echo $cat['icon']; ?>"></i> <?php echo $cat['name']; ?>资讯</h2>
                        <span class="article-count">共 <?php echo count($catList); ?> 篇文章</span>
                    </div>
                    
                    <div class="row">
                        <?php foreach ($catList as $item): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <article class="article-card">
                                <div class="article-thumb">
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <span class="article-category"><?php echo htmlspecialchars($item['leibie']); ?></span>
                                </div>
                                <div class="article-content">
                                    <h3 class="article-title">
                                        <a href="post.php?id=<?php echo $item['id']; ?>">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </a>
                                    </h3>
                                    <p class="article-excerpt">
                                        <?php echo htmlspecialchars(mb_substr($item['jianjie'] ?? '暂无简介', 0, 60, 'utf-8')); ?>...
                                    </p>
                                    <div class="article-footer">
                                        <span class="article-author">
                                            <i class="fas fa-user-circle"></i>
                                            <?php echo htmlspecialchars($item['user']); ?>
                                        </span>
                                        <span class="article-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            <?php echo $item['regtime']; ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (empty($catList)): ?>
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <p>该分类暂无文章</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
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
                            <li><a href="#keji"><i class="fas fa-chevron-right"></i> 科技资讯</a></li>
                            <li><a href="#jingji"><i class="fas fa-chevron-right"></i> 财经新闻</a></li>
                            <li><a href="#tiyu"><i class="fas fa-chevron-right"></i> 体育报道</a></li>
                            <li><a href="#shehui"><i class="fas fa-chevron-right"></i> 社会热点</a></li>
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
    <script>
    $(document).ready(function(){
        $('.nav-tabs a:first').tab('show');
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr('href');
            if (target) {
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100
                }, 300);
            }
        });
    });

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