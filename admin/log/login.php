<?php
/**
 * 管理员登录页面 v1.2
 * 增强安全性：CSRF防护、登录尝试限制、密码加密
 */

require_once __DIR__ . '/../../includes/bootstrap.php';

// 处理登录请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 频率限制：每分钟最多10次登录尝试
    if (!Security::rateLimit('login_attempt', 10, 60)) {
        Logger::security('登录尝试频率过高', ['ip' => Security::getClientIp()]);
        Response::alert('登录尝试过于频繁，请稍后再试', 'login.php');
    }

    // CSRF验证
    $token = $_POST['csrf_token'] ?? '';
    if (!Security::verifyCsrfToken($token)) {
        Logger::security('CSRF验证失败', ['ip' => Security::getClientIp()]);
        Response::alert('安全验证失败，请刷新页面重试', 'login.php');
    }

    $uid = trim($_POST['uid'] ?? '');
    $password = $_POST['password'] ?? '';

    // 输入验证
    if (empty($uid) || empty($password)) {
        Logger::security('登录尝试：账号或密码为空', ['uid' => $uid]);
        Response::alert('请输入账号和密码', 'login.php');
    }

    if (!Security::isUsername($uid)) {
        Logger::security('登录尝试：账号格式错误', ['uid' => $uid]);
        Response::alert('账号格式不正确', 'login.php');
    }

    // 查询管理员
    $kuid = getOne('admin', "uid='" . Security::clean($uid) . "'");

    if (!$kuid) {
        Logger::security('登录尝试：账号不存在', ['uid' => $uid, 'ip' => Security::getClientIp()]);
        // 故意延迟，阻止暴力破解
        usleep(500000);
        Response::alert('账号或密码错误', 'login.php');
    }

    // 检查账号状态
    if ($kuid['stutas'] != 1) {
        Logger::security('登录尝试：账号已禁用', ['uid' => $uid, 'admin_id' => $kuid['id']]);
        Response::alert('该账号已失效，请联系管理员', 'login.php');
    }

    // 验证密码（兼容password_hash和旧MD5）
    if (!Security::verifyPassword($password, $kuid['password'])) {
        Logger::security('登录尝试：密码错误', ['uid' => $uid, 'ip' => Security::getClientIp()]);
        usleep(500000);
        Response::alert('账号或密码错误', 'login.php');
    }

    // 登录成功
    // 重新生成Session ID防止固定攻击
    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id' => $kuid['id'],
        'name' => $kuid['name'],
        'uid' => $kuid['uid'],
        'login_time' => time()
    ];

    // 记录登录日志
    Logger::info('管理员登录成功', [
        'admin_id' => $kuid['id'],
        'uid' => $kuid['uid'],
        'ip' => Security::getClientIp()
    ]);

    // 跳转到首页
    Response::alert('登录成功', '../index.php');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录 - <?php echo APP_NAME; ?></title>
    <link href="style/authority/login_css.css" rel="stylesheet" type="text/css">
    <style>
        .error-tip {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .input-error { border-color: #e74c3c !important; }
        .login-loading {
            display: none;
            text-align: center;
            margin-top: 10px;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div id="login_center">
        <div id="login_area">
            <div id="login_box">
                <div id="login_form">
                    <form id="submitForm" method="post" autocomplete="off">
                        <?php echo Security::csrfField(); ?>
                        <div id="login_tip2">
                            <span id="login_err" class="sty_txt2"><?php echo Response::getFlash(); ?></span>
                        </div>
                        <div>
                            <label for="name">账&nbsp;&nbsp;&nbsp;&nbsp;号：</label>
                            <input type="text" name="uid" class="username" id="name"
                                   required minlength="3" maxlength="20"
                                   pattern="[a-zA-Z0-9_]{3,20}"
                                   placeholder="请输入账号">
                            <div class="error-tip" id="uid-error">账号格式：3-20位字母数字下划线</div>
                        </div>
                        <div>
                            <label for="pwd">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
                            <input type="password" name="password" class="pwd" id="pwd"
                                   required minlength="6" maxlength="30"
                                   placeholder="请输入密码">
                            <div class="error-tip" id="pwd-error">密码长度：6-30位</div>
                        </div>
                        <div id="btn_area">
                            <button type="submit" class="login_btn" id="login_sub">登&nbsp;&nbsp;录</button>
                            <button type="button" class="login_btn" id="login_ret">注&nbsp;&nbsp;册</button>
                        </div>
                        <div class="login-loading" id="loading">登录中...</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-1.7.1.js"></script>
    <script>
    $(document).ready(function() {
        // 注册按钮
        $("#login_ret").click(function() {
            window.location = "reg.php";
        });

        // 实时表单验证
        $("#name").on('input', function() {
            var val = $(this).val();
            if (val && !/^[a-zA-Z0-9_]{3,20}$/.test(val)) {
                $("#uid-error").show();
                $(this).addClass('input-error');
            } else {
                $("#uid-error").hide();
                $(this).removeClass('input-error');
            }
        });

        $("#pwd").on('input', function() {
            var val = $(this).val();
            if (val && (val.length < 6 || val.length > 30)) {
                $("#pwd-error").show();
                $(this).addClass('input-error');
            } else {
                $("#pwd-error").hide();
                $(this).removeClass('input-error');
            }
        });

        // 表单提交
        $("#submitForm").submit(function(e) {
            var uid = $("#name").val().trim();
            var pwd = $("#pwd").val();

            if (!uid || !pwd) {
                e.preventDefault();
                alert('请输入账号和密码');
                return false;
            }

            if (!/^[a-zA-Z0-9_]{3,20}$/.test(uid)) {
                e.preventDefault();
                alert('账号格式不正确');
                return false;
            }

            if (pwd.length < 6 || pwd.length > 30) {
                e.preventDefault();
                alert('密码长度应为6-30位');
                return false;
            }

            // 显示加载状态
            $("#login_sub").prop('disabled', true).text('登录中...');
            $("#loading").show();
            return true;
        });
    });
    </script>
</body>
</html>
