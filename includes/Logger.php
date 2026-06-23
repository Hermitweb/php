<?php
/**
 * 日志记录类 v1.2
 * 提供统一的日志记录功能
 */

class Logger {
    const LEVEL_INFO = 'INFO';
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_ERROR = 'ERROR';
    const LEVEL_DEBUG = 'DEBUG';
    const LEVEL_SECURITY = 'SECURITY';

    private static $logDir = null;
    private static $maxFileSize = 10485760; // 10MB

    /**
     * 获取日志目录
     */
    private static function getLogDir() {
        if (self::$logDir === null) {
            $dir = __DIR__ . '/../logs';
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            self::$logDir = $dir;
        }
        return self::$logDir;
    }

    /**
     * 写入日志
     * @param string $level 日志级别
     * @param string $message 日志消息
     * @param array $context 上下文信息
     */
    public static function log($level, $message, $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
        $user = $_SESSION['user']['name'] ?? 'guest';
        $uri = $_SERVER['REQUEST_URI'] ?? '';

        $logEntry = sprintf(
            "[%s] [%s] [IP:%s] [User:%s] [URI:%s] %s",
            $timestamp,
            $level,
            $ip,
            $user,
            $uri,
            $message
        );

        if (!empty($context)) {
            $logEntry .= ' | Context: ' . json_encode($context, JSON_UNESCAPED_UNICODE);
        }

        $logEntry .= PHP_EOL;

        // 按日期分割日志文件
        $logFile = self::getLogDir() . '/' . date('Y-m-d') . '.log';

        // 检查文件大小，超过则轮转
        if (file_exists($logFile) && filesize($logFile) > self::$maxFileSize) {
            $backupFile = $logFile . '.' . date('H-i-s') . '.bak';
            @rename($logFile, $backupFile);
        }

        @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * 记录信息日志
     */
    public static function info($message, $context = []) {
        self::log(self::LEVEL_INFO, $message, $context);
    }

    /**
     * 记录警告日志
     */
    public static function warning($message, $context = []) {
        self::log(self::LEVEL_WARNING, $message, $context);
    }

    /**
     * 记录错误日志
     */
    public static function error($message, $context = []) {
        self::log(self::LEVEL_ERROR, $message, $context);
    }

    /**
     * 记录调试日志
     */
    public static function debug($message, $context = []) {
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            self::log(self::LEVEL_DEBUG, $message, $context);
        }
    }

    /**
     * 记录安全相关日志
     */
    public static function security($message, $context = []) {
        self::log(self::LEVEL_SECURITY, $message, $context);
    }
}
