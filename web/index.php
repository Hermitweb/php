<?php
    include_once('int.php');
    //读取文章列表
    //$list = getList('wen',$where=' pinglun = 1 and status = 1 ',$limit=3,$offset=0);
    $list = getList('wen',$where=' pinglun= 1 ',$limit=5,$offset=0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <div class="main-menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="index.php"><img src="images/timg.png" alt="logo"></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link active1">首页</a>
                            </li>
                            <li class="navbar-item">
                                <a href="list.php" class="nav-link">列表</a>
                            </li>
                            <li class="navbar-item">
                                <a href="category.php" class="nav-link">分类</a>
                            </li>
                            
                            <li class="navbar-item">
                                <a href="contact.php" class="nav-link">联系我们</a>
                            </li>
                            <?php
                                include_once("nav.php");
                            ?>
                            
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="请在这里键入您的搜索..." aria-label="Search">
                            <a href="#"><span class="fa fa-search"></span></a>
                        </form>
                    </div>

                </nav>
            </div>
        </div>
    </header>
    <section class="news-banner">
        <div class="container">
            <div class="row">

            <?php foreach ($list as $key => $value) { ?>

                <div class="col-sm-12" style="margin-bottom: 50px;">
                    <div class="big-img" style="background:url(./images/001.jpg)no-repeat;">
                        <div class="post-content">
                            <div class="content">
                                <a href="" class="category-ttl"><?php echo $value['leibie']; ?></a>
                                <a href="post.php?id=<?php echo $value['id']; ?>">
                                    <h3 class="post-ttl"><a href="post.php?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a></h3>
                                </a>
                                <ul class="post-tools">
                                    <li class="admin"><a href="#"><?php echo $value['user']; ?></a></li>
                                    <li class="date"><?php echo $value['regtime']; ?></li>
                                    <li class="comment">(0) 浏览</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            <?php } ?>

            </div>
        </div>
    </section>
    <!-- Ad section -->
    <div class="responsive ad-sec">
        <div class="container">
            <img src="images/responsive-ad.jpg" alt="ad">
        </div>
    </div>
    <!-- End ad section -->

    <footer>

        <div class="footer_copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-4 logo-side">
                        <a href="index.php"><img src="images/logo.png" alt="logo"></a>
                    </div>
                    <div class="col-lg-6 col-md-8">
                        <ul class="footer-menu">
                            <li>
                                <a href="index.php">首页</a>
                            </li>
                            <li>
                                <a href="list.php">列表</a>
                            </li>
                            <li>
                                <a href="category.php">类别</a>
                            </li>
                            <li>
                                <a href="boke.php">博客</a>
                            </li>
                            <li>
                                <a href="contact.php">联系</a>
                            </li>
                        </ul>
                        <h5 class="copy-right">版权 &copy; 2018.公司名称 保留所有权利。</h5>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js">
    </script>
    <script defer src="js/all.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
</body>

</html>