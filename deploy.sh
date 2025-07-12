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

# Compute container name and release tag
CONTAINER_NAME="${APP_NAME}_${TIMESTAMP}"
export ZEEBUF_RELEASE_PATH=$(readlink -f "$NEW_RELEASE_DIR")

# Logging
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🚀 Starting blue-green deployment of $APP_NAME..."

# Prepare directories
mkdir -p \
  "$RELEASES_DIR" \
  "$SHARED_DIR/storage/framework/{cache,views,sessions}" \
  "$SHARED_DIR/bootstrap/cache"

chown -R www-data:www-data "$SHARED_DIR"

# Clone fresh code
log "📥 Cloning repository..."
git clone --depth=1 "$REPO_URL" "$NEW_RELEASE_DIR"

# Link shared
log "🔗 Linking shared files..."
ln -sf "$SHARED_DIR/.env" "$NEW_RELEASE_DIR/.env"
ln -snf "$SHARED_DIR/storage" "$NEW_RELEASE_DIR/storage"
ln -snf "$SHARED_DIR/bootstrap/cache" "$NEW_RELEASE_DIR/bootstrap/cache"

# Stop old container if any
log "🧼 Stopping and removing old $APP_NAME containers..."
old_container=$(docker ps -a --filter "name=${APP_NAME}_" --format '{{.Names}}')
if [ -n "$old_container" ]; then
  docker stop $old_container || true
  docker rm -f $old_container || true
fi

# Build and run new container
log "🐳 Building new release container..."
docker-compose -f "$DEPLOY_BASE/docker-compose.yml" build "$CONTAINER_NAME"

log "🚀 Starting new container..."
docker-compose -f "$DEPLOY_BASE/docker-compose.yml" up -d "$CONTAINER_NAME" reverse-proxy

# Laravel post-setup
log "⚙️ Running Laravel setup inside container..."
docker-compose -f "$DEPLOY_BASE/docker-compose.yml" exec -T "$CONTAINER_NAME" bash -c "
  mkdir -p bootstrap/cache storage/framework/{views,cache,sessions} &&
  chown -R www-data:www-data bootstrap storage &&
  chmod -R 775 bootstrap storage &&
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
    supervisorctl -c /etc/supervisor/supervisord.conf reread || true
    supervisorctl -c /etc/supervisor/supervisord.conf update || true
    supervisorctl -c /etc/supervisor/supervisord.conf restart horizon || true
  else
    echo '⚠️ Supervisor not ready — skipping Horizon restart'
  fi
"

# Clean old releases (keep 5)
log "🧹 Cleaning old releases..."
cd "$RELEASES_DIR"
ls -1t | tail -n +6 | xargs -d '\n' rm -rf -- || true

log "✅ Deployment complete for release: $TIMESTAMP"
