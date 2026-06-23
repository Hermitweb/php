<?php
/**
 * 统一响应处理类 v1.2
 * 提供统一的API响应格式
 */

class Response {
    const SUCCESS = 0;
    const ERROR = 1;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const SERVER_ERROR = 500;

    /**
     * JSON响应
     * @param int $code 状态码
     * @param string $message 消息
     * @param mixed $data 数据
     */
    public static function json($code = 0, $message = 'success', $data = null) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 成功响应
     */
    public static function success($data = null, $message = '操作成功') {
        self::json(self::SUCCESS, $message, $data);
    }

    /**
     * 错误响应
     */
    public static function error($message = '操作失败', $code = self::ERROR, $data = null) {
        self::json($code, $message, $data);
    }

    /**
     * 页面跳转
     * @param string $url 目标URL
     * @param string $message 提示信息
     */
    public static function redirect($url, $message = '') {
        if ($message) {
            $_SESSION['flash_message'] = $message;
        }
        header('Location: ' . $url);
        exit;
    }

    /**
     * 显示提示信息并跳转
     */
    public static function alert($message, $url = null, $type = 'info') {
        $js = "alert('" . addslashes($message) . "');";
        if ($url) {
            $js .= "location='" . $url . "';";
        }
        echo "<script>" . $js . "</script>";
        exit;
    }

    /**
     * 获取Flash消息并清除
     */
    public static function getFlash() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        return $message;
    }
}
