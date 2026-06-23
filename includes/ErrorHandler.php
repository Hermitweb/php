<?php
/**
 * 错误处理器 v1.2
 * 统一处理异常和错误
 */

class ErrorHandler {
    /**
     * 注册错误处理
     */
    public static function register() {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    /**
     * 处理异常
     */
    public static function handleException($exception) {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        if (class_exists('Logger')) {
            Logger::error('未捕获异常: ' . $message, [
                'file' => $file,
                'line' => $line,
                'trace' => $exception->getTraceAsString()
            ]);
        }

        self::renderError(500, '系统错误', $message);
    }

    /**
     * 处理错误
     */
    public static function handleError($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $errorTypes = [
            E_ERROR => 'ERROR',
            E_WARNING => 'WARNING',
            E_PARSE => 'PARSE',
            E_NOTICE => 'NOTICE',
            E_CORE_ERROR => 'CORE_ERROR',
            E_CORE_WARNING => 'CORE_WARNING',
            E_COMPILE_ERROR => 'COMPILE_ERROR',
            E_COMPILE_WARNING => 'COMPILE_WARNING',
            E_USER_ERROR => 'USER_ERROR',
            E_USER_WARNING => 'USER_WARNING',
            E_USER_NOTICE => 'USER_NOTICE',
        ];

        $type = $errorTypes[$errno] ?? 'UNKNOWN';

        if (class_exists('Logger')) {
            Logger::error("PHP {$type}: {$errstr}", [
                'file' => $errfile,
                'line' => $errline
            ]);
        }

        // 对于严重错误，停止执行
        if (in_array($errno, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
            self::renderError(500, '系统错误', $errstr);
            return true;
        }

        return true;
    }

    /**
     * 处理致命错误
     */
    public static function handleShutdown() {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR])) {
            if (class_exists('Logger')) {
                Logger::error('致命错误: ' . $error['message'], [
                    'file' => $error['file'],
                    'line' => $error['line']
                ]);
            }
            self::renderError(500, '系统错误', $error['message']);
        }
    }

    /**
     * 渲染错误页面
     */
    public static function renderError($code, $title, $message = '') {
        if (!headers_sent()) {
            http_response_code($code);
        }

        // AJAX请求返回JSON
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'code' => $code,
                'message' => $title,
                'data' => ['error' => $message]
            ]);
            exit;
        }

        // 显示错误页面
        $errorPage = __DIR__ . '/../error.php';
        if (file_exists($errorPage)) {
            include $errorPage;
        } else {
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' . htmlspecialchars($title) . '</title></head>';
            echo '<body style="font-family: Arial; text-align: center; padding: 50px;">';
            echo '<h1 style="color: #e74c3c;">' . htmlspecialchars($title) . '</h1>';
            if ($message && getenv('APP_DEBUG') === 'true') {
                echo '<p style="color: #666;">' . htmlspecialchars($message) . '</p>';
            }
            echo '<p><a href="/">返回首页</a></p>';
            echo '</body></html>';
        }
        exit;
    }
}

// 注册错误处理
ErrorHandler::register();
