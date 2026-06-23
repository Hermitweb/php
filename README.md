# News Platform - 现代化新闻资讯平台

> 专业的新闻资讯管理系统，提供完整的前后端功能

---

## 项目简介

News Platform 是一个基于 PHP + MySQL 构建的现代化新闻资讯管理平台，具备完整的内容管理和前端展示功能。

### 功能特性

#### 前端展示
- 📰 **新闻首页** - 英雄区域、头条推荐、最新资讯、热门文章
- 📋 **资讯列表** - 文章列表、搜索功能、分类筛选、加载更多
- 🏷️ **分类导航** - 8大分类（政治、经济、法律、军事、科技、文教、体育、社会）
- 📝 **文章详情** - 文章内容、评论区、相关文章推荐
- 📧 **联系我们** - 联系方式、留言表单

#### 后台管理
- 📊 **仪表盘** - 数据统计、图表展示、作者排行榜
- 📝 **文章管理** - 发布、编辑、删除、热门设置、评论控制
- 👥 **用户管理** - 用户列表、详情查看、状态管理
- 🔐 **管理员管理** - 管理员列表、权限管理
- 👤 **个人中心** - 个人资料、安全设置
- ⚙️ **系统设置** - 系统配置、参数管理

### 技术栈

| 分类 | 技术 | 版本 |
|------|------|------|
| 后端 | PHP | 7.4+ |
| 数据库 | MySQL | 5.7+ |
| 前端框架 | Bootstrap | 4.x |
| 图标库 | Font Awesome | 6.4.0 |
| 容器化 | Docker | 20.x |
| 版本控制 | Git | 2.x |

---

## 快速开始

### 环境要求

- PHP 7.4 或更高版本
- MySQL 5.7 或更高版本
- Apache/Nginx 或 PHP 内置服务器
- Git

### 本地开发

#### 方式一：PHP 内置服务器（推荐）

```bash
# 克隆项目
git clone <repository-url>
cd php

# 启动服务器
php -S localhost:8000

# 访问地址
# 前端首页: http://localhost:8000/web/index.php
# 后台登录: http://localhost:8000/admin/log/login.php
```

#### 方式二：Docker（推荐用于生产环境）

```bash
# 启动容器
docker-compose up -d

# 访问地址
# 前端首页: http://localhost:8000/web/index.php
# 后台登录: http://localhost:8000/admin/log/login.php
```

### 默认账号

| 角色 | 用户名 | 密码 | 说明 |
|------|--------|------|------|
| 管理员 | `123456` | `123456` | 后台管理账号 |

---

## 部署流程

### 1. 环境准备

#### Linux 服务器

```bash
# 更新系统
sudo apt update && sudo apt upgrade -y

# 安装 PHP 和扩展
sudo apt install -y php7.4 php7.4-mysql php7.4-mbstring php7.4-curl php7.4-gd php7.4-xml

# 安装 MySQL
sudo apt install -y mysql-server

# 安装 Nginx
sudo apt install -y nginx
```

#### Windows 环境

