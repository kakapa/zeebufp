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

# Initialize logging
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🚀 Starting deployment of $APP_NAME..."

# Create directory structure
mkdir -p "$RELEASES_DIR" "$SHARED_DIR/storage"

# Clone new release
log "📥 Cloning repository..."
git clone --depth 1 "$REPO_URL" "$NEW_RELEASE_DIR"

# Link shared files
log "🔗 Linking shared files..."
ln -sf "$SHARED_DIR/.env" "$NEW_RELEASE_DIR/.env"
ln -sf "$SHARED_DIR/storage" "$NEW_RELEASE_DIR/storage"

# Build with explicit path
log "💪 Building Docker container..."
cd "$DEPLOY_BASE"
ZEEBUF_RELEASE_PATH="$NEW_RELEASE_DIR" \
docker-compose -f "$DOCKER_COMPOSE_FILE" build --no-cache zeebufp

# Start containers
log "📦 Starting containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d zeebufp reverse-proxy

# Run setup commands
log "🧬 Running Laravel setup..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T zeebufp bash -c "
  chown -R www-data:www-data storage bootstrap/cache &&
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
  supervisorctl restart horizon
"

# Update current symlink (after everything succeeds)
log "🔀 Updating current symlink..."
ln -sfn "$NEW_RELEASE_DIR" "$APP_DIR/current"

# Cleanup
log "🧹 Cleaning up old releases (keeping last 5)..."
cd "$RELEASES_DIR"
ls -1t | tail -n +6 | xargs -d '\n' rm -rf -- || true

log "✅ Deployment complete! New release: $TIMESTAMP"
