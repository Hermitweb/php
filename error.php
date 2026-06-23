<?php
/**
 * 统一错误页面 v1.2
 */
$code = http_response_code() ?: 500;
$errorMessages = [
    400 => '请求错误',
    401 => '未授权',
    403 => '禁止访问',
    404 => '页面未找到',
    500 => '服务器内部错误',
    503 => '服务不可用'
];
$title = $errorMessages[$code] ?? '发生错误';
$debug = getenv('APP_DEBUG') === 'true';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $code; ?> - <?php echo htmlspecialchars($title); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .error-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .error-code {
            font-size: 96px;
            font-weight: 700;
            color: #667eea;
            line-height: 1;
            margin-bottom: 20px;
        }
        .error-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 16px;
        }
        .error-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #f5f5f5;
            color: #333;
        }
        .btn-secondary:hover {
            background: #e8e8e8;
        }
        .error-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        .debug-info {
            margin-top: 30px;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: left;
            font-family: monospace;
            font-size: 12px;
            color: #666;
            word-break: break-all;
        }
        @media (max-width: 480px) {
            .error-container { padding: 40px 24px; }
            .error-code { font-size: 72px; }
            .error-title { font-size: 20px; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <?php if ($code === 404): ?>
                🔍
            <?php elseif ($code === 403): ?>
                🚫
            <?php elseif ($code === 401): ?>
                🔐
            <?php elseif ($code >= 500): ?>
                ⚠️
            <?php else: ?>
                ❓
            <?php endif; ?>
        </div>
        <div class="error-code"><?php echo $code; ?></div>
        <h1 class="error-title"><?php echo htmlspecialchars($title); ?></h1>
        <p class="error-message">
            <?php
            switch ($code) {
                case 404: echo '抱歉，您访问的页面不存在或已被移除。'; break;
                case 403: echo '抱歉，您没有权限访问此页面。'; break;
                case 401: echo '请先登录后再访问此页面。'; break;
                case 500: echo '抱歉，服务器出现了一些问题，请稍后再试。'; break;
                case 503: echo '服务暂时不可用，请稍后再试。'; break;
                default: echo '抱歉，发生了未知错误。';
            }
            ?>
        </p>
        <div class="error-actions">
            <a href="/" class="btn btn-primary">返回首页</a>
            <a href="javascript:history.back()" class="btn btn-secondary">返回上一页</a>
        </div>
        <?php if ($debug && !empty($message)): ?>
        <div class="debug-info">
            <strong>调试信息：</strong><br>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
