<?php
    include_once('int.php');
    //读取文章列表
    //$list = getList('wen',$where=' pinglun = 1 and status = 1 ',$limit=3,$offset=0);
    $list1 = getList('wen',$where=" pinglun= 1 and leibie='政治'");
    $list2 = getList('wen',$where=" pinglun= 1 and leibie='经济'");
    $list3 = getList('wen',$where=" pinglun= 1 and leibie='法律'");
    $list4 = getList('wen',$where=" pinglun= 1 and leibie='军事'");
    $list5 = getList('wen',$where=" pinglun= 1 and leibie='科技'");
    $list6 = getList('wen',$where=" pinglun= 1 and leibie='文教'");
    $list7 = getList('wen',$where=" pinglun= 1 and leibie='体育'");
    $list8 = getList('wen',$where=" pinglun= 1 and leibie='社会'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>分类</title>
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
                    <a class="navbar-brand" href="#"><img src="images/logo.png" alt="logo"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item ">
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
                            <span class="fa fa-search"></span>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <div class="bread-crome">
            <div class="lei">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active bg"><a href="#zhengzhi" aria-controls="home" role="tab" data-toggle="tab">政治</a></li>
                    <li role="presentation" class=""><a href="#jingji" aria-controls="profile" role="tab" data-toggle="tab">经济</a></li>
                    <li role="presentation" class=""><a href="#falu" aria-controls="messages" role="tab" data-toggle="tab">法律</a></li>
                    <li role="presentation" class=""><a href="#junshi" aria-controls="settings" role="tab" data-toggle="tab">军事</a></li>
                    <li role="presentation" class=""><a href="#keji" aria-controls="settings" role="tab" data-toggle="tab">科技</a></li>
                    <li role="presentation" class=""><a href="#wenjiao" aria-controls="settings" role="tab" data-toggle="tab">文教</a></li>
                    <li role="presentation" class=""><a href="#tiyu" aria-controls="settings" role="tab" data-toggle="tab">体育</a></li>
                    <li role="presentation" class=""><a href="#shehui" aria-controls="settings" role="tab" data-toggle="tab">社会</a></li>
                </ul>
            </div>
    </div>
    <section class="blog-sec">
        <div class="container tab-content">
            <div class="main-content tab-pane active" id="zhengzhi">
                <h1>政治</h1>


                <?php foreach ($list1 as $key1 => $value1) { ?>

                <div class="post_item">
                    <img src="images/blog1.jpg" alt="blog">
                    <a href="category.php" class="category-ttl"><?php echo $value1['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value1['id']; ?>"><?php echo $value1['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value1['user']; ?> </a></li>
                        <li class="date"><?php echo $value1['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value1['jianjie']; ?></h6>  
                </div>

                <?php } ?>
            </div>
            <div class="main-content tab-pane" id="jingji">
                <h1>经济</h1>


                <?php foreach ($list2 as $key2 => $value2) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value2['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value2['id']; ?>"><?php echo $value2['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value2['user']; ?> </a></li>
                        <li class="date"><?php echo $value2['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value2['jianjie']; ?></h6>  
                </div>

                <?php } ?>

            </div>
            <div class="main-content tab-pane" id="falu">
                <h1>法律</h1>



                <?php foreach ($list3 as $key2 => $value3) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value3['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value3['id']; ?>"><?php echo $value3['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value3['user']; ?> </a></li>
                        <li class="date"><?php echo $value3['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value3['jianjie']; ?></h6>  
                </div>

                <?php } ?>
                



            </div>
            <div class="main-content tab-pane" id="junshi">
                <h1>军事</h1>


                <?php foreach ($list4 as $key4 => $value4) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value4['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value4['id']; ?>"><?php echo $value4['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value4['user']; ?> </a></li>
                        <li class="date"><?php echo $value4['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value4['jianjie']; ?></h6>  
                </div>

                <?php } ?>


            </div>
            <div class="main-content tab-pane" id="keji">
                <h1>科技</h1>


                <?php foreach ($list5 as $key5 => $value5) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value5['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value5['id']; ?>"><?php echo $value5['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value5['user']; ?> </a></li>
                        <li class="date"><?php echo $value5['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value5['jianjie']; ?></h6>  
                </div>

                <?php } ?>
                


            </div>
            <div class="main-content tab-pane" id="wenjiao">
                <h1>文教</h1>



                <?php foreach ($list6 as $key6 => $value6) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value6['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value6['id']; ?>"><?php echo $value6['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value6['user']; ?> </a></li>
                        <li class="date"><?php echo $value6['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value6['jianjie']; ?></h6>  
                </div>

                <?php } ?>
                



            </div>
            <div class="main-content tab-pane" id="tiyu">
                <h1>体育</h1>



                <?php foreach ($list7 as $key7 => $value7) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value7['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value7['id']; ?>"><?php echo $value7['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value7['user']; ?> </a></li>
                        <li class="date"><?php echo $value7['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value7['jianjie']; ?></h6>  
                </div>

                <?php } ?>
                



            </div>
            <div class="main-content tab-pane" id="shehui">
                <h1>社会</h1>



                <?php foreach ($list8 as $key8 => $value8) { ?>

                <div class="post_item">
                        <img src="images/blog1.jpg" alt="blog">
                        <a href="category.php" class="category-ttl"><?php echo $value8['leibie']; ?></a>
                    <div class="shared-sec right">
                        <ul>
                            <li> 分享 ：</li>
                            <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>    
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
                            <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>    
                        </ul>   
                    </div>
                    <h2><a href="post.php?id=<?php echo $value8['id']; ?>"><?php echo $value8['title']; ?></a></h2>
                    <ul class="post-tools">
                        <li class="admin"><a href="#"><?php echo $value8['user']; ?> </a></li>
                        <li class="date"><?php echo $value8['regtime']; ?></li>
                    </ul>
                    <h6><?php echo $value8['jianjie']; ?></h6>  
                </div>

                <?php } ?>
                



            </div>
            <aside class="aside-sec">
                <div class="ads-sec">
                    <h2>广告</h2>
                    <img src="images/600-ad.jpg" alt="ad">
                </div>

            </aside>
        </div>
    </section>
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
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js">
    </script>
    <script defer src="js/all.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
</body>
<script>
    $(".lei>.nav-tabs li").click(function(){
        // var biao=$(".lei>.nav-tabs li").index();
        $(this).addClass("bg").siblings().removeClass("bg");
    })
</script>
</html>