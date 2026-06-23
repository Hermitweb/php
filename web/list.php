<?php
    include_once('int.php');
    $search = Security::clean($_GET['search'] ?? '');
    if (!empty($search)) {
        $where = "pinglun=1 AND (title LIKE '%$search%' OR jianjie LIKE '%$search%')";
    } else {
        $where = 'pinglun=1';
    }
    $list = getList('wen', $where, 6, 0);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <base href="/web/">
    <title>资讯列表 - News Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="News Platform - 新闻资讯列表">
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
                            <li class="nav-item active">
                                <a href="list.php" class="nav-link"><i class="fas fa-list"></i> 资讯列表</a>
                            </li>
                            <li class="nav-item">
                                <a href="category.php" class="nav-link"><i class="fas fa-th-large"></i> 分类</a>
                            </li>
                            <li class="nav-item">
                                <a href="contact.php" class="nav-link"><i class="fas fa-phone"></i> 联系我们</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0 search-form" method="get" action="list.php">
                            <input class="form-control" type="search" name="search" placeholder="搜索新闻..." value="<?php echo htmlspecialchars($search); ?>">
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
                <span>资讯列表</span>
                <?php if (!empty($search)): ?>
                <span class="separator">/</span>
                <span>搜索: <?php echo htmlspecialchars($search); ?></span>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <!-- 主要内容区域 -->
    <section class="list-section">
        <div class="container">
            <div class="row">
                <!-- 文章列表 -->
                <div class="col-lg-8">
                    <div class="section-header">
                        <h2><i class="fas fa-list-alt"></i> 最新资讯</h2>
                        <span class="article-count">共 <?php echo count($list); ?> 篇文章</span>
                    </div>
                    
                    <div class="posts-list">
                        <?php foreach ($list as $key => $value): ?>
                        <article class="list-article">
                            <div class="article-image">
                                <?php if (!empty($value['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($value['image']); ?>" alt="<?php echo htmlspecialchars($value['title']); ?>">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-newspaper"></i>
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
                                    <?php echo htmlspecialchars(mb_substr($value['jianjie'] ?? '暂无简介', 0, 120, 'utf-8')); ?>...
                                </p>
                                <div class="article-meta">
                                    <span><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($value['user']); ?></span>
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo $value['regtime']; ?></span>
                                    <span><i class="fas fa-eye"></i> <?php echo rand(100, 9999); ?></span>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>

                    <button class="load-more-btn" id="loadMoreBtn">
                        <i class="fas fa-refresh"></i> 加载更多
                    </button>
                </div>

                <!-- 侧边栏 -->
                <div class="col-lg-4">
                    <!-- 热门文章 -->
                    <div class="sidebar-card">
                        <h3><i class="fas fa-fire"></i> 热门文章</h3>
                        <div class="popular-list">
                            <?php 
                            $popularList = getList('wen', 'pinglun=1', 5, 0);
                            foreach ($popularList as $index => $item): 
                            ?>
                            <div class="popular-item">
                                <div class="popular-rank"><?php echo $index + 1; ?></div>
                                <div class="popular-content">
                                    <h4>
                                        <a href="post.php?id=<?php echo $item['id']; ?>">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </a>
                                    </h4>
                                    <span class="popular-date"><?php echo $item['regtime']; ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- 分类导航 -->
                    <div class="sidebar-card">
                        <h3><i class="fas fa-tags"></i> 分类导航</h3>
                        <div class="tag-cloud">
                            <a href="category.php#zhengzhi" class="tag-item">政治</a>
                            <a href="category.php#jingji" class="tag-item">经济</a>
                            <a href="category.php#falu" class="tag-item">法律</a>
                            <a href="category.php#junshi" class="tag-item">军事</a>
                            <a href="category.php#keji" class="tag-item">科技</a>
                            <a href="category.php#wenjiao" class="tag-item">文教</a>
                            <a href="category.php#tiyu" class="tag-item">体育</a>
                            <a href="category.php#shehui" class="tag-item">社会</a>
                        </div>
                    </div>

                    <!-- 订阅卡片 -->
                    <div class="sidebar-card subscribe-card">
                        <h3><i class="fas fa-bell"></i> 订阅资讯</h3>
                        <p>订阅我们的新闻推送，第一时间获取最新资讯</p>
                        <form class="subscribe-form" action="#" method="post">
                            <input type="email" placeholder="输入您的邮箱" required>
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
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
    $(document).ready(function(){
        var page = 1;
        $("#loadMoreBtn").on("click", function(){
            page++;
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {
                    type: 'index',
                    page: page
                },
                dataType: "json",
                success: function(msg){
                    if(msg.code == 404){
                        $("#loadMoreBtn").html("<font color='red'>已加载完</font>");
                        $("#loadMoreBtn").unbind('click');
                    } else {
                        var d = msg.list;
                        var html = '';
                        for(var i = 0; i < d.length; i++){
                            html += '<article class="list-article">';
                            html += '    <div class="article-image">';
                            html += '        <div class="no-image-placeholder"><i class="fas fa-newspaper"></i></div>';
                            html += '        <span class="article-category">' + d[i].leibie + '</span>';
                            html += '    </div>';
                            html += '    <div class="article-content">';
                            html += '        <h3 class="article-title"><a href="post.php?id=' + d[i].id + '">' + d[i].title + '</a></h3>';
                            html += '        <p class="article-excerpt">' + (d[i].jianjie ? d[i].jianjie.substring(0, 120) + '...' : '暂无简介') + '</p>';
                            html += '        <div class="article-meta">';
                            html += '            <span><i class="fas fa-user-circle"></i> ' + d[i].user + '</span>';
                            html += '            <span><i class="fas fa-calendar-alt"></i> ' + d[i].regtime + '</span>';
                            html += '            <span><i class="fas fa-eye"></i> ' + Math.floor(Math.random() * 9900 + 100) + '</span>';
                            html += '        </div>';
                            html += '    </div>';
                            html += '</article>';
                        }
                        $(".posts-list").append(html);
                    }
                }
            });
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