FROM php:7.4-apache

# 安装PHP扩展
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 启用Apache mod_rewrite
RUN a2enmod rewrite

# 设置工作目录
WORKDIR /var/www/html

# 复制Apache配置
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# 复制项目文件
COPY . /var/www/html/

# 设置权限
RUN chown -R www-data:www-data /var/www/html

# 暴露80端口
EXPOSE 80