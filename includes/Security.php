<?php
/**
 * 安全工具类 v1.2
 * 提供XSS过滤、CSRF防护、输入验证等安全功能
 */

class Security {
    /**
     * 清理字符串，防止XSS攻击
     * @param string $str 输入字符串
     * @return string 清理后的字符串
     */
    public static function clean($str) {
        if (is_array($str)) {
            return array_map([self::class, 'clean'], $str);
        }
        $str = trim($str);
        $str = stripslashes($str);
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * 清理HTML内容（保留部分标签）
     * @param string $html HTML内容
     * @return string 清理后的HTML
     */
    public static function cleanHtml($html) {
        // 移除危险的标签和属性
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $html = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', '', $html);
        $html = preg_replace('/on\w+="[^"]*"/i', '', $html);
        $html = preg_replace('/javascript:/i', '', $html);
        return $html;
    }

    /**
     * 生成CSRF Token
     * @return string Token
     */
    public static function generateCsrfToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * 验证CSRF Token
     * @param string $token 要验证的Token
     * @return bool 验证结果
     */
    public static function verifyCsrfToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * 获取CSRF Token的HTML input元素
     * @return string HTML代码
     */
    public static function csrfField() {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * 验证CSRF（用于POST请求）
     */
    public static function validateCsrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if (!self::verifyCsrfToken($token)) {
                http_response_code(403);
                die('CSRF验证失败，请求被拒绝');
            }
        }
    }

    /**
     * 验证邮箱
     * @param string $email
     * @return bool
     */
    public static function isEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * 验证手机号（中国大陆）
     * @param string $phone
     * @return bool
     */
    public static function isPhone($phone) {
        return preg_match('/^1[3-9]\d{9}$/', $phone) === 1;
    }

    /**
     * 验证用户名（字母数字下划线，3-20位）
     * @param string $username
     * @return bool
     */
    public static function isUsername($username) {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username) === 1;
    }

    /**
     * 验证密码强度
     * @param string $password
     * @return array ['valid' => bool, 'message' => string]
     */
    public static function validatePassword($password) {
        if (strlen($password) < 6) {
            return ['valid' => false, 'message' => '密码长度不能少于6位'];
        }
        if (strlen($password) > 30) {
            return ['valid' => false, 'message' => '密码长度不能超过30位'];
        }
        return ['valid' => true, 'message' => '密码强度合格'];
    }

    /**
     * 密码加密
     * @param string $password
     * @return string
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 验证密码
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verifyPassword($password, $hash) {
        // 兼容旧的MD5加密方式
        if (strlen($hash) === 32 && ctype_xdigit($hash)) {
            return md5($password) === $hash;
        }
        return password_verify($password, $hash);
    }

    /**
     * 安全的Session配置
     */
    public static function secureSession() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.gc_maxlifetime', 7200);
            session_start();
            // 防止Session固定攻击
            if (empty($_SESSION['initialized'])) {
                session_regenerate_id(true);
                $_SESSION['initialized'] = true;
            }
        }
    }

    /**
     * 检查是否登录
     * @return bool
     */
    public static function isLoggedIn() {
        self::secureSession();
        return !empty($_SESSION['user']);
    }

    /**
     * 要求登录（未登录则跳转）
     * @param string $redirect 登录后跳转的URL
     */
    public static function requireLogin($redirect = 'log/login.php') {
        // 如果是登录页面，跳过检查（避免重定向循环）
        $currentPage = basename($_SERVER['SCRIPT_NAME']);
        if ($currentPage === 'login.php') {
            return;
        }

        if (!self::isLoggedIn()) {
            // 获取当前脚本的目录
            $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
            // 构建绝对路径的重定向URL
            $redirectUrl = rtrim($scriptDir, '/') . '/' . ltrim($redirect, '/');
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    /**
     * 限制请求频率（简单的防刷机制）
     * @param string $key 限制的key
     * @param int $maxRequests 最大请求数
     * @param int $timeWindow 时间窗口（秒）
     * @return bool 是否允许请求
     */
    public static function rateLimit($key, $maxRequests = 60, $timeWindow = 60) {
        self::secureSession();
        $sessionKey = 'rate_limit_' . md5($key);
        $now = time();

        if (!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = ['count' => 1, 'start' => $now];
            return true;
        }

        $data = $_SESSION[$sessionKey];
        if ($now - $data['start'] > $timeWindow) {
            $_SESSION[$sessionKey] = ['count' => 1, 'start' => $now];
            return true;
        }

        if ($data['count'] >= $maxRequests) {
            return false;
        }

        $_SESSION[$sessionKey]['count']++;
        return true;
    }

    /**
     * 获取客户端真实IP
     * @return string
     */
    public static function getClientIp() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ips[0]);
        }
        return $ip;
    }
}
