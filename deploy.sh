#!/bin/bash
set -euo pipefail

APP_NAME="zeebufp"
APP_DIR="/home/ubuntu/apps/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
DOCKER_COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"
LOG_FILE="$APP_DIR/deploy.log"

log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🧼 Cleaning up old app state..."
sudo chown -R ubuntu:ubuntu "$APP_DIR"
sudo rm -rf "$APP_DIR/nginx/ssl" || true

init_directories() {
  log "📂 Initializing directory structure..."
  sudo mkdir -p "$APP_DIR"/{storage,bootstrap/cache,storage/logs}
  sudo mkdir -p "$APP_DIR"/storage/framework/{cache/data,sessions,views}

  sudo chown -R ubuntu:www-data "$APP_DIR"
  sudo chmod -R 775 "$APP_DIR"/storage "$APP_DIR"/bootstrap/cache
}

clean_docker() {
  log "🧹 Cleaning up Docker..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans --volumes --timeout 30 || true
  docker system prune -af || true
}

git_operations() {
  if [ -d "$APP_DIR/.git" ]; then
    log "🔄 Pulling latest code..."
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

deploy() {
  log "🚀 Deploying $APP_NAME..."

  init_directories
  git_operations

  sudo chown -R ubuntu:www-data "$APP_DIR"
  sudo chmod -R 775 "$APP_DIR"/storage "$APP_DIR"/bootstrap/cache

  clean_docker

  log "🐳 Building containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" build

  log "📦 Starting containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

  log "⚙️ Running Laravel setup inside container..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
    set -e
    echo '📁 Fixing Laravel ownership and cache...'
    chown -R www-data:www-data /var/www/html

    echo '📦 Installing composer dependencies...'
    composer install --no-dev --optimize-autoloader --no-interaction

    echo '🔧 Running Laravel setup...'
    php artisan config:clear
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan migrate --force
    php artisan storage:link

    echo '📝 Creating empty log file...'
    mkdir -p storage/logs && touch storage/logs/laravel.log
    chown -R www-data:www-data storage/logs
  "

  log "✅ Deployment complete!"
  exit 0
}

trap 'log \"❌ Deployment failed with exit code $?\"' ERR
deploy
