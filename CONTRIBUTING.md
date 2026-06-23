# 贡献指南 (CONTRIBUTING)

感谢你考虑为News Platform做出贡献！

## 如何贡献

### 报告问题

如果你发现了bug或有功能建议，请：

1. 检查是否已有相关issue
2. 创建新的issue，详细描述问题
3. 提供重现步骤和截图（如果适用）

### 提交代码

1. **Fork项目**
   ```bash
   git clone https://github.com/yourusername/php-news-system.git
   ```

2. **创建分支**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **编写代码**
   - 遵循现有代码风格
   - 添加必要的注释
   - 确保代码可正常运行

4. **测试代码**
   - 本地测试所有修改的功能
   - 确保不影响现有功能

5. **提交更改**
   ```bash
   git add .
   git commit -m "描述你的更改"
   ```

6. **推送分支**
   ```bash
   git push origin feature/your-feature-name
   ```

7. **创建Pull Request**
   - 详细描述你的更改
   - 关联相关的issue

## 开发规范

### 代码风格

- **PHP代码**
  - 使用4个空格缩进
  - 遵循PSR-12编码规范
  - 函数和类要有清晰的命名
  - 添加必要的注释

- **HTML/CSS**
  - 使用2个空格缩进
  - 保持代码整洁
  - 使用语义化标签

- **JavaScript**
  - 使用2个空格缩进
  - 避免全局变量
  - 添加必要的注释

### 文件命名

- PHP文件：使用小写字母和下划线 `example_file.php`
- 类文件：使用驼峰命名 `ExampleClass.php`
- 配置文件：使用小写字母 `config.php`

### 目录结构

```
php/
├── admin/          # 后台管理
├── web/            # 前端展示
├── mock_db.php     # 模拟数据库
├── db_news.sql     # 数据库文件
├── VERSION         # 版本信息
├── CHANGELOG.md    # 更新日志
└── README.md       # 项目说明
```

## 版本管理

### 版本号规则

遵循语义化版本规范：

- **主版本号**: 重大功能变更或不兼容的API修改
- **次版本号**: 新增功能，保持向后兼容
- **修订号**: Bug修复和小改进

示例：`1.2.3`
- 1: 主版本
- 2: 次版本
- 3: 修订版本

### 分支策略

- **main**: 主分支，稳定版本
- **develop**: 开发分支
- **feature/***: 功能分支
- **hotfix/***: 紧急修复分支

## 测试

### 本地测试

1. 启动PHP服务器
   ```bash
   # 后台
   cd admin && php -S localhost:8000
   
   # 前端
   cd web && php -S localhost:8001
   ```

2. 测试功能
   - 登录功能
   - 文章管理
   - 用户管理
   - 前端展示

### 数据库测试

使用模拟数据库进行测试：
```bash
# 模拟数据库已自动加载
# 无需MySQL连接即可测试基本功能
```

## 文档

### 更新文档

如果你添加了新功能或修改了现有功能：

1. 更新README.md
2. 更新CHANGELOG.md
3. 添加必要的代码注释
4. 更新API文档（如果有）

### 文档风格

- 使用清晰简洁的语言
- 提供代码示例
- 添加必要的截图
- 保持格式一致

## 发布流程

1. 更新VERSION文件
2. 更新CHANGELOG.md
3. 创建git tag
4. 推送到远程仓库
5. 创建GitHub Release

## 许可证

本项目采用MIT许可证，详见LICENSE文件。

## 联系方式

如有问题，请通过以下方式联系：

- GitHub Issues
- Email: your-email@example.com

---

再次感谢你的贡献！