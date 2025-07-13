#!/bin/bash
set -euo pipefail

# Configuration
APP_NAME="zeebufp"
APP_DIR="/home/ubuntu/apps/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
DOCKER_COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"
LOG_FILE="$APP_DIR/deploy.log"

# Logging
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE" || echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*"
}

log "🧼 Cleaning up old app state..."
sudo chown -R ubuntu:ubuntu "$APP_DIR"
sudo mkdir -p "$APP_DIR/storage/logs"
sudo touch "$LOG_FILE"
sudo chown ubuntu:ubuntu "$LOG_FILE"

# Initialize Laravel dirs
init_directories() {
  log "📂 Ensuring Laravel directories exist..."
  mkdir -p "$APP_DIR/storage/framework/cache/data"
  mkdir -p "$APP_DIR/storage/framework/{sessions,views}"
  mkdir -p "$APP_DIR/storage/logs"
  mkdir -p "$APP_DIR/bootstrap/cache"

  chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
  chown -R ubuntu:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
}

# Git operations
git_operations() {
  if [ -d "$APP_DIR/.git" ]; then
    log "🔄 Pulling latest from main branch..."
    cd "$APP_DIR"
    git reset --hard HEAD
    git clean -fd
    git pull origin main
  else
    log "📥 Cloning repository fresh..."
    sudo rm -rf "$APP_DIR"
    git clone "$REPO_URL" "$APP_DIR"
    cd "$APP_DIR"
  fi
}

# Docker cleanup
clean_docker() {
  log "🧹 Cleaning Docker containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans --volumes --timeout 30 || true
  docker system prune -af || true
}

# Laravel configuration inside container
configure_laravel_in_container() {
  log "⚙️ Configuring Laravel inside container..."

  docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T "$APP_NAME" bash -c "
    set -e
    git config --global --add safe.directory /var/www/html

    composer install --no-dev --optimize-autoloader --no-interaction

    php artisan migrate --force || true
    php artisan storage:link || true
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    mkdir -p storage/logs && touch storage/logs/laravel.log
    chown -R www-data:www-data storage bootstrap/cache

    if [ -S /var/run/supervisor.sock ]; then
      supervisorctl reread
      supervisorctl update
      supervisorctl restart horizon || true
    fi
  "
}

# Deployment flow
deploy() {
  log "🚀 Deploying $APP_NAME..."

  init_directories
  git_operations
  clean_docker

  log "🐳 Building containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" build

  log "🟢 Starting containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

  configure_laravel_in_container

  log "✅ Deployment complete!"
}

# Error trap
trap 'log "❌ Deployment failed with exit code $?"' ERR
deploy
