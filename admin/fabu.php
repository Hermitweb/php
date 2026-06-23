<?php
require_once("int.php");
Security::requireLogin('log/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    
    $insert = array(
        'user' => $data['zuozhe'],
        'title' => $data['title'],
        'jianjie' => $data['jianjie'],
        'leibie' => $data['city'],
        'regtime' => $data['regtime'] ?: date('Y-m-d H:i:s'),
        'content' => $data['content']
    );

    if (!empty($_FILES['image']['name'])) {
        $file_dir = date("Ymd", time());
        $file = '../upload/' . $file_dir;
        if (!file_exists($file)) {
            mkdir($file, 777, true);
        }

        $file_type = strrchr($_FILES['image']['name'], '.');
        $file_allow_type = array('.jpg', '.png', '.jpeg', '.gif');
        if (!in_array(strtolower($file_type), $file_allow_type)) {
            echo "<script>alert('对不起，你上传的不是图片');</script>";
            die();
        }
        $filename = $_FILES['image']['tmp_name'];
        $savefile = $file . '/' . time() . rand(1111, 9999) . $file_type;
        move_uploaded_file($filename, $savefile);
        $insert['image'] = $savefile;
    }

    $result = add('wen', $insert);
    if ($result) {
        Logger::info('文章发布成功', ['admin_id' => $_SESSION['user']['id'], 'title' => $data['title']]);
        echo "<script>alert('发布文章成功');location='index.php'</script>";
    } else {
        echo "<script>alert('发布文章失败');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>发布文章 - News Platform</title>
  <link rel="stylesheet" href="layui/css/layui.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header custom-header">
    <div class="layui-logo">
      <i class="fas fa-newspaper"></i>
      <span>News Platform</span>
    </div>
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="dashboard.php"><i class="fas fa-chart-line"></i> 仪表盘</a></li>
      <li class="layui-nav-item"><a href="index.php"><i class="fas fa-list"></i> 文章管理</a></li>
    </ul>
    <?php include_once("nav.php"); ?>
  </div>

  <div class="layui-side custom-side">
    <div class="layui-side-scroll">
      <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;"><i class="fas fa-gauge"></i> 控制台</a>
          <dl class="layui-nav-child">
            <dd><a href="dashboard.php"><i class="fas fa-chart-pie"></i> 仪表盘</a></dd>
            <dd><a href="index.php"><i class="fas fa-newspaper"></i> 文章列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;"><i class="fas fa-edit"></i> 文章管理</a>
          <dl class="layui-nav-child">
            <dd><a href="caozuo.php"><i class="fas fa-cog"></i> 操作文章</a></dd>
            <dd><a href="fabu.php" class="layui-this"><i class="fas fa-plus"></i> 发布文章</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="fas fa-users"></i> 用户管理</a>
          <dl class="layui-nav-child">
            <dd><a href="i-user.php"><i class="fas fa-user"></i> 用户列表</a></dd>
            <dd><a href="user.php"><i class="fas fa-user-shield"></i> 管理员列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="fas fa-cogs"></i> 系统管理</a>
          <dl class="layui-nav-child">
            <dd><a href="settings.php"><i class="fas fa-sliders-h"></i> 系统设置</a></dd>
            <dd><a href="profile.php"><i class="fas fa-user-circle"></i> 个人中心</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>

  <div class="layui-body custom-body">
    <div class="form-wrapper">
      <div class="form-title">
        <i class="fas fa-plus-circle"></i> 发布新文章
      </div>
      
      <form class="layui-form" action="fabu.php" method="post" enctype="multipart/form-data">
        <div class="layui-form-item">
          <label class="layui-form-label">文章作者</label>
          <div class="layui-input-block">
            <input type="text" name="zuozhe" required lay-verify="required" placeholder="请输入作者名称" autocomplete="off" class="layui-input">
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label">文章标题</label>
          <div class="layui-input-block">
            <input type="text" name="title" required lay-verify="required" placeholder="请输入文章标题" autocomplete="off" class="layui-input">
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label">文章简介</label>
          <div class="layui-input-block">
            <input type="text" name="jianjie" required lay-verify="required" placeholder="请输入文章简介" autocomplete="off" class="layui-input">
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label">展示图片</label>
          <div class="layui-input-block">
            <button type="button" class="layui-btn layui-btn-primary" id="test1">
              <i class="fas fa-upload"></i> 选择图片
            </button>
            <span class="upload-tip">支持 JPG、PNG 格式，建议尺寸 800x600</span>
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label">文章类别</label>
          <div class="layui-input-block">
            <select name="city" lay-verify="required" class="form-select">
              <option value="">请选择分类</option>
              <option value="政治">政治</option>
              <option value="经济">经济</option>
              <option value="法律">法律</option>
              <option value="军事">军事</option>
              <option value="科技">科技</option>
              <option value="文教">文教</option>
              <option value="体育">体育</option>
              <option value="社会">社会</option>
              <option value="文化">文化</option>
              <option value="环保">环保</option>
              <option value="农业">农业</option>
            </select>
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label">发布时间</label>
          <div class="layui-input-block">
            <input type="text" name="regtime" class="layui-input" id="testtime" placeholder="选择发布时间，留空则为当前时间">
          </div>
        </div>
        
        <div class="layui-form-item layui-form-text">
          <label class="layui-form-label">文章内容</label>
          <div class="layui-input-block">
            <textarea id="demo" name="content" style="display: none;"></textarea>
          </div>
        </div>
        
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn btn-primary" type="submit" lay-submit lay-filter="formDemo">
              <i class="fas fa-paper-plane"></i> 发布文章
            </button>
            <button type="reset" class="layui-btn layui-btn-primary">
              <i class="fas fa-redo"></i> 重置
            </button>
            <a href="index.php" class="layui-btn layui-btn-secondary">
              <i class="fas fa-arrow-left"></i> 返回列表
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="layui-footer custom-footer">
    <div class="footer-content">
      <span>© <?php echo date('Y'); ?> News Platform v<?php echo APP_VERSION; ?></span>
      <span class="footer-divider">|</span>
      <span>Powered by PHP <?php echo PHP_VERSION; ?></span>
    </div>
  </div>
</div>
<script src="layui/layui.all.js"></script>
<script>
layui.use('element', function(){
  var element = layui.element;
});

layui.use('layedit', function(){
  var layedit = layui.layedit;
  layedit.build('demo', {
    height: 400
  });
});

layui.use('laydate', function(){
  var laydate = layui.laydate;
  laydate.render({
    elem: '#testtime'
    ,type: 'datetime'
  });
});

layui.use('upload', function(){
  var upload = layui.upload;
  var uploadInst = upload.render({
    elem: '#test1'
    ,url: 'ajax.php?action=upload'
    ,done: function(res){
      if(res.code == 0){
        layer.msg('上传成功');
      } else {
        layer.msg('上传失败');
      }
    }
    ,error: function(){
      layer.msg('上传异常');
    }
  });
});
</script>
</body>
</html>
