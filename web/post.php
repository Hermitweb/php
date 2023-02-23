<?php
include_once("int.php");
  
//根据地址栏参数，获取文章的信息
  $id = $_GET['id'];
  $wen = getOne('wen',$where=" id=$id ");

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <!-- Fancybox-->
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <header>
        <div class="main-menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#"><img src="images/timg.png" alt="logo"></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link">首页</a>
                            </li>
                            <li class="navbar-item">
                                <a href="list.php" class="nav-link">列表</a>
                            </li>
                            <li class="navbar-item">
                                <a href="category.php" class="nav-link active1">分类</a>
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
    <div class="container">
      <div class="row">
        <!-- Latest Posts -->
        <main class="post blog-post col-lg-12"> 
          <div class="post-single">
              <div class="post-thumbnail">
                <img src="images/trending-2.jpg" alt="..." class="img-fluid">
              </div>
              <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                  <div class="category"><a href="category.php"><?php echo $wen['leibie']; ?></a></div>
                </div>
                <h1><?php echo $wen['title']; ?><a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                <div class="post-footer d-flex align-items-center flex-column flex-sm-row">
                  <a href="#" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar">
                      <img src="images/post/avatar-1.jpg" alt="..." class="img-fluid">
                    </div>
                    <div class=""><strong><?php echo $wen['user']; ?></strong></div>
                    <div>&nbsp;&nbsp;</div>
                  </a>
                  <div class="d-flex align-items-center flex-wrap">       
                    <div class="date"></i><?php echo $wen['regtime']; ?></div>
                    <div class="views"></i> 500</div><!-- 浏览 -->
                    
                  </div>
                </div>
                <div class="post-body">
                  <p class="lead">
                    <p><?php echo $wen['jianjie']; ?></p><?php echo $wen['content']; ?>
                  </p>
                </div>
                <!-- ---------------------------------------------------------------------------------- -->
                <div class="post-tags">
                  <a href="#" class="tag">＃商业</a>
                  <a href="#" class="tag">#技巧</a>
                  <a href="#" class="tag">#金融</a>
                  <a href="#" class="tag">#经济</a>
                </div>
                <!-- ---------------------------------------------------------------------------------- -->
                <div class="post-comments">
                  <div class="comment">
                    <div class="comment-header d-flex justify-content-between">
                      <div class="user d-flex align-items-center">
                        <div class="image"><img src="images/post/user.svg" alt="..." class="img-fluid rounded-circle"></div>
                        <div><strong>贾比·埃尔南迪斯（Jabi Hernandiz）</strong><span class="date">2019年5月</span></div>
                      </div>
                    </div>
                    <div class="comment-body">
                      <p>洛雷姆·伊普苏姆·多洛尔（Lorem ipsum dolor）坐立不安，奉献自私的高贵，节制的生活和活力，使劳动和悲伤成为eiusmod要做的一些重要事情。这些年来，我会来的。</p>
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-header d-flex justify-content-between">
                      <div class="user d-flex align-items-center">
                        <div class="image"><img src="images/post/user.svg" alt="..." class="img-fluid rounded-circle"></div>
                        <div><strong>格里高</strong><span class="date">2019年5月</span></div>
                      </div>
                    </div>
                    <div class="comment-body">
                      <p>洛雷姆·伊普苏姆·多洛尔（Lorem ipsum dolor）坐立不安，奉献自私的高贵，节制的生活和活力，使劳动和悲伤成为eiusmod要做的一些重要事情。这些年来，我会来的。</p>
                    </div>
                  </div>
                </div>
                <!-- ---------------------------------------------------------------------------------- -->
                <div class="add-comment">
                  <header1>
                    <h3 class="h6">发表评论</h3>
                  </header1>
                  <form action="#" class="commenting-form">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <input type="text" name="username" id="username" placeholder="名称" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <input type="email" name="username" id="useremail" placeholder="电子邮件地址（不会公开）" class="form-control">
                      </div>
                      <div class="form-group col-md-12">
                        <textarea name="usercomment" id="usercomment" placeholder="输入您的评论" class="form-control"></textarea>
                      </div>
                      <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-secondary">提交</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- ---------------------------------------------------------------------------------- -->
              </div>
          </div>
        </main>
      </div>
    </div>
    <!-- Page Footer-->
    <footer>
        <div class="footer_copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-4 logo-side">
                        <img src="images/logo.png" alt="logo">
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
    <!-- JavaScript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"> </script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"> </script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/front.js"></script>
    <script defer src="js/all.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
  </body>
</html>