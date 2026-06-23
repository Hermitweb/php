<?php
include_once("int.php");
Security::requireLogin('log/login.php');

$id = $_GET['id'] ?? '';
if (empty($id) || !is_numeric($id)) {
    Response::alert('参数错误', 'caozuo.php');
}

$wen = getOne('wen', $where=" id=$id ");
if (!$wen) {
    Response::alert('文章不存在', 'caozuo.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    
    $insert = array(
        'user' => $data['zuozhe'],
        'title' => $data['title'],
        'jianjie' => $data['jianjie'],
        'leibie' => $data['city'],
        'regtime' => $data['regtime'],
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
            Response::alert('对不起，你上传的不是图片', 'xiugai.php?id=' . $id);
        }
        $filename = $_FILES['image']['tmp_name'];
        $savefile = $file . '/' . time() . rand(1111, 9999) . $file_type;
        move_uploaded_file($filename, $savefile);
        $insert['image'] = $savefile;
    }

    $result = update('wen', $insert, $where="id=$id");
    if ($result) {
        Logger::info('文章编辑成功', ['admin_id' => $_SESSION['user']['id'], 'article_id' => $id]);
        Response::alert('编辑文章成功', 'caozuo.php');
    } else {
        Response::alert('编辑文章失败', 'xiugai.php?id=' . $id);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>编辑文章 - News Platform</title>
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
        <li class="layui-nav-item">
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
            <dd><a href="fabu.php"><i class="fas fa-plus"></i> 发布文章</a></dd>
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
        <i class="fas fa-edit"></i> 编辑文章
      </div>
      
      <form class="layui-form" action="xiugai.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div class="layui-form-item">
          <label class="layui-form-label"><i class="fas fa-user"></i> 文章作者</label>
          <div class="layui-input-block">
            <input type="text" name="zuozhe" required lay-verify="required" placeholder="请输入作者名称" autocomplete="off" class="layui-input" value="<?php echo htmlspecialchars($wen['user']); ?>">
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label"><i class="fas fa-file-alt"></i> 文章标题</label>
          <div class="layui-input-block">
            <input type="text" name="title" required lay-verify="required" placeholder="请输入文章标题" autocomplete="off" class="layui-input" value="<?php echo htmlspecialchars($wen['title']); ?>">
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label"><i class="fas fa-align-left"></i> 文章简介</label>
          <div class="layui-input-block">
            <input type="text" name="jianjie" required lay-verify="required" placeholder="请输入文章简介" autocomplete="off" class="layui-input" value="<?php echo htmlspecialchars($wen['jianjie']); ?>">
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label"><i class="fas fa-image"></i> 展示图片</label>
          <div class="layui-input-block">
            <?php if ($wen['image']): ?>
            <div class="image-preview">
              <img src="<?php echo htmlspecialchars($wen['image']); ?>" alt="当前图片" style="max-width: 200px; max-height: 150px; border-radius: 8px; margin-bottom: 12px;">
              <p style="color: #6c757d; font-size: 13px;">当前图片</p>
            </div>
            <?php endif; ?>
            <button type="button" class="layui-btn layui-btn-primary" id="test1">
              <i class="fas fa-upload"></i> 选择图片
            </button>
            <span class="upload-tip" style="color: #adb5bd; font-size: 13px; margin-left: 12px;">支持 JPG、PNG 格式，建议尺寸 800x600</span>
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label"><i class="fas fa-tag"></i> 文章类别</label>
          <div class="layui-input-block">
            <select name="city" lay-verify="required" class="form-select">
              <option value="">请选择分类</option>
              <option value="政治" <?php echo $wen['leibie'] == '政治' ? 'selected' : ''; ?>>政治</option>
              <option value="经济" <?php echo $wen['leibie'] == '经济' ? 'selected' : ''; ?>>经济</option>
              <option value="法律" <?php echo $wen['leibie'] == '法律' ? 'selected' : ''; ?>>法律</option>
              <option value="军事" <?php echo $wen['leibie'] == '军事' ? 'selected' : ''; ?>>军事</option>
              <option value="科技" <?php echo $wen['leibie'] == '科技' ? 'selected' : ''; ?>>科技</option>
              <option value="文教" <?php echo $wen['leibie'] == '文教' ? 'selected' : ''; ?>>文教</option>
              <option value="体育" <?php echo $wen['leibie'] == '体育' ? 'selected' : ''; ?>>体育</option>
              <option value="社会" <?php echo $wen['leibie'] == '社会' ? 'selected' : ''; ?>>社会</option>
              <option value="文化" <?php echo $wen['leibie'] == '文化' ? 'selected' : ''; ?>>文化</option>
              <option value="环保" <?php echo $wen['leibie'] == '环保' ? 'selected' : ''; ?>>环保</option>
              <option value="农业" <?php echo $wen['leibie'] == '农业' ? 'selected' : ''; ?>>农业</option>
            </select>
          </div>
        </div>
        
        <div class="layui-form-item">
          <label class="layui-form-label"><i class="fas fa-calendar"></i> 发布时间</label>
          <div class="layui-input-block">
            <input type="text" name="regtime" class="layui-input" id="testtime" value="<?php echo htmlspecialchars($wen['regtime']); ?>">
          </div>
        </div>
        
        <div class="layui-form-item layui-form-text">
          <label class="layui-form-label"><i class="fas fa-file-text"></i> 文章内容</label>
          <div class="layui-input-block">
            <textarea id="demo" name="content" style="display: none;"><?php echo htmlspecialchars($wen['content']); ?></textarea>
          </div>
        </div>
        
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn btn-primary" type="submit" lay-submit lay-filter="formDemo">
              <i class="fas fa-save"></i> 保存修改
            </button>
            <button type="reset" class="layui-btn btn-secondary">
              <i class="fas fa-redo"></i> 重置
            </button>
            <a href="caozuo.php" class="layui-btn btn-outline">
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