<?php
/**
 * 统一初始化文件 v1.2
 * 整合安全、日志、错误处理等功能
 */

require_once __DIR__ . '/../includes/Security.php';
require_once __DIR__ . '/../includes/Logger.php';
require_once __DIR__ . '/../includes/Response.php';
require_once __DIR__ . '/../includes/ErrorHandler.php';

// 启动安全Session
Security::secureSession();

// 设置错误显示（生产环境应关闭）
$isDebug = getenv('APP_DEBUG') === 'true' || (defined('DEBUG_MODE') && DEBUG_MODE);
if ($isDebug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

// 设置时区
date_default_timezone_set('Asia/Shanghai');

// 设置字符编码
header('Content-Type: text/html; charset=utf-8');

// 防止XSS攻击的HTTP头
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// 加载数据库配置
require_once __DIR__ . '/../mock_db.php';

// 定义项目常量
if (!defined('APP_VERSION')) {
    define('APP_VERSION', '1.2.0');
}
if (!defined('APP_NAME')) {
    define('APP_NAME', 'News Platform');
}
