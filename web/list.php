<?php
    include_once('int.php');
    //读取文章列表
    //$list = getList('wen',$where=' pinglun = 1 and status = 1 ',$limit=3,$offset=0);
    $list = getList('wen',$where=' pinglun= 1 ',$limit=2,$offset=0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>列表</title>
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
                                <a href="list.php" class="nav-link active1">列表</a>
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
                            <span class="fa fa-search"></span>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <div class="bread-crome">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php" class="prim">首页 </a>
                </li>
                <li class="breadcrumb-item">
                   列表
                </li>
            </ol>
        </div>
    </div>
    <section class="blog-sec">
        <div class="container">
            <div class="main_content_section">
                <div class="main-content">
                    <div class="posts-list">
                        <?php foreach ($list as $key => $value) { ?>

                        <div class="post_item">
                            <img src="images/blog1.jpg" alt="blog">
                            <a href="category.php" class="category-ttl"><?php echo $value['leibie']; ?></a>
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
                        
                            <h2><a href="post.php?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a></h2>
                            <ul class="post-tools">
                                <li class="admin"><a href="post.php?id=<?php echo $value['id']; ?>"><?php echo $value['user']; ?></a></li>
                                <li class="date"><?php echo $value['regtime']; ?></li>
                            </ul>
                            <h6><?php echo $value['jianjie']; ?></h6>
                            <div style="height: 2px;width: 675px;border-bottom: 1px solid #ccc;"></div>
                        </div>
                        <?php } ?>
                    </div>
                    <button class="load-more-btn loadmore">加载更多</button>
                </div>
                
                <aside class="aside-sec">
                <div class="ads-sec">
                    <h2>广告</h2>
                    <img src="images/600-ad.jpg" alt="ad">
                </div>
                </aside>

            </div>
        </div>
    </section>
<footer>
        <div class="footer_widgets">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="pop-posts">
                            <h2>热门帖子</h2>
                            <div class="post-content small-post">
                                <figure style="background:url(./images/tab4.jpg)no-repeat"></figure>
                                <div class="content">
                                    <a href="#">
                                        <h3 class="post-ttl">银西高铁全线即将开通运营</h3>
                                    </a>
                                    <ul class="post-tools">
                                        <li class="admin"><a href="#">管理 </a></li>
                                        <li class="date">2020-3-19</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-content small-post">
                                <figure style="background:url(./images/tab5.jpg)no-repeat"></figure>
                                <div class="content">
                                    <a href="#">
                                        <h3 class="post-ttl">嫦娥五号轨道器和返回器组合体实施第一次月地转移入射</h3>
                                    </a>
                                    <ul class="post-tools">
                                        <li class="admin"><a href="#">管理 </a></li>
                                        <li class="date">2020-3-19</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-content small-post">
                                <figure style="background:url(./images/tab6.jpg)no-repeat"></figure>
                                <div class="content">
                                    <a href="#">
                                        <h3 class="post-ttl">冬日黄河湿地美</h3>
                                    </a>
                                    <ul class="post-tools">
                                        <li class="admin"><a href="#">管理 </a></li>
                                        <li class="date">2020-3-19</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 categories">
                        <h2>类别</h2>
                        <ul>
                            <li><a href="#">政治 (3)</a></li>
                            <li><a href="#">经济 (2)</a></li>
                            <li><a href="#">法律 (1)</a></li>
                            <li><a href="#">军事 (2)</a></li>
                            <li><a href="#">科技 (7)</a></li>
                            <li><a href="#">文教 (7)</a></li>
                            <li><a href="#">体育 (7)</a></li>
                            <li><a href="#">社会 (20)</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
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
    <script type="text/javascript" src="js/wmBox.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
</body>
<script>
        //保证页面加载完成才执行jquery
    $(document).ready(function(){
        var page = 1;
        //给加载更多控件绑定事件
        $(".loadmore").on("click",function(){
            page = page+1;
            $.ajax({
               type: "post",
               url: "ajax.php",
               data: {
                    type:'index',
                    page:page

               },
               dataType:"json",
               success: function(msg){
                //没有数据了
                if(msg.code==404){

                    $(".loadmore").html("<font color='red'>已加载完</font>");
                    $(".loadmore").unbind('click');

                }else{

                    var d = msg.list; //数据的数组

                    var html = '';
                    for(var i =0;i<d.length;i++){

                        // html +='    <div class="post post-layout-list" data-aos="fade-up">';
                    html +='    <div class="post_item">';
                    html +='        <img src="images/blog1.jpg" alt="blog">';
                    html +='        <a href="#" class="category-ttl">'+d[i].leibie+'</a>';
                    html +='        <div class="shared-sec right">';
                    html +='            <ul>';
                    html +='                <li> 分享 ：</li>';
                    html +='                <li><a href="#"><span class="fab fa-facebook"></span></a></li>';
                    html +='                <li><a href="#"><span class="fab fa-instagram"></span></a></li>';
                    html +='                <li><a href="#"><span class="fab fa-twitter"></span></a></li>';
                    html +='                <li><a href="#"><span class="fab fa-pinterest"></span></a></li>';
                    html +='                <li><a href="#"><span class="fab fa-google-plus-g"></span></a></li>';
                    html +='            </ul>';
                    html +='        </div>';
                    html +='    <h2><a href="post.php?id='+d[i].id+'">'+d[i].title+'</a></h2>';
                    html +='    <ul class="post-tools">';
                    html +='        <li class="admin"><a href="post.php?id='+d[i].id+'">'+d[i].user+'</a></li>';
                    html +='        <li class="date">'+d[i].regtime+'</li>';
                    html +='    </ul>';
                    html +='    <h6>'+d[i].jianjie+'</h6>';
                    html +='    <div style="height: 2px;width: 675px;border-bottom: 1px solid #ccc;"></div>';
                    html +='    </div>';

                    }
                    
                  $(".posts-list").append(html);

                }
                
               }

            });





        });


    });
</script>
</html>