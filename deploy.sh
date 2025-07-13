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

# Initialize directory structure
prepare_directories() {
  mkdir -p "$APP_DIR"/{storage,nginx/ssl,bootstrap/cache}
  mkdir -p "$APP_DIR"/storage/framework/{cache/data,sessions,views}
  mkdir -p "$APP_DIR"/storage/logs
}

log "🚀 Starting deployment of $APP_NAME..."

# Prepare host directories
prepare_directories

# Set temporary permissions for git operations
sudo chown -R ubuntu:ubuntu "$APP_DIR"

# === GIT OPERATIONS ===
if [ -d "$APP_DIR/.git" ]; then
  log "📥 Pulling latest changes..."
  cd "$APP_DIR"
  git reset --hard
  git pull origin main
else
  log "📥 Cloning repository..."
  git clone "$REPO_URL" "$APP_DIR"
  cd "$APP_DIR"
fi

# Set proper permissions for Docker
sudo chown -R ubuntu:www-data "$APP_DIR"
sudo chmod -R 775 "$APP_DIR"/storage "$APP_DIR"/bootstrap/cache

# === DOCKER OPERATIONS ===
log "🧹 Cleaning up old containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans || true

log "🐳 Building containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" build

log "🚀 Starting services..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

# === APPLICATION SETUP ===
log "⚙️ Configuring Laravel..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
  set -e
  git config --global --add safe.directory /var/www/html
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan storage:link
  php artisan optimize
"

log "✅ Deployment completed successfully!"
