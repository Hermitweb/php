<?php
  include_once("int.php");
  //读取分类列表
  
  $count =  get_rows('wen',$where=" 1 "); //数据总数
  $page_size = 10; //每页显示多少条记录

  $page = empty($_GET['page'])?1:$_GET['page'];
 
  $page = !is_numeric($page)?1:$page ; //判断一个数是否是整数

  

  $pages = ceil($count/$page_size);

   $offset = ($page-1)*$page_size;


  //读取文章列表
  $list = getList('wen',$where=' 1 ',$limit=$page_size,$offset);

 ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>admin-天权</title>
  <link rel="stylesheet" href="layui/css/layui.css">
  <link rel="stylesheet" href="css/index.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo"><img src="images/logo.jpg"/></div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">后台管理系统</a>
      </li>
    </ul>
    <?php
      include_once("nav.php");
    ?>
  </div>
  
  <div class="layui-side">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item"><a href="index.php">首页</a></li>
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">文章管理</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" style="background: #2c87ff;">操作文章</a></dd>
            <dd><a href="fabu.php">发布文章</a></dd>
            
          </dl>
        </li>
        <li class="layui-nav-item"><a href="i-user.php">用户表</a></li>
        <li class="layui-nav-item"><a href="user.php">管理员列表</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
      <table id="demo1">
        <thead>
          <tr>
            <th>序号</th>
            <th>作者</th>
            <th>文章标题</th>
            <th>文章类别</th>
            <th>发布时间</th>
            <th>操作文章</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $key => $value) { ?>
          <tr>
            <td><?php  echo $value['id'] ?></td>
            <td><?php  echo $value['user'] ?></td>
            <td><?php  echo $value['title'] ?></td>
            <td><?php  echo $value['leibie'] ?></td>
            <td><?php  echo $value['regtime']?></td>
            <td>                                                                            
                <a href="caozuo.php" class="pinglun layui-btn layui-btn-ms layui-btn-normal" data-value="<?php echo $value['id'] ?>"><?php  echo $value['pinglun']==1?"允许评论":"禁止评论"; ?></a>
                <a href="caozuo.php" class="remen layui-btn layui-btn-ms layui-btn-normal" data-value="<?php echo $value['id'] ?>"><?php  echo $value['remen']==0?"取消热门":"设为热门"; ?></a>
                <a href="javascript:void(0)" class="del layui-btn layui-btn-ms layui-btn-normal" data-value="<?php echo $value['id'] ?>">删除</a>
                <a href="xiugai.php?id=<?php echo $value['id'] ?>" class="layui-btn layui-btn-ms layui-btn-normal" data-value="<?php echo $value['id'] ?>">编辑</a>
                             
                          
            </td>
          </tr>
          <?php  } ?>
        </tbody>  
      </table>
      <div class="tbfooter">
      <!-- <div class="deme-line"></div> -->
        <div class="demo-footer">
          <div>
            <p style="float: left;">共 <?php echo $count; ?> 条记录</p>
          </div>
          <div>
            <span class="layui-badge layui-bg-blue"><a href="caozuo.php?page=1">首页</a></span>
          <span class="layui-badge layui-bg-blue"><a href="caozuo.php?page=<?php echo ($page-1)<=0?1:($page-1); ?>"><i class="layui-icon layui-icon-prev"></i></a></span>
          <span class="layui-badge-rim" style="color: black;"><?php echo $page ?></span>
          <span class="layui-badge layui-bg-blue"><a href="caozuo.php?page=<?php echo ($page+1)>$pages?$pages:($page+1); ?>"><i class="layui-icon layui-icon-next"></i></a></span>
          <span class="layui-badge layui-bg-blue"><a href="caozuo.php?page=<?php echo $pages; ?>">尾页</a></span>
          </div>
          
        </div>
      </div> 
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © admin-天权 - 底部固定区域
  </div>
</div>
<script src="layui/layui.all.js"></script>
<script src="js/jquery.min.js"></script>
<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
});
<?php include_once("int.php");?>
//评论
$(".pinglun").click(function(){
    var id = $(this).attr('data-value');
    var obj =$(this);
    $.ajax({
      type:'post',
      url:'ajax.php',
      data:{
        id:id,
        type:'pinglun'
      },
      dataType:'json',
      success:function(msg){
        if(msg.code==100){
          obj.find('font').html(msg.string);
        }
    }

    });})
  
  //热门
$(".remen").click(function(){
    var id = $(this).attr('data-value');
    var obj =$(this);
    $.ajax({
      type:'post',
      url:'ajax.php',
      data:{
        id:id,
        type:'remen'
      },
      dataType:'json',
      success:function(msg){
        if(msg.code==100){
          obj.find('font').html(msg.string);
        }
    }

    });});
 
  //删除
$(".del").click(function(){
   
    var id = $(this).attr('data-value');
    var obj =$(this);
    $.ajax({
      type:'post',
      url:'ajax.php',
      data:{
        id:id,
        type:'del'
      },
      dataType:'json',
      success:function(msg){
        if(msg.code==100){
          obj.parents('tr').remove();
        }
    }

    });
  })
  



</script>
</body>
</html>