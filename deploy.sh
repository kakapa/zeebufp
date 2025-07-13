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

# === CLONE OR PULL LATEST CODE ===
if [ -d "$APP_DIR/.git" ]; then
  log "📥 Pulling latest changes..."
  cd "$APP_DIR"
  git reset --hard
  git pull origin main
else
  log "📥 Cloning repository..."
  rm -rf "$APP_DIR"
  git clone "$REPO_URL" "$APP_DIR"
fi

cd "$APP_DIR"

# === DOCKER CLEANUP ===
log "🧼 Removing Docker containers for $APP_NAME..."
docker ps -a --filter "name=${APP_NAME}" --format "{{.ID}}" | xargs -r docker rm -f || true

log "🧹 Removing Docker images for $APP_NAME..."
docker images --filter "reference=*${APP_NAME}*" --format "{{.ID}}" | xargs -r docker rmi -f || true

log "🧽 Removing dangling volumes..."
docker volume prune -f || true

log "🌐 Removing networks named ${APP_NAME}_*..."
docker network ls --filter "name=${APP_NAME}_" --format "{{.Name}}" | xargs -r docker network rm || true

# === BUILD AND DEPLOY ===
if ! docker network ls --filter name=^app-net$ --format '{{.Name}}' | grep -wq app-net; then
  docker network create app-net
fi

# === BUILD AND START ===
log "🐳 Building Docker containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" build

log "🚀 Starting containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

# === LARAVEL SETUP ===
log "⚙️ Configuring Laravel..."
docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
  set -e
  git config --global --add safe.directory /var/www/html
  composer update --lock
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan storage:link || true
  php artisan optimize:clear
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  if [ -e /var/run/supervisor.sock ]; then
    supervisorctl reread
    supervisorctl update
    supervisorctl restart horizon
  fi
"

log "✅ Deployment complete!"
