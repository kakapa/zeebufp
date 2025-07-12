#!/bin/bash
set -euo pipefail

# === CONFIGURATION ===
APP_NAME="zeebufp"
DEPLOY_BASE="/home/ubuntu/apps"
APP_DIR="$DEPLOY_BASE/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
RELEASES_DIR="$APP_DIR/releases"
SHARED_DIR="$APP_DIR/shared"
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
NEW_RELEASE_DIR="$RELEASES_DIR/$TIMESTAMP"
LOG_FILE="$APP_DIR/deploy.log"
DOCKER_COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"

# === LOGGING ===
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🚀 Starting clean deployment of $APP_NAME..."

# === CLEANUP BEFORE DEPLOY ===
log "🧹 Cleaning previous Docker resources..."
docker-compose -f "$DOCKER_COMPOSE_FILE" down -v || true
docker system prune -af || true

# === CLONE NEW RELEASE ===
log "📥 Cloning repository..."
git clone --depth=1 "$REPO_URL" "$NEW_RELEASE_DIR"

# === LINK SHARED FILES ===
log "🔗 Linking shared files..."
ln -sf "$SHARED_DIR/.env" "$NEW_RELEASE_DIR/.env"
ln -snf "$SHARED_DIR/storage" "$NEW_RELEASE_DIR/storage"
ln -snf "$SHARED_DIR/bootstrap/cache" "$NEW_RELEASE_DIR/bootstrap/cache"

# === EXPORT PATH FOR BUILD ===
export RELEASE_PATH=$(readlink -f "$NEW_RELEASE_DIR")

# === BUILD AND DEPLOY ===
log "🐳 Building Docker container..."
cd "$APP_DIR"
docker-compose -f "$DOCKER_COMPOSE_FILE" build

log "🚀 Starting containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

# === POST-DEPLOY LARAVEL TASKS ===
log "⚙️ Running Laravel setup inside container..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -euo pipefail -c "
  set -e

  echo '📦 Installing composer dependencies...'
  composer install --no-dev --optimize-autoloader

  echo '🛠 Running migrations...'
  php artisan migrate --force

  echo '🔗 Linking storage...'
  php artisan storage:link || true

  echo '🧹 Clearing caches...'
  php artisan config:clear || true
  php artisan route:clear || true
  php artisan view:clear || true

  echo '🚀 Caching config/routes/views...'
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache

  echo '🧵 Restarting Horizon...'
  php artisan horizon:terminate || true

  if [ -e /var/run/supervisor.sock ]; then
    echo '🔁 Restarting Supervisor Horizon...'
    supervisorctl reread || true
    supervisorctl update || true
    supervisorctl restart horizon || true
  else
    echo '⚠️ Supervisor socket not found — skipping Horizon restart'
  fi
"

# === CLEAN OLD RELEASES ===
log "🧹 Cleaning up old releases (keep latest 5)..."
cd "$RELEASES_DIR"
ls -1t | tail -n +6 | xargs -d '\n' rm -rf -- || true

log "✅ Deployment complete for release: $TIMESTAMP"
