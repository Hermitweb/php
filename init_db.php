<?php
// 数据库初始化脚本
$host = 'localhost';
$user = 'root';
$password = '';
$socket = '/var/run/mysqld/mysqld.sock';
$dbname = 'db_news';

// 尝试连接MySQL（使用空密码）
$link = mysqli_connect($host, $user, $password, '', 3306, $socket);

if (!$link) {
    echo "连接失败: " . mysqli_connect_error() . "\n";
    echo "尝试使用auth_socket连接...\n";
    
    // 尝试其他方法
    $link = mysqli_connect(null, $user, null, '', 0, $socket);
    if (!$link) {
        echo "auth_socket连接也失败: " . mysqli_connect_error() . "\n";
        exit(1);
    }
}

echo "连接成功!\n";

// 创建数据库
$sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8 COLLATE utf8_general_ci";
if (mysqli_query($link, $sql)) {
    echo "数据库创建成功\n";
} else {
    echo "数据库创建失败: " . mysqli_error($link) . "\n";
}

// 选择数据库
mysqli_select_db($link, $dbname);

// 读取SQL文件并执行
$sql_content = file_get_contents('db_news.sql');
if (!$sql_content) {
    echo "无法读取SQL文件\n";
    exit(1);
}

// 分割SQL语句
$sql_statements = explode(';', $sql_content);

foreach ($sql_statements as $sql) {
    $sql = trim($sql);
    if (!empty($sql)) {
        if (mysqli_query($link, $sql)) {
            echo "执行SQL成功\n";
        } else {
            echo "SQL执行失败: " . mysqli_error($link) . "\n";
        }
    }
}

echo "数据库初始化完成!\n";
mysqli_close($link);
?>
