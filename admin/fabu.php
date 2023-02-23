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
              <dd><a href="caozuo.php">操作文章</a></dd>
              <dd><a href="fabu.php" style="background: #2c87ff;">发布文章</a></dd>
              
            </dl>
          </li>
          <li class="layui-nav-item"><a href="i-user.php">用户表</a></li>
        <li class="layui-nav-item"><a href="user.php">管理员列表</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <form class="layui-form" action="fabu.php" method="post" enctype="multipart/form-data"> 
        <div class="layui-form-item">
          <label class="layui-form-label">文章作者</label>
          <div class="layui-input-block">
            <input type="text" name="zuozhe" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">文章标题</label>
          <div class="layui-input-block">
            <input type="text" name="title" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">文章简介</label>
          <div class="layui-input-inline">
            <input type="text" name="jianjie" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">展示图片</label>
          <div class="layui-input-inline">
            <button type="file" class="layui-btn" name="image" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">文章类别</label>
          <div class="layui-input-block select">
            <select name="city" lay-verify="required">
              <option></option>
              <option value="政治">政治</option>
              <option value="经济">经济</option>
              <option value="法律">法律</option>
              <option value="军事">军事</option>
              <option value="科技">科技</option>
              <option value="文教">文教</option>
              <option value="体育">体育</option>
              <option value="社会">社会</option>
            </select>
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">发布时间</label>
          <div class="layui-input-block">
            <input type="text" name="regtime" class="layui-input" id="testtime">
          </div>
        </div>
        <div class="layui-form-item layui-form-text">
          <label class="layui-form-label">文本域</label>
          <div class="layui-input-block">
            <textarea id="demo" name="content" style="display: none;"></textarea>
          </div>
        </div>
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn" type="submit" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
          </div>
        </div>
    </form>
    
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
layui.use('layedit', function(){
  var layedit = layui.layedit;
  layedit.build('demo'); //建立编辑器
});
layui.use('laydate', function(){
  var laydate = layui.laydate;
  
  //执行一个laydate实例
  laydate.render({
    elem: '#testtime' //指定元素
    ,type: 'datetime'
  });
});
layui.use('upload', function(){
  var upload = layui.upload;
   
  //执行实例
  var uploadInst = upload.render({
    elem: '#test1' //绑定元素
    ,url: 'get' //上传接口
    ,done: function(res){
      //上传完毕回调
    }
    ,error: function(){
      //请求异常回调
    }
  });
});
</script>
</body>
</html>
<?php
  include_once("int.php");
  $data=$_POST;
  if(empty($data)){
    die();
  }

  $insert = array(
    'user'=>$data['zuozhe'],
    'title'=>$data['title'],
    'jianjie'=>$data['jianjie'],
    'leibie'=>$data['city'],
    'regtime'=>$data['regtime'],
    'content'=>$data['content']
   
  );
  
  //判断是否有文件上传  - 表示有文件上传
  if(!empty($_FILES['image']['name'])){
    
    $file_dir = date("Ymd",time());
    $file = '../upload/'.$file_dir;  
    //当文件目录不存在时，创建目录
    if(!file_exists($file)){
      mkdir($file,777,true);
    }
    
    
    $file_type = strrchr($_FILES['image']['name'],'.');  //获取文件的后缀名

    $file_allow_type = array('.jpg','.png');
    if(!in_array($file_type, $file_allow_type)){

      echo "<script>alert('对不起，你上传的不是图片');</script>";die();
    }
    $filename = $_FILES['image']['tmp_name']; //上传文件在服务器上的临时存储路径
    $savefile = $file.'/'.time().rand(1111,9999).$file_type;  // 上传文件在服务器的最终存储路径
    move_uploaded_file($filename, $savefile );
    $insert['image'] = $savefile; //当有文件上传的时候，才往数据数组中追加 image
  }


  $result = add('wen',$insert);
  if($result){

    echo "<script>alert('发布文章成功');location='index.php'</script>";
  }else{
     echo "<script>alert('发布文章失败');</script>";
  }



?>