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

## [1.2.0] - 开发中

### 新增
- 模拟数据库支持（绕过MySQL认证问题）
- Docker容器化部署配置
- 自动化启动脚本
- 完善的Git版本管理
- 前端和后端分离部署

### 变更
- 优化登录页面逻辑
- 修复文件路径引用问题
- 改进数据库连接配置
- 更新项目文档结构

### 修复
- 修复登录验证逻辑错误
- 修复相对路径引用问题
- 修复MySQL认证兼容性问题

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