- 下载并安装 [XAMPP](https://www.apachefriends.org/index.html)
- 或使用 [WAMP](https://www.wampserver.com/)

### 2. 数据库配置

#### 创建数据库

```sql
-- 创建数据库
CREATE DATABASE news_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 创建用户并授权
CREATE USER 'news_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON news_platform.* TO 'news_user'@'localhost';
FLUSH PRIVILEGES;
```

#### 导入数据

项目使用模拟数据库（mock_db.php），首次访问时会自动初始化示例数据。

### 3. 配置文件

复制并修改配置文件：

```bash
cp includes/config.example.php includes/config.php
```

编辑 `includes/config.php`：

```php
<?php
return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'news_platform',
        'username' => 'news_user',
        'password' => 'your_password',
        'charset' => 'utf8mb4'
    ],
    'app' => [
        'name' => 'News Platform',
        'version' => '1.2.0',
        'debug' => false,
        'timezone' => 'Asia/Shanghai'
    ],
    'security' => [
        'csrf_protection' => true,
        'session_timeout' => 3600,
        'login_attempts_limit' => 5
    ]
];
```

### 4. Nginx 配置

创建站点配置文件 `/etc/nginx/sites-available/news-platform.conf`：

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/news-platform;
    index index.php index.html;

    # 前端页面
    location /web/ {
        try_files $uri $uri/ /web/index.php?$args;
    }

    # 后台管理
    location /admin/ {
        try_files $uri $uri/ /admin/index.php?$args;
    }

    # PHP 处理
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # 静态资源缓存
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # 安全配置
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options SAMEORIGIN;
    add_header X-XSS-Protection "1; mode=block";
}
```

启用站点：

```bash
sudo ln -s /etc/nginx/sites-available/news-platform.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 5. SSL 配置（可选）

使用 Let's Encrypt 配置 HTTPS：

```bash
# 安装 Certbot
sudo apt install -y certbot python3-certbot-nginx

# 申请证书
sudo certbot --nginx -d your-domain.com

# 自动续期
sudo certbot renew --dry-run
```

---

## 使用说明

### 前端功能

1. **浏览新闻**
   - 访问首页查看头条新闻和推荐内容
   - 使用搜索框搜索感兴趣的新闻
   - 通过分类导航浏览不同类别的资讯

2. **阅读文章**
   - 点击文章标题进入详情页
   - 查看文章内容、作者信息和发布时间
   - 在评论区发表评论

3. **订阅资讯**
   - 在侧边栏输入邮箱订阅新闻推送

### 后台管理

1. **登录系统**
   - 访问 `/admin/log/login.php`
   - 使用管理员账号登录

2. **文章管理**
   - 在仪表盘查看数据统计
   - 发布新文章：填写标题、作者、分类、内容等信息
   - 编辑或删除已有文章
   - 设置文章为热门或禁止评论

3. **用户管理**
   - 查看用户列表和详情
   - 管理用户状态

4. **系统设置**
   - 修改个人资料
   - 更新密码
   - 配置系统参数

---

## 项目结构

```
php/                              # 项目根目录
├── admin/                        # 后台管理系统
│   ├── caozuo.php                # 文章管理页面
│   ├── dashboard.php             # 仪表盘页面
│   ├── fabu.php                  # 发布文章页面
│   ├── i-user.php                # 用户管理页面
│   ├── index.php                 # 后台首页
│   ├── profile.php               # 个人中心页面
│   ├── settings.php              # 系统设置页面
│   ├── user.php                  # 管理员列表页面
│   ├── user_x.php                # 用户详情页面
│   ├── xiugai.php                # 修改文章页面
│   ├── css/                      # 后台样式文件
│   │   ├── dashboard.css         # 仪表盘样式
│   │   ├── index.css             # 全局样式
│   │   └── profile.css           # 个人中心样式
│   ├── js/                       # 后台脚本文件
│   └── log/                      # 登录/注册目录
│       ├── login.php             # 登录页面
│       └── reg.php               # 注册页面
├── includes/                     # 核心类库
│   ├── bootstrap.php             # 初始化文件
│   ├── Logger.php                # 日志类
│   ├── Response.php              # 响应处理类
│   ├── Security.php              # 安全类
│   └── ErrorHandler.php          # 错误处理类
├── web/                          # 前端展示页面
│   ├── index.php                 # 前端首页
│   ├── list.php                  # 资讯列表页面
│   ├── category.php              # 分类页面
│   ├── post.php                  # 文章详情页面
│   ├── contact.php               # 联系我们页面
│   ├── int.php                   # 前端初始化文件
│   ├── css/                      # 前端样式文件
│   │   ├── bootstrap.min.css     # Bootstrap 样式
│   │   ├── style.css             # 基础样式
│   │   ├── home-modern.css       # 首页样式
│   │   └── post-modern.css       # 文章详情样式
│   └── js/                       # 前端脚本文件
├── mock_db.php                   # 模拟数据库（开发用）
├── docker-compose.yml            # Docker Compose 配置
├── Dockerfile                    # Docker 镜像配置
└── README.md                     # 项目说明文档
```

---

## 安全特性

- ✅ **CSRF 防护** - 跨站请求伪造防护
- ✅ **密码加密** - 使用 password_hash 加密存储
- ✅ **登录频率限制** - 防止暴力破解
- ✅ **XSS 过滤** - 跨站脚本攻击防护
- ✅ **Session 安全** - HttpOnly、Session 固定攻击防护
- ✅ **输入验证** - 所有用户输入进行过滤和验证
- ✅ **安全 HTTP 头** - X-Content-Type-Options、X-Frame-Options、X-XSS-Protection

---

## 开发指南

### 代码规范

- 使用 PSR-4 自动加载规范
- 使用 camelCase 命名变量和函数
- 使用 PascalCase 命名类
- 缩进使用 4 个空格
- 文件编码使用 UTF-8

### 添加新功能

1. 在 `includes/` 目录创建新类
2. 在 `admin/` 或 `web/` 目录创建页面
3. 在对应的 CSS 文件中添加样式
4. 更新 `mock_db.php` 添加数据模型

### 测试

```bash
# 运行 PHP 语法检查
php -l *.php

# 运行单元测试（如果有）
phpunit tests/
```

---

## 贡献指南

欢迎提交 Issue 和 Pull Request！

### 提交规范

- **feat**: 新功能
- **fix**: 修复 bug
- **docs**: 更新文档
- **style**: 代码格式（不影响功能）
- **refactor**: 重构（既不是新功能也不是修复）
- **test**: 添加测试
- **chore**: 构建/工具更新

---

## 许可证

MIT License

---

## 联系方式

- 📧 邮箱：contact@news-platform.com
- 🌐 官网：https://www.news-platform.com
- 📍 地址：中国北京市朝阳区建国路88号

---

**Version**: 1.2.0  
**Last Updated**: June 2026