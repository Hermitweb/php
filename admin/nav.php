<?php

if(!session_id()){session_start();}


?>
<?php if(empty($_SESSION['user'])){ ?>
	<ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="images/a.jpg" class="layui-nav-img">
          <?php echo "---";?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="user_x.php">基本资料</a></dd>
          <dd><a href="log/login.php">登录</a></dd>
        </dl>
      </li>  
    </ul>
    <?php } else { ?>
	<ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="images/a.jpg" class="layui-nav-img">
          <?php echo $_SESSION['user']['name'];?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="user_x.php">基本资料</a></dd>
          <dd><a href="blogout.php">退出</a></dd>
        </dl>
      </li>  
    </ul>
    <?php } ?>
