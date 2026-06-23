<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <base href="/web/">
    <title>联系我们 - News Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="News Platform - 联系我们">
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
                            <li class="nav-item">
                                <a href="category.php" class="nav-link"><i class="fas fa-th-large"></i> 分类</a>
                            </li>
                            <li class="nav-item active">
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
                <span>联系我们</span>
            </nav>
        </div>
    </div>

    <!-- 联系我们内容区域 -->
    <section class="contact-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><i class="fas fa-headphones"></i> 联系我们</h2>
                <p>我们非常重视您的意见和建议，欢迎随时与我们联系</p>
            </div>

            <div class="row">
                <!-- 联系信息 -->
                <div class="col-lg-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>联系地址</h3>
                        <p>中国北京市朝阳区建国路88号</p>
                        <p>News Platform 总部大厦</p>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>联系电话</h3>
                        <p>客服热线：400-888-8888</p>
                        <p>工作时间：周一至周五 9:00-18:00</p>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>电子邮箱</h3>
                        <p>客服邮箱：support@news-platform.com</p>
                        <p>商务合作：business@news-platform.com</p>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>工作时间</h3>
                        <p>周一至周五：09:00 - 18:00</p>
                        <p>周六至周日：10:00 - 16:00</p>
                    </div>
                </div>

                <!-- 联系表单 -->
                <div class="col-lg-8">
                    <div class="contact-form-card">
                        <h3><i class="fas fa-message-square"></i> 发送消息</h3>
                        <form id="contactForm" method="post" action="#">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label><i class="fas fa-user"></i> 您的姓名</label>
                                    <input type="text" class="form-control" name="name" placeholder="请输入您的姓名" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label><i class="fas fa-envelope"></i> 电子邮箱</label>
                                    <input type="email" class="form-control" name="email" placeholder="请输入您的邮箱" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label><i class="fas fa-phone"></i> 联系电话</label>
                                    <input type="tel" class="form-control" name="phone" placeholder="请输入您的电话">
                                </div>
                                <div class="form-group col-md-6">
                                    <label><i class="fas fa-tag"></i> 咨询类型</label>
                                    <select class="form-control" name="type">
                                        <option value="feedback">意见反馈</option>
                                        <option value="business">商务合作</option>
                                        <option value="advertising">广告投放</option>
                                        <option value="other">其他咨询</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-file-text"></i> 留言内容</label>
                                <textarea class="form-control" name="message" rows="5" placeholder="请输入您的留言内容..." required></textarea>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                                <label class="form-check-label" for="agree">
                                    我已阅读并同意 <a href="#">《用户协议》</a> 和 <a href="#">《隐私政策》</a>
                                </label>
                            </div>
                            <button type="submit" class="btn-primary btn-block">
                                <i class="fas fa-paper-plane"></i> 发送留言
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 地图区域 -->
            <div class="map-section">
                <div class="section-header">
                    <h2><i class="fas fa-map"></i> 我们的位置</h2>
                </div>
                <div class="map-container">
                    <div class="map-placeholder">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>北京市朝阳区建国路88号</p>
                        <p>News Platform 总部大厦</p>
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
                            <li><i class="fas fa-map-marker-alt"></i> 中国 北京市朝阳区建国路88号</li>
                            <li><i class="fas fa-phone"></i> 400-888-8888</li>
                            <li><i class="fas fa-envelope"></i> support@news-platform.com</li>
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
        $("#contactForm").submit(function(e){
            e.preventDefault();
            alert("感谢您的留言！我们会尽快与您联系。");
            $(this)[0].reset();
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