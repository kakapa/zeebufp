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

# === TARGETED CLEANUP TO AVOID 'ContainerConfig' ERROR ===
log "🧼 Removing Docker containers for $APP_NAME..."
docker ps -a --filter "name=${APP_NAME}" --format "{{.ID}}" | xargs -r docker rm -f

log "🧹 Removing Docker image for $APP_NAME..."
docker images "${IMAGE_NAME}" --format "{{.ID}}" | xargs -r docker rmi -f

log "🧽 Removing dangling volumes for $APP_NAME..."
docker volume ls --filter "dangling=true" --format "{{.Name}}" | grep "$APP_NAME" | xargs -r docker volume rm

log "🌐 Removing networks named ${APP_NAME}_* (if any)..."
docker network ls --filter "name=${APP_NAME}_" --format "{{.Name}}" | xargs -r docker network rm

# === BUILD AND DEPLOY ===
if ! docker network ls --filter name=^app-net$ --format '{{.Name}}' | grep -wq app-net; then
  docker network create app-net
fi

# === BUILD AND START ===
log "🐳 Building Docker containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" build

log "🚀 Starting containers..."
docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

# === LARAVEL TASKS ===
log "⚙️ Running Laravel setup inside container..."
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

log "✅ Deployment complete!"
