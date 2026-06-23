# PHP新闻管理系统

一个基于PHP+MySQL的新闻内容管理系统，包含前台展示和后台管理功能。

## 功能特点

- 📰 新闻发布与管理
- 👥 用户权限管理
- 🔐 管理员登录系统
- 📊 数据统计与分页
- 🎨 响应式界面设计

## 技术栈

- **后端**: PHP 7.4+
- **数据库**: MySQL 5.7+
- **前端**: Layui框架
- **服务器**: Apache/Nginx

## 快速开始

### 方法一：使用启动脚本（推荐）

1. 确保已安装PHP和MySQL：
   ```bash
   # Ubuntu/Debian
   sudo apt install php php-mysql mysql-client
   
   # CentOS/RHEL
   sudo yum install php php-mysql mysql
   ```

2. 运行启动脚本：
   ```bash
   ./start.sh
   ```

3. 访问系统：
   - 前台：http://localhost:8000
   - 后台：http://localhost:8000/admin/

### 方法二：使用Docker

1. 确保已安装Docker和Docker Compose

2. 启动服务：
   ```bash
   docker-compose up -d
   ```

3. 访问系统：
   - 前台：http://localhost:8080
   - 后台：http://localhost:8080/admin/

### 方法三：手动配置

1. 创建数据库：
   ```bash
   mysql -u root -p
   CREATE DATABASE db_news CHARACTER SET utf8 COLLATE utf8_general_ci;
   ```

2. 导入数据：
   ```bash
   mysql -u root -p db_news < db_news.sql
   ```

3. 配置数据库连接：
   编辑 `admin/int.php` 文件，修改数据库配置：
   ```php
   $db_host="localhost";
   $db_user="root";
   $db_password="your_password";
   $db_name="db_news";
   ```

4. 启动Web服务器：
   ```bash
   cd admin
   php -S localhost:8000
   ```

## 默认登录信息

- **管理员账号**: admin
- **管理员密码**: 123456

## 项目结构

```
php/
├── admin/                  # 后台管理目录
│   ├── index.php          # 后台首页
│   ├── login.php          # 登录页面
│   ├── fabu.php           # 发布文章
│   ├── caozuo.php         # 文章操作
│   ├── user.php           # 用户管理
│   ├── int.php            # 数据库配置
│   ├── db.php             # 数据库操作函数
│   └── layui/             # Layui框架文件
├── db_news.sql            # 数据库文件
├── Dockerfile             # Docker配置
├── docker-compose.yml     # Docker Compose配置
├── start.sh              # 启动脚本
└── README.md             # 项目说明
```

## 数据库表结构

- `tb_admin` - 管理员表
- `tb_user` - 用户表
- `tb_wen` - 文章表

## 注意事项

1. 确保PHP已安装mysqli扩展
2. MySQL默认用户名和密码都是root
3. 生产环境请修改默认密码
4. 建议使用Apache或Nginx作为生产服务器

## 常见问题

### 数据库连接失败
- 检查MySQL服务是否启动
- 确认数据库用户名和密码正确
- 验证数据库是否已创建

### 页面无法访问
- 检查Web服务器是否正常运行
- 确认防火墙设置
- 验证端口是否被占用

## 许可证

本项目仅供学习和参考使用。

## 支持

如有问题，请联系项目维护者。