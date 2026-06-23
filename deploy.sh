#!/bin/bash
#
# News Platform部署脚本 v1.2
# 用法: ./deploy.sh [dev|prod]
#

set -e

ENV=${1:-prod}
APP_DIR=$(cd "$(dirname "$0")" && pwd)
BACKUP_DIR="$APP_DIR/backups/$(date +%Y%m%d_%H%M%S)"

echo "========================================"
echo "  News Platform v1.2 部署脚本"
echo "========================================"
echo ""
echo "环境: $ENV"
echo "应用目录: $APP_DIR"
echo ""

# 颜色输出
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# 打印信息函数
info() { echo -e "${GREEN}[INFO]${NC} $1"; }
warn() { echo -e "${YELLOW}[WARN]${NC} $1"; }
error() { echo -e "${RED}[ERROR]${NC} $1"; }

# 检查依赖
check_dependencies() {
    info "检查依赖..."

    if [ "$ENV" = "prod" ]; then
        if ! command -v docker &> /dev/null; then
            error "Docker未安装，请先安装Docker"
            exit 1
        fi
        if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
            error "Docker Compose未安装"
            exit 1
        fi
    else
        if ! command -v php &> /dev/null; then
            error "PHP未安装"
            exit 1
        fi
        PHP_VERSION=$(php -r 'echo PHP_VERSION;')
        info "PHP版本: $PHP_VERSION"
    fi
}

# 备份
backup() {
    if [ -d "$APP_DIR/uploads" ] || [ -d "$APP_DIR/logs" ]; then
        info "备份数据..."
        mkdir -p "$BACKUP_DIR"
        [ -d "$APP_DIR/uploads" ] && cp -r "$APP_DIR/uploads" "$BACKUP_DIR/"
        [ -d "$APP_DIR/logs" ] && cp -r "$APP_DIR/logs" "$BACKUP_DIR/"
        [ -f "$APP_DIR/.env" ] && cp "$APP_DIR/.env" "$BACKUP_DIR/"
        info "备份完成: $BACKUP_DIR"
    fi
}

# 部署开发环境
deploy_dev() {
    info "部署开发环境..."

    # 创建必要目录
    mkdir -p logs uploads

    # 设置权限
    chmod -R 755 .
    chmod -R 777 logs uploads

    # 启动开发服务器
    info "启动开发服务器..."
    info "后台: cd admin && php -S 0.0.0.0:8000"
    info "前端: cd web && php -S 0.0.0.0:8001"

    echo ""
    info "部署完成！"
}

# 部署生产环境
deploy_prod() {
    info "部署生产环境..."

    # 备份
    backup

    # 停止现有容器
    if [ "$(docker ps -q -f name=php-news-web)" ]; then
        info "停止现有容器..."
        docker-compose down
    fi

    # 构建镜像
    info "构建Docker镜像..."
    docker-compose build --no-cache

    # 启动服务
    info "启动服务..."
    docker-compose up -d

    # 等待服务就绪
    info "等待服务就绪..."
    sleep 10

    # 检查健康状态
    info "检查服务健康状态..."
    if curl -f http://localhost:8080/api/health.php &> /dev/null; then
        info "服务运行正常 ✓"
    else
        warn "健康检查失败，请查看日志: docker-compose logs"
    fi

    echo ""
    info "部署完成！"
    info "访问地址:"
    info "  前台: http://localhost:8080"
    info "  后台: http://localhost:8080/admin/log/login.php"
    info "  健康检查: http://localhost:8080/api/health.php"
}

# 清理
cleanup() {
    if [ -d "$APP_DIR/backups" ]; then
        # 只保留最近5个备份
        cd "$APP_DIR/backups" && ls -1t | tail -n +6 | xargs -r rm -rf
    fi
}

# 主流程
main() {
    check_dependencies

    if [ "$ENV" = "dev" ]; then
        deploy_dev
    else
        deploy_prod
    fi

    cleanup

    echo ""
    info "========================================="
    info "  部署成功！"
    info "========================================="
}

# 执行
main
