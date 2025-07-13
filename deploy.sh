#!/bin/bash
set -euo pipefail

APP_NAME="zeebufp"
APP_DIR="/home/ubuntu/apps/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
DOCKER_COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"
LOG_FILE="$APP_DIR/deploy.log"

WEB_USER_ID=82
WEB_GROUP_ID=82

log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🧼 Cleaning up leftovers (nginx/ssl)..."
sudo chown -R ubuntu:ubuntu "$APP_DIR"
sudo rm -rf "$APP_DIR/nginx/ssl" || true

init_directories() {
  log "📂 Initializing directory structure..."
  sudo mkdir -p "$APP_DIR"/{storage,nginx/ssl,bootstrap/cache}
  sudo mkdir -p "$APP_DIR"/storage/framework/{cache/data,sessions,views}
  sudo mkdir -p "$APP_DIR"/storage/logs

  log "🔒 Setting permissions..."
  sudo chown -R ubuntu:www-data "$APP_DIR"
  sudo chmod -R 775 "$APP_DIR"/storage
  sudo chmod -R 775 "$APP_DIR"/bootstrap/cache
  sudo chown -R ubuntu:ubuntu "$APP_DIR"/.git || true
}

clean_docker() {
  log "🧹 Cleaning up old Docker artifacts..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans --volumes --timeout 30 || true
}

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

deploy() {
  log "🚀 Starting deployment of $APP_NAME..."

  init_directories
  cd "$APP_DIR"

  git_operations

  # Re-apply permissions post-git
  sudo chown -R ubuntu:www-data "$APP_DIR"
  sudo chmod -R 775 "$APP_DIR"/storage
  sudo chmod -R 775 "$APP_DIR"/bootstrap/cache

  clean_docker

  log "🐳 Building containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" build

  log "🚀 Starting services..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

  # Optional: wait for container to start up
  sleep 5

  log "⚙️ Configuring Laravel..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
    set -e

    # Permissions (no sudo)
    chown -R www-data:www-data /var/www/.gitconfig || true

    # Laravel setup
    composer install --no-dev --optimize-autoloader --no-interaction

    php artisan migrate --force
    php artisan storage:link
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
  "

  log "✅ Deployment completed successfully!"
  exit 0
}

trap 'log "❌ Deployment failed with exit code $?"' ERR
deploy
