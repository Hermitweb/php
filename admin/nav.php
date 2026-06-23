<?php
if(session_status() === PHP_SESSION_NONE){session_start();}
?>
<?php if(empty($_SESSION['user'])){ ?>
	<ul class="layui-nav layui-layout-right custom-nav-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="images/user.svg" class="layui-nav-img custom-nav-avatar">
          <span class="nav-username">访客</span>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="user_x.php"><i class="fas fa-user"></i> 基本资料</a></dd>
          <dd><a href="log/login.php"><i class="fas fa-sign-in-alt"></i> 登录</a></dd>
        </dl>
      </li>  
    </ul>
    <?php } else { ?>
	<ul class="layui-nav layui-layout-right custom-nav-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <div class="nav-user-info">
            <img src="images/user.svg" class="layui-nav-img custom-nav-avatar">
            <span class="nav-username"><?php echo $_SESSION['user']['name'];?></span>
          </div>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="profile.php"><i class="fas fa-user"></i> 个人中心</a></dd>
          <dd><a href="settings.php"><i class="fas fa-cog"></i> 系统设置</a></dd>
          <dd class="layui-nav-divider"></dd>
          <dd><a href="blogout.php"><i class="fas fa-sign-out-alt"></i> 退出登录</a></dd>
        </dl>
      </li>  
    </ul>
    <?php } ?>
