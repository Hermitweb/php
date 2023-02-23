<?php
session_start();
?>
<li class="navbar-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            个人中心
        </a>
        <ul class="dropdown-menu navbar-item">
        	<?php if(empty($_SESSION['user'])) { ?>
            <li class="nav-link"><a href="user/blog.php">登录</a></li>
            <li class="nav-link"><a href="user/reg.php">注册</a></li>
        	<?php } else { ?>
        	<li class="nav-link">你好！,<br> <?php echo $_SESSION['user']; ?></li>
            <li class="nav-link"><a href="blogout.php">退出</a></li>
        	<?php } ?>
        </ul>
</li>