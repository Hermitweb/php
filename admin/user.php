<?php
  include_once("int.php");
  //读取分类列表
  
  $count =  get_rows('admin',$where=" 1 "); //数据总数
  $page_size = 10; //每页显示多少条记录

  $page = empty($_GET['page'])?1:$_GET['page'];
 
  $page = !is_numeric($page)?1:$page ; //判断一个数是否是整数

  

  $pages = ceil($count/$page_size);

   $offset = ($page-1)*$page_size;


  //读取文章列表
  $list = getList('admin',$where=' 1 ',$limit=$page_size,$offset);
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
        <li class="layui-nav-item">
            <a class="" href="javascript:;">文章管理</a>
            <dl class="layui-nav-child">
              <dd><a href="caozuo.php">操作文章</a></dd>
              <dd><a href="fabu.php">发布文章</a></dd>
              
            </dl>
          </li>
          <li class="layui-nav-item"><a href="i-user.php">用户表</a></li>
        <li class="layui-nav-item"><a href="user.php" style="background: #2c87ff;">管理员列表</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="user-list">
        <h1>管理员列表</h1>
        <div class="u-list">
          <table class="uu-list">
            <tr>
              <th class="xuhao">序号</th>
              <th class="td-user">用户名</th>
              <th class="td-id">账号</th>
            </tr>
          <?php foreach ($list as $key => $value) { ?>
            <tr>
              <td class="xuhao"><?php  echo $value['id'] ?></td>
              <td class="td-user"><?php  echo $value['name'] ?></td>
              <td class="td-id"><?php  echo $value['phone'] ?></td>
            </tr>
          <?php  } ?>  
          </table>
        </div>
        <div class="user-footer">
          <button><a href="log/reg.php">注册</a></button>
        </div>
      </div>
    
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © admin-天权 - 底部固定区域
  </div>
</div>
<script src="layui/layui.all.js"></script>
<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
  
});
</script>
</body>
</html>