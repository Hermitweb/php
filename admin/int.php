<?php
/**
 * 数据库初始化文件 v1.2
 * 使用统一的引导程序
 */

require_once __DIR__ . '/../includes/bootstrap.php';

// 兼容旧代码的变量定义
if (!defined('PRE')) {
    define('PRE', 'tb_');
}

Logger::debug('数据库初始化文件加载', ['version' => APP_VERSION]);
