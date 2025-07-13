#!/bin/bash
set -euo pipefail

# Configuration
APP_NAME="zeebufp"
APP_DIR="/home/ubuntu/apps/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
DOCKER_COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"
LOG_FILE="$APP_DIR/deploy.log"

# Logging function
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🧼 Cleaning up leftovers (nginx/ssl)..."
sudo chown -R ubuntu:ubuntu "$APP_DIR"
sudo rm -rf "$APP_DIR/nginx/ssl" || true

# Directory setup
init_directories() {
  log "📂 Creating Laravel dirs with correct permissions..."
  sudo mkdir -p "$APP_DIR"/{storage,bootstrap/cache}
  sudo mkdir -p "$APP_DIR"/storage/framework/{cache/data,sessions,views}
  sudo mkdir -p "$APP_DIR"/storage/logs
  sudo touch "$APP_DIR"/storage/logs/laravel.log

  sudo chown -R ubuntu:www-data "$APP_DIR"
  sudo chmod -R 775 "$APP_DIR"/storage "$APP_DIR"/bootstrap/cache
}

# Git pull or clone
git_operations() {
  if [ -d "$APP_DIR/.git" ]; then
    log "🔄 Pulling latest changes..."
    cd "$APP_DIR"
    git reset --hard HEAD
    git clean -fd
    git pull origin main
  else
    log "📥 Cloning repository..."
    sudo rm -rf "$APP_DIR"
    git clone "$REPO_URL" "$APP_DIR"
    cd "$APP_DIR"
  fi
}

# Docker cleanup
clean_docker() {
  log "🧹 Cleaning Docker..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans --volumes --timeout 30 || true
  docker system prune -af || true
}

# Deploy
deploy() {
  log "🚀 Deploying $APP_NAME..."

  init_directories
  git_operations

  sudo chown -R ubuntu:www-data "$APP_DIR"
  sudo chmod -R 775 "$APP_DIR"/storage "$APP_DIR"/bootstrap/cache

  clean_docker

  log "🐳 Building containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" build

  log "🔌 Starting containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

  log "⚙️ Configuring Laravel in container..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
    set -e
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
    touch /var/www/html/storage/logs/laravel.log
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

    composer install --no-dev --optimize-autoloader --no-interaction

    php artisan migrate --force
    php artisan storage:link
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    if [ -e /var/run/supervisor.sock ]; then
      supervisorctl reread
      supervisorctl update
      supervisorctl restart horizon || true
    fi
  "

  log "✅ Deployment completed successfully!"
}

trap 'log "❌ Deployment failed with exit code $?"' ERR
deploy
