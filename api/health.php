<?php
/**
 * 健康检查接口 v1.2
 * 用于监控服务状态
 */

require_once __DIR__ . '/../includes/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$status = [
    'status' => 'ok',
    'version' => APP_VERSION,
    'timestamp' => time(),
    'datetime' => date('Y-m-d H:i:s'),
    'checks' => []
];

// 检查PHP版本
$phpCheck = [
    'name' => 'PHP Version',
    'status' => version_compare(PHP_VERSION, '7.4.0', '>=') ? 'ok' : 'warning',
    'value' => PHP_VERSION
];
$status['checks'][] = $phpCheck;

// 检查必要扩展
$requiredExtensions = ['mysqli', 'pdo', 'pdo_mysql', 'json', 'mbstring'];
foreach ($requiredExtensions as $ext) {
    $status['checks'][] = [
        'name' => "Extension: $ext",
        'status' => extension_loaded($ext) ? 'ok' : 'error',
        'value' => extension_loaded($ext) ? 'loaded' : 'not loaded'
    ];
}

// 检查目录权限
$directories = [
    'logs' => __DIR__ . '/../logs',
    'uploads' => __DIR__ . '/../uploads',
];
foreach ($directories as $name => $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    $status['checks'][] = [
        'name' => "Directory: $name",
        'status' => is_writable($dir) ? 'ok' : 'error',
        'value' => is_writable($dir) ? 'writable' : 'not writable'
    ];
}

// 检查Session
$status['checks'][] = [
    'name' => 'Session',
    'status' => 'ok',
    'value' => session_status() === PHP_SESSION_ACTIVE ? 'active' : 'inactive'
];

// 确定整体状态
$hasError = false;
$hasWarning = false;
foreach ($status['checks'] as $check) {
    if ($check['status'] === 'error') $hasError = true;
    if ($check['status'] === 'warning') $hasWarning = true;
}

if ($hasError) {
    $status['status'] = 'error';
    http_response_code(503);
} elseif ($hasWarning) {
    $status['status'] = 'warning';
}

echo json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
