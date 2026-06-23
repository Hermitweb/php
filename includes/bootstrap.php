<?php
/**
 * 统一初始化文件 v1.2
 * 整合安全、日志、错误处理等功能
 */

require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/Logger.php';
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/ErrorHandler.php';

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

// mbstring扩展兼容（当mbstring未安装时使用）
if (!function_exists('mb_substr')) {
    function mb_substr($string, $start, $length = null, $encoding = 'UTF-8') {
        $strlen = strlen($string);
        $start = (int)$start;
        $result = '';
        
        if ($start < 0) {
            $start = $strlen + $start;
            if ($start < 0) $start = 0;
        }
        
        if ($length === null) {
            $length = $strlen - $start;
        } else {
            $length = (int)$length;
            if ($length < 0) {
                $length = $strlen - $start + $length;
                if ($length < 0) $length = 0;
            }
        }
        
        $i = 0;
        $j = 0;
        while ($i < $strlen && $j < $length) {
            $char = ord($string[$i]);
            if ($char <= 0x7F) {
                $bytes = 1;
            } elseif ($char <= 0xDF) {
                $bytes = 2;
            } elseif ($char <= 0xEF) {
                $bytes = 3;
            } else {
                $bytes = 4;
            }
            
            if ($i >= $start) {
                $result .= substr($string, $i, $bytes);
                $j++;
            }
            
            $i += $bytes;
        }
        
        return $result;
    }
}

// 加载数据库配置
require_once __DIR__ . '/../mock_db.php';

// 定义项目常量
if (!defined('APP_VERSION')) {
    define('APP_VERSION', '1.2.0');
}
if (!defined('APP_NAME')) {
    define('APP_NAME', 'News Platform');
}
