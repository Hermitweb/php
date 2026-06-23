FROM php:8.2-apache

# 设置环境变量
ENV APP_VERSION=1.2.0 \
    APP_DEBUG=false \
    APP_ENV=production

# 安装系统依赖
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# 安装PHP扩展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo \
        pdo_mysql \
        gd \
        zip \
        intl \
        opcache \
        bcmath

# 启用Apache模块
RUN a2enmod rewrite headers expires deflate

# 配置OPcache（生产环境优化）
RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=0'; \
        echo 'opcache.memory_consumption=256'; \
        echo 'opcache.interned_strings_buffer=16'; \
        echo 'opcache.max_accelerated_files=20000'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.revalidate_freq=0'; \
        echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# 配置PHP生产环境
RUN { \
        echo 'memory_limit=256M'; \
        echo 'upload_max_filesize=50M'; \
        echo 'post_max_size=50M'; \
        echo 'max_execution_time=60'; \
        echo 'max_input_time=60'; \
        echo 'max_input_vars=3000'; \
        echo 'date.timezone=Asia/Shanghai'; \
        echo 'expose_php=Off'; \
        echo 'display_errors=Off'; \
        echo 'log_errors=On'; \
        echo 'error_log=/var/log/php/error.log'; \
    } > /usr/local/etc/php/conf.d/php-production.ini

# 设置工作目录
WORKDIR /var/www/html

# 复制项目文件
COPY . /var/www/html/

# 创建必要的目录
RUN mkdir -p /var/www/html/logs \
    && mkdir -p /var/www/html/uploads \
    && mkdir -p /var/log/php

# 设置权限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/logs \
    && chmod -R 775 /var/www/html/uploads \
    && chown -R www-data:www-data /var/log/php

# 复制Apache配置
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# 健康检查
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost/api/health.php || exit 1

# 暴露端口
EXPOSE 80

# 启动Apache
CMD ["apache2-foreground"]
