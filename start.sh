#!/bin/bash

# News Platform启动脚本

echo "==================================="
echo "News Platform启动脚本"
echo "==================================="

# 检查PHP是否安装
if ! command -v php &> /dev/null; then
    echo "❌ 错误：未找到PHP"
    echo "请先安装PHP："
    echo "  Ubuntu/Debian: sudo apt install php php-mysql"
    echo "  CentOS/RHEL: sudo yum install php php-mysql"
    exit 1
fi

# 检查MySQL是否安装
if ! command -v mysql &> /dev/null; then
    echo "❌ 错误：未找到MySQL客户端"
    echo "请先安装MySQL客户端："
    echo "  Ubuntu/Debian: sudo apt install mysql-client"
    echo "  CentOS/RHEL: sudo yum install mysql"
    exit 1
fi

echo "✅ PHP和MySQL客户端已安装"

# 检查数据库是否存在
echo "📊 检查数据库..."
if mysql -u root -p"root" -e "USE db_news;" 2>/dev/null; then
    echo "✅ 数据库 db_news 已存在"
else
    echo "📝 创建数据库..."
    mysql -u root -p"root" -e "CREATE DATABASE IF NOT EXISTS db_news CHARACTER SET utf8 COLLATE utf8_general_ci;" 2>/dev/null
    if [ $? -eq 0 ]; then
        echo "✅ 数据库创建成功"
        
        # 导入SQL文件
        echo "📥 导入数据..."
        mysql -u root -p"root" db_news < db_news.sql 2>/dev/null
        if [ $? -eq 0 ]; then
            echo "✅ 数据导入成功"
        else
            echo "⚠️  数据导入失败，但数据库已创建"
        fi
    else
        echo "❌ 数据库创建失败"
        exit 1
    fi
fi

# 启动PHP内置服务器
echo ""
echo "==================================="
echo "🚀 启动News Platform..."
echo "==================================="
echo "📱 访问地址："
echo "   前台：http://localhost:8000"
echo "   后台：http://localhost:8000/admin/"
echo ""
echo "📋 默认登录信息："
echo "   管理员账号：admin"
echo "   管理员密码：123456"
echo ""
echo "按 Ctrl+C 停止服务器"
echo "==================================="
echo ""

cd admin && php -S localhost:8000