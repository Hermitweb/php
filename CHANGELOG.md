# 更新日志 (CHANGELOG)

所有重要的变更都将记录在此文件中。

格式基于 [Keep a Changelog](https://keepachangelog.com/zh-CN/1.0.0/)，
本项目版本号遵循 [语义化版本](https://semver.org/lang/zh-CN/)。

## [未发布]

### 新增
- 待添加的新功能

### 变更
- 待变更的功能

### 修复
- 待修复的问题

## [1.2.0] - 2026-06-23

### 🆕 新增功能

#### 安全增强
- 🔐 **Security类**：完整的XSS过滤、CSRF防护、输入验证
- 🛡️ **CSRF Token**：所有POST请求需要CSRF验证
- 🚦 **频率限制**：登录防暴力破解
- 🔒 **Session安全**：HttpOnly、Secure、Session固定攻击防护
- 🔑 **密码加密**：使用password_hash替代MD5（兼容旧数据）
- 📝 **安全日志**：记录所有登录尝试和敏感操作

#### 系统增强
- 📋 **Logger类**：统一的日志记录系统，支持自动轮转
- 📨 **Response类**：统一的API响应格式
- ⚠️ **ErrorHandler类**：全局异常和错误处理
- 🏥 **健康检查接口**：`/api/health.php`
- 🎨 **统一错误页面**：响应式设计，支持多种错误码

#### Docker生产环境
- 🐳 **生产级Docker镜像**：基于PHP 8.2
- ⚡ **OPcache优化**：性能提升
- 🗜️ **Gzip压缩**：减少传输体积
- 💾 **静态资源缓存**：Expires头优化
- 🛡️ **安全HTTP头**：XSS、CSRF、Frame保护
- 💓 **健康检查**：容器自动健康监控

#### 部署工具
- 🚀 **deploy.sh**：一键部署脚本（支持dev/prod）
- 📦 **.env.example**：环境变量配置示例
- 🔧 **.htaccess**：URL重写和安全配置
- 📁 **logs目录**：日志存储
- 📁 **uploads目录**：文件上传

### 🔧 变更

- ✅ 重构数据库初始化（统一使用bootstrap）
- ✅ 登录页面重构（增强安全性）
- ✅ 后台首页添加登录验证
- ✅ Dockerfile升级到PHP 8.2
- ✅ docker-compose.yml添加健康检查
- ✅ apache.conf添加缓存和压缩

### 🐛 修复

- 修复登录验证逻辑错误
- 修复文件路径引用问题
- 修复MySQL认证兼容性问题
- 修复数据库字段名错误（images → image）
- 修复Session可能的安全漏洞

### 📚 文档

- 新增 CHANGELOG.md 详细更新日志
- 新增 CONTRIBUTING.md 贡献指南
- 新增 LICENSE MIT许可证
- 新增 .env.example 环境配置示例
- 新增 deploy.sh 部署脚本文档

### 🏗️ 架构

```
php/
├── includes/                # 🆕 核心类库
│   ├── Security.php        # 安全工具类
│   ├── Logger.php          # 日志类
│   ├── Response.php        # 响应类
│   ├── ErrorHandler.php    # 错误处理
│   └── bootstrap.php       # 统一引导
├── api/                    # 🆕 API接口
│   └── health.php          # 健康检查
├── admin/                  # 后台管理
├── web/                    # 前端展示
├── logs/                   # 🆕 日志目录
├── uploads/                # 🆕 上传目录
├── error.php               # 🆕 统一错误页
├── deploy.sh               # 🆕 部署脚本
└── .env.example            # 🆕 环境配置
```

## [1.0.0] - 2021-01-08

### 新增
- 基础的新闻管理系统
- 后台管理功能
  - 文章发布与管理
  - 用户管理
  - 管理员管理
  - 数据统计
- 前端展示功能
  - 新闻首页展示
  - 新闻分类浏览
  - 新闻列表查看
  - 新闻详情阅读
- 用户登录注册系统
- 响应式界面设计
- Layui框架集成
- Bootstrap前端框架

### 功能模块
- **后台管理** (`admin/`)
  - 登录页面 (`log/login.php`)
  - 文章管理 (`caozuo.php`, `fabu.php`)
  - 用户管理 (`i-user.php`, `user.php`)
  - 数据统计 (`index.php`)
  
- **前端展示** (`web/`)
  - 首页 (`index.php`)
  - 列表页 (`list.php`)
  - 分类页 (`category.php`)
  - 详情页 (`post.php`)
  - 联系页 (`contact.php`)

### 数据库结构
- `tb_admin` - 管理员表
- `tb_user` - 用户表
- `tb_wen` - 文章表

### 技术栈
- PHP 7.4+
- MySQL 5.7+
- Layui UI框架
- Bootstrap 4
- jQuery

---

## 版本说明

- **1.0.0**: 初始版本，基础功能完整
- **1.2.0**: 开发版本，增强功能和修复问题
- **未来版本**: 持续优化和功能扩展

[未发布]: https://github.com/yourusername/php-news-system/compare/v1.0.0...HEAD
[1.2.0]: https://github.com/yourusername/php-news-system/compare/v1.0.0...v1.2.0
[1.0.0]: https://github.com/yourusername/php-news-system/releases/tag/v1.0.0