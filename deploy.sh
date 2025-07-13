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

# === BUILD AND DEPLOY ===
if ! docker network ls --filter name=^app-net$ --format '{{.Name}}' | grep -wq app-net; then
  docker network create app-net
fi

cd "$APP_DIR"

# === DOCKER CLEANUP (PREVENT 'ContainerConfig' ERROR) ===
log "🧼 Cleaning up Docker state..."
docker-compose -f "$DOCKER_COMPOSE_FILE" down -v --remove-orphans || true
docker container prune -f || true
docker image prune -af || true
docker volume prune -f || true
docker network prune -f || true

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
