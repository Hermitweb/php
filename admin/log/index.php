<?php
/**
 * 日志目录入口重定向
 * 避免访问 /log/index.php 时出现404错误
 */

header('Location: ../index.php');
exit;
?>