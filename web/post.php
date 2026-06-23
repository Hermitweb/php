<?php
require_once("int.php");

// 根据地址栏参数，获取文章的信息
$id = Security::clean($_GET['id'] ?? 0);
if (!is_numeric($id)) {
    $id = 0;
}
$wen = getOne('wen', $where=" id=$id ");

if (!$wen) {
    header('Location: list.php');
    exit;
}

// 获取相关文章
$relatedList = getList('wen', "leibie='" . $wen['leibie'] . "' AND id != $id", 4, 0);

// 模拟阅读量
$viewCount = rand(500, 5000);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($wen['title']); ?> - News Platform</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/home-modern.css">
    <link rel="stylesheet" type="text/css" href="css/post-modern.css">
</head>
<body>
    <!-- 顶部公告栏 -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <span><i class="fas fa-bullhorn"></i> 欢迎访问 News Platform</span>
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
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a href="index.php" class="nav-link"><i class="fas fa-home"></i> 首页</a></li>
                            <li class="nav-item"><a href="list.php" class="nav-link"><i class="fas fa-list"></i> 资讯列表</a></li>
                            <li class="nav-item"><a href="category.php" class="nav-link"><i class="fas fa-th-large"></i> 分类</a></li>
                            <li class="nav-item"><a href="contact.php" class="nav-link"><i class="fas fa-phone"></i> 联系我们</a></li>
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
                <a href="list.php">资讯</a>
                <span class="separator">/</span>
                <a href="category.php?cat=<?php echo urlencode($wen['leibie']); ?>"><?php echo htmlspecialchars($wen['leibie']); ?></a>
                <span class="separator">/</span>
                <span class="current"><?php echo htmlspecialchars($wen['title']); ?></span>
            </nav>
        </div>
    </div>

    <!-- 文章主体 -->
    <main class="article-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="article-content-wrap">
                        <!-- 文章头部 -->
                        <header class="article-header">
                            <span class="article-category-tag">
                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($wen['leibie']); ?>
                            </span>
                            <h1 class="article-title-main"><?php echo htmlspecialchars($wen['title']); ?></h1>
                            <p class="article-summary"><?php echo htmlspecialchars($wen['jianjie']); ?></p>

                            <div class="article-meta-bar">
                                <div class="meta-author">
                                    <div class="author-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="author-info">
                                        <div class="author-name"><?php echo htmlspecialchars($wen['user']); ?></div>
                                        <div class="meta-other">
                                            <span><i class="fas fa-calendar"></i> <?php echo $wen['regtime']; ?></span>
                                            <span><i class="fas fa-eye"></i> <?php echo number_format($viewCount); ?> 阅读</span>
                                            <span><i class="fas fa-clock"></i> <?php echo rand(3, 10); ?>分钟阅读</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="meta-actions">
                                    <button class="action-btn" onclick="likeArticle()" title="点赞">
                                        <i class="fas fa-thumbs-up"></i> <span id="likeCount"><?php echo rand(10, 200); ?></span>
                                    </button>
                                    <button class="action-btn" onclick="shareArticle()" title="分享">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <button class="action-btn" onclick="bookmarkArticle()" title="收藏">
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                        </header>

                        <!-- 封面图 -->
                        <?php if (!empty($wen['image'])): ?>
                        <div class="article-cover">
                            <img src="<?php echo htmlspecialchars($wen['image']); ?>" alt="">
                        </div>
                        <?php endif; ?>

                        <!-- 文章正文 -->
                        <div class="article-body">
                            <p class="lead-paragraph">
                                <?php echo htmlspecialchars($wen['jianjie']); ?>
                            </p>

                            <?php
                            $content = !empty($wen['content']) ? $wen['content'] : $wen['jianjie'];
                            $paragraphs = explode("\n", $content);
                            foreach ($paragraphs as $para):
                                if (trim($para)):
                            ?>
                            <p><?php echo htmlspecialchars($para); ?></p>
                            <?php
                                endif;
                            endforeach;
                            ?>

                            <p>本文详细介绍了相关主题的最新动态和发展趋势，为读者提供了全面而深入的视角。无论您是行业从业者还是普通读者，都能从中获得有价值的信息和启示。</p>

                            <p>随着技术的不断进步和社会的发展变化，这一领域正经历着前所未有的变革。我们将持续关注并报道最新的发展动态，为读者提供及时、准确的信息服务。</p>

                            <blockquote class="article-quote">
                                <i class="fas fa-quote-left"></i>
                                <p>新闻的价值在于真实，资讯的意义在于分享。News Platform 致力于为您提供最有价值的新闻内容。</p>
                                <cite>— News Platform 编辑部</cite>
                            </blockquote>

                            <p>感谢您阅读本文，如果您觉得内容有价值，欢迎分享给身边的朋友。您的支持是我们持续创作的动力。</p>
                        </div>

                        <!-- 标签 -->
                        <div class="article-tags">
                            <i class="fas fa-tags"></i>
                            <a href="#" class="tag-link">#<?php echo htmlspecialchars($wen['leibie']); ?></a>
                            <a href="#" class="tag-link">#新闻</a>
                            <a href="#" class="tag-link">#资讯</a>
                            <a href="#" class="tag-link">#News Platform</a>
                        </div>

                        <!-- 分享 -->
                        <div class="article-share">
                            <span>分享到：</span>
                            <a href="#" class="share-btn share-weixin"><i class="fab fa-weixin"></i></a>
                            <a href="#" class="share-btn share-weibo"><i class="fab fa-weibo"></i></a>
                            <a href="#" class="share-btn share-qq"><i class="fab fa-qq"></i></a>
                            <a href="#" class="share-btn share-link"><i class="fas fa-link"></i></a>
                        </div>

                        <!-- 评论区 -->
                        <section class="comments-section">
                            <h2 class="comments-title">
                                <i class="fas fa-comments"></i> 评论区
                                <span class="comment-count">3 条评论</span>
                            </h2>

                            <form class="comment-form">
                                <textarea placeholder="说点什么吧..." rows="4"></textarea>
                                <div class="comment-form-actions">
                                    <input type="text" placeholder="您的昵称">
                                    <button type="submit" class="submit-comment">
                                        <i class="fas fa-paper-plane"></i> 发表
                                    </button>
                                </div>
                            </form>

                            <ul class="comment-list">
                                <li class="comment-item">
                                    <div class="comment-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-meta">
                                            <strong>读者A</strong>
                                            <span>2小时前</span>
                                        </div>
                                        <p>很有深度的文章，分析得很到位！期待更多这样的内容。</p>
                                        <div class="comment-actions">
                                            <a href="#"><i class="fas fa-thumbs-up"></i> 12</a>
                                            <a href="#"><i class="fas fa-reply"></i> 回复</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="comment-item">
                                    <div class="comment-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-meta">
                                            <strong>读者B</strong>
                                            <span>5小时前</span>
                                        </div>
                                        <p>内容很有价值，希望News Platform越办越好！</p>
                                        <div class="comment-actions">
                                            <a href="#"><i class="fas fa-thumbs-up"></i> 8</a>
                                            <a href="#"><i class="fas fa-reply"></i> 回复</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="comment-item">
                                    <div class="comment-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-meta">
                                            <strong>读者C</strong>
                                            <span>1天前</span>
                                        </div>
                                        <p>关注这个话题很久了，这篇文章给我提供了新的思路。</p>
                                        <div class="comment-actions">
                                            <a href="#"><i class="fas fa-thumbs-up"></i> 5</a>
                                            <a href="#"><i class="fas fa-reply"></i> 回复</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </section>
                    </article>
                </div>

                <!-- 侧边栏 -->
                <div class="col-lg-4">
                    <aside class="article-sidebar">
                        <!-- 相关文章 -->
                        <?php if (!empty($relatedList)): ?>
                        <div class="sidebar-card">
                            <h3><i class="fas fa-newspaper"></i> 相关文章</h3>
                            <ul class="related-list">
                                <?php foreach ($relatedList as $related): ?>
                                <li>
                                    <a href="post.php?id=<?php echo $related['id']; ?>">
                                        <span class="related-title"><?php echo htmlspecialchars($related['title']); ?></span>
                                        <span class="related-date"><?php echo $related['regtime']; ?></span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- 推荐 -->
                        <div class="sidebar-card">
                            <h3><i class="fas fa-fire"></i> 热门推荐</h3>
                            <ul class="related-list">
                                <li><a href="#"><span class="related-title">科技发展趋势深度解析</span><span class="related-date">2026-06-22</span></a></li>
                                <li><a href="#"><span class="related-title">全球经济形势分析</span><span class="related-date">2026-06-21</span></a></li>
                                <li><a href="#"><span class="related-title">数字化转型成功案例</span><span class="related-date">2026-06-20</span></a></li>
                                <li><a href="#"><span class="related-title">可持续发展报告</span><span class="related-date">2026-06-19</span></a></li>
                                <li><a href="#"><span class="related-title">行业未来展望</span><span class="related-date">2026-06-18</span></a></li>
                            </ul>
                        </div>

                        <!-- 订阅 -->
                        <div class="sidebar-card subscribe-card">
                            <h3><i class="fas fa-envelope"></i> 邮件订阅</h3>
                            <p>订阅我们的周报，第一时间获取最新资讯</p>
                            <form>
                                <input type="email" placeholder="您的邮箱地址">
                                <button type="submit">
                                    <i class="fas fa-paper-plane"></i> 订阅
                                </button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>

    <!-- 现代页脚 -->
    <footer class="modern-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3><i class="fas fa-newspaper"></i> News Platform</h3>
                        <p>专业的新闻资讯平台，为您提供最新、最快、最全面的新闻报道。</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    // 点赞
    function likeArticle() {
        const el = document.getElementById('likeCount');
        el.textContent = parseInt(el.textContent) + 1;
        Swal.fire({
            icon: 'success',
            title: '感谢您的支持！',
            text: '您的点赞是我们创作的动力',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // 分享
    function shareArticle() {
        Swal.fire({
            title: '分享文章',
            text: '复制链接分享给朋友',
            input: 'text',
            inputValue: window.location.href,
            showCancelButton: true,
            confirmButtonText: '复制',
            cancelButtonText: '取消'
        });
    }

    // 收藏
    function bookmarkArticle() {
        Swal.fire({
            icon: 'success',
            title: '已收藏！',
            text: '可在个人中心查看',
            timer: 1500,
            showConfirmButton: false
        });
    }
    </script>
</body>
</html>
