#!/bin/bash
set -euo pipefail

APP_NAME="zeebufp"
DEPLOY_BASE="/home/ubuntu/apps"
APP_DIR="$DEPLOY_BASE/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
RELEASES_DIR="$APP_DIR/releases"
SHARED_DIR="$APP_DIR/shared"
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
NEW_RELEASE_DIR="$RELEASES_DIR/$TIMESTAMP"
LOG_FILE="$APP_DIR/deploy.log"
DOCKER_COMPOSE_FILE="$DEPLOY_BASE/docker-compose.yml"

# Logging function
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🚀 Starting deployment of $APP_NAME..."

# Ensure shared directories exist
log "📁 Preparing shared directories..."
mkdir -p \
  "$SHARED_DIR/storage/framework/cache" \
  "$SHARED_DIR/storage/framework/views" \
  "$SHARED_DIR/storage/framework/sessions" \
  "$SHARED_DIR/bootstrap/cache"

chown -R www-data:www-data "$SHARED_DIR"

# Clone fresh copy of the repo
log "📥 Cloning repository..."
git clone --depth=1 "$REPO_URL" "$NEW_RELEASE_DIR"

# Link shared files into new release
log "🔗 Linking shared files..."
ln -sf "$SHARED_DIR/.env" "$NEW_RELEASE_DIR/.env"
ln -snf "$SHARED_DIR/storage" "$NEW_RELEASE_DIR/storage"
ln -snf "$SHARED_DIR/bootstrap/cache" "$NEW_RELEASE_DIR/bootstrap/cache"

# Defensive cleanup before build
log "🧨 Cleaning up old/broken container state for all apps"
for APP_NAME in zeebufp lifet; do
  log "🧨 Cleaning up for $APP_NAME..."
  docker rm -f "apps_${APP_NAME}_1" 2>/dev/null || true
  docker volume ls --format '{{.Name}}' | grep "$APP_NAME" | xargs -r docker volume rm || true
done

if docker ps -a --format '{{.Names}}' | grep -q "apps_${APP_NAME}_1"; then
  log "🧼 Detected existing container, stopping and removing it..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" stop "$APP_NAME"
  docker-compose -f "$DOCKER_COMPOSE_FILE" rm -f "$APP_NAME"
fi

# Build Docker containers
log "🐳 Building Docker containers..."
cd "$DEPLOY_BASE"
ZEEBUF_RELEASE_PATH="$NEW_RELEASE_DIR" \
docker-compose -f "$DOCKER_COMPOSE_FILE" build --no-cache zeebufp

# Start Laravel app and reverse proxy
log "📦 Starting containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d zeebufp reverse-proxy

# Fix permissions first (before composer)
log "🔧 Ensuring cache paths exist before Composer runs..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T zeebufp bash -c "
  mkdir -p bootstrap/cache &&
  mkdir -p storage/framework/{views,cache,sessions} &&
  chown -R www-data:www-data bootstrap storage &&
  chmod -R 775 bootstrap storage
"

# Laravel setup inside container
log "⚙️ Running Laravel setup in container..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T zeebufp bash -c "
  composer install --no-dev --optimize-autoloader &&
  php artisan migrate --force &&
  php artisan storage:link || true &&
  php artisan config:clear &&
  php artisan route:clear &&
  php artisan view:clear &&
  php artisan config:cache &&
  php artisan route:cache &&
  php artisan view:cache &&
  php artisan horizon:terminate || true &&
  if [ -S /var/run/supervisor.sock ]; then
    php artisan horizon:terminate || true
    supervisorctl -c /etc/supervisor/supervisord.conf reread || true
    supervisorctl -c /etc/supervisor/supervisord.conf update || true
    supervisorctl -c /etc/supervisor/supervisord.conf restart horizon || true
  else
    echo '⚠️ Supervisor not ready — skipping Horizon restart'
  fi
"

# Point "current" symlink to new release
log "🔀 Updating current release symlink..."
ln -sfn "$NEW_RELEASE_DIR" "$APP_DIR/current"

# Clean up old releases (keep 5)
log "🧹 Cleaning up old releases..."
cd "$RELEASES_DIR"
ls -1t | tail -n +6 | xargs -d '\n' rm -rf -- || true

log "✅ Deployment complete! New release: $TIMESTAMP"
