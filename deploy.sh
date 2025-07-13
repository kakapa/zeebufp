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

log "🚀 Starting deployment of $APP_NAME to $APP_DIR..."

log "📦 Cloning latest code..."
rm -rf "$APP_DIR"/*
git clone --depth=1 "$REPO_URL" "$APP_DIR"

cd "$APP_DIR"

log "🐳 Building Docker containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" build

log "🚀 Starting containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

log "⚙️ Running Laravel setup..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan storage:link || true
  php artisan config:clear || true
  php artisan route:clear || true
  php artisan view:clear || true
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan horizon:terminate || true
  if [ -e /var/run/supervisor.sock ]; then
    supervisorctl reread || true
    supervisorctl update || true
    supervisorctl restart horizon || true
  else
    echo '⚠️ Supervisor socket not found — skipping Horizon restart'
  fi
"

log "✅ Deployment finished!"
