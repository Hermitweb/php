# News Platform

[![版本](https://img.shields.io/badge/版本-1.2.0-blue.svg)](https://github.com/Hermitweb/php)
[![许可证](https://img.shields.io/badge/许可证-MIT-green.svg)](LICENSE)
[![PHP版本](https://img.shields.io/badge/PHP-8.2%2B-purple.svg)](https://www.php.net/)
[![MySQL版本](https://img.shields.io/badge/MySQL-8.0%2B-orange.svg)](https://www.mysql.com/)

一个基于PHP+MySQL的现代化新闻内容管理平台，包含前台展示和后台管理功能。

## 📋 版本信息

- **当前版本**: 1.2.0
- **稳定版本**: 1.0.0 (已封存)
- **发布日期**: 2026-06-23
- **最后更新**: 2026-06-23

查看完整的版本更新历史：[CHANGELOG.md](CHANGELOG.md)

## ✨ 功能特点

### 后台管理功能
- 📰 新闻发布与管理
- 👥 用户权限管理
- 🔐 管理员登录系统
- 📊 数据统计与分页
- 🎨 响应式界面设计

### 前端展示功能
- 🏠 新闻首页展示
- 📂 新闻分类浏览
- 📝 新闻列表查看
- 📄 新闻详情阅读
- 📞 联系我们页面

### 技术特性
- 🐳 Docker容器化部署
- 📦 模拟数据库支持
- 🚀 自动化启动脚本
- 📚 完善的项目文档
- 🔧 Git版本管理

## 🛠️ 技术栈

| 类别 | 技术 |
|------|------|
| **后端** | PHP 7.4+ |
| **数据库** | MySQL 5.7+ |
| **前端UI** | Layui框架 |
| **前端框架** | Bootstrap 4 |
| **JavaScript** | jQuery |
| **容器化** | Docker |

## 🚀 快速开始

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
   - **前端**: http://localhost:8001
   - **后台**: http://localhost:8000/log/login.php

### 方法二：使用Docker

1. 确保已安装Docker和Docker Compose

2. 启动服务：
   ```bash
   docker-compose up -d
   ```

3. 访问系统：
   - **前端**: http://localhost:8080
   - **后台**: http://localhost:8080/admin/

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
   编辑 `admin/int.php` 和 `web/int.php` 文件，修改数据库配置：
   ```php
   $db_host="localhost";
   $db_user="root";
   $db_password="your_password";
   $db_name="db_news";
   ```

4. 启动Web服务器：
   ```bash
   # 后台管理
   cd admin && php -S localhost:8000
   
   # 前端展示
   cd web && php -S localhost:8001
   ```

## 🔐 默认登录信息

| 角色 | 账号 | 密码 |
|------|------|------|
| 管理员 | 123456 | 123456 |
| 管理员 | 666666 | 666666 |

⚠️ **注意**: 生产环境请务必修改默认密码！

## 📁 项目结构

```
php/
├── admin/                  # 后台管理目录
│   ├── index.php          # 后台首页
│   ├── log/login.php      # 登录页面
│   ├── fabu.php           # 发布文章
│   ├── caozuo.php         # 文章操作
│   ├── user.php           # 用户管理
│   ├── int.php            # 数据库配置
│   ├── db.php             # 数据库操作函数
│   └── layui/             # Layui框架文件
│
├── web/                    # 前端展示目录
│   ├── index.php          # 前端首页
│   ├── list.php           # 新闻列表
│   ├── category.php       # 新闻分类
│   ├── post.php           # 新闻详情
│   ├── contact.php        # 联系页面
│   ├── css/               # 样式文件
│   ├── js/                # JavaScript文件
│   └── images/            # 图片资源
│
├── mock_db.php            # 模拟数据库
├── db_news.sql            # 数据库文件
├── Dockerfile             # Docker配置
├── docker-compose.yml     # Docker Compose配置
├── start.sh               # 启动脚本
│
├── VERSION                # 版本信息
├── CHANGELOG.md           # 更新日志
├── CONTRIBUTING.md        # 贡献指南
├── LICENSE                # MIT许可证
└── README.md              # 项目说明
```

## 💾 数据库表结构

| 表名 | 说明 | 主要字段 |
|------|------|---------|
| `tb_admin` | 管理员表 | id, name, uid, password, phone |
| `tb_user` | 用户表 | id, uid, password, email, phone |
| `tb_wen` | 文章表 | id, title, content, user, leibie |

## 🌐 访问地址

### 前端展示页面
| 页面 | 地址 |
|------|------|
| 首页 | http://localhost:8001 |
| 列表页 | http://localhost:8001/list.php |
| 分类页 | http://localhost:8001/category.php |
| 详情页 | http://localhost:8001/post.php?id=1 |
| 联系页 | http://localhost:8001/contact.php |

### 后台管理页面
| 页面 | 地址 |
|------|------|
| 登录页 | http://localhost:8000/log/login.php |
| 后台首页 | http://localhost:8000/index.php |
| 文章管理 | http://localhost:8000/caozuo.php |
| 发布文章 | http://localhost:8000/fabu.php |
| 用户管理 | http://localhost:8000/i-user.php |

## ⚠️ 注意事项

1. ✅ 确保PHP已安装mysqli扩展
2. ✅ MySQL默认用户名和密码都是root
3. ⚠️ 生产环境请修改默认密码
4. 💡 建议使用Apache或Nginx作为生产服务器
5. 🔒 注意数据库安全配置

## 🔧 常见问题

### 数据库连接失败
- 检查MySQL服务是否启动
- 确认数据库用户名和密码正确
- 验证数据库是否已创建
- 使用模拟数据库进行测试

### 页面无法访问
- 检查Web服务器是否正常运行
- 确认防火墙设置
- 验证端口是否被占用

### 登录失败
- 确认账号密码正确
- 检查数据库连接状态
- 查看浏览器控制台错误信息

## 📖 文档

- [更新日志](CHANGELOG.md) - 版本更新历史
- [贡献指南](CONTRIBUTING.md) - 如何参与开发
- [许可证](LICENSE) - MIT开源协议

## 🤝 贡献

欢迎参与项目开发！请查看 [贡献指南](CONTRIBUTING.md) 了解详情。

### 开发分支
- `master` - 主分支（稳定版本）
- `develop-v1.2` - 开发分支（当前开发版本）

## 📜 许可证

本项目采用 [MIT许可证](LICENSE)，详见LICENSE文件。

## 📞 支持

如有问题或建议，请通过以下方式联系：

- 📧 Email: admin@news-platform.com
- 🐛 GitHub Issues: 提交问题报告
- 💬 项目文档: 查看详细说明

## 🎯 开发计划

### v1.2.0 (已发布)
- ✅ 模拟数据库支持
- ✅ Docker容器化部署
- ✅ 完善项目文档
- 🔄 优化用户界面
- 🔄 增强安全性
- 🔄 添加更多功能

### 未来版本
- 🔮 RESTful API接口
- 🔮 移动端适配
- 🔮 多语言支持
- 🔮 性能优化
- 🔮 更多管理功能

---

**感谢使用News Platform！** 🎉