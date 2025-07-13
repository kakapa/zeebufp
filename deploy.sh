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

# Ensure script is not run as root
if [[ "$(id -u)" -eq 0 ]]; then
  echo "❌ Do not run this script as root"
  exit 1
fi

log "🧼 Cleaning up old app state..."
mkdir -p "$APP_DIR"
touch "$LOG_FILE"

# Fix repo ownership so git can write
sudo chown -R ubuntu:ubuntu "$APP_DIR"

# Clone or update repo
update_code() {
  if [ -d "$APP_DIR/.git" ]; then
    log "🔄 Pulling latest changes..."
    cd "$APP_DIR"
    git config --global --add safe.directory "$APP_DIR"
    git reset --hard HEAD
    git pull origin main
  else
    log "📥 Cloning repository..."
    rm -rf "$APP_DIR"
    git clone "$REPO_URL" "$APP_DIR"
    cd "$APP_DIR"
  fi
}

# Clean containers/images related to this app only
clean_docker() {
  # === DOCKER CLEANUP ===
  log "🧼 Removing Docker containers for $APP_NAME..."
  docker ps -a --filter "name=${APP_NAME}" --format "{{.ID}}" | xargs -r docker rm -f || true

  log "🧹 Removing Docker images for $APP_NAME..."
  docker images --filter "reference=*${APP_NAME}*" --format "{{.ID}}" | xargs -r docker rmi -f || true

  log "🧽 Removing dangling volumes..."
  docker volume prune -f || true

  log "🌐 Removing networks named ${APP_NAME}_*..."
  docker network ls --filter "name=${APP_NAME}_" --format "{{.Name}}" | xargs -r docker network rm || true
}

# Permissions setup
fix_permissions() {
  log "🔐 Fixing permissions for Laravel..."
  mkdir -p "$APP_DIR/storage/logs" "$APP_DIR/bootstrap/cache"
  sudo chown -R ubuntu:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
  sudo chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
}

deploy() {
  log "🚀 Starting deployment..."

  # === BUILD AND DEPLOY ===
  if ! docker network ls --filter name=^app-net$ --format '{{.Name}}' | grep -wq app-net; then
   docker network create app-net
  fi

  # Fix repo ownership so git can write
  sudo chown -R ubuntu:ubuntu "$APP_DIR"
  update_code
  cd "$APP_DIR"

  fix_permissions

  clean_docker

  log "🐳 Building app container..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" build

  log "🚀 Starting services..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

  log "⚙️ Running Laravel setup..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T "$APP_NAME" bash -c "
    git config --global --add safe.directory /var/www/html
    composer install --no-dev --optimize-autoloader --no-interaction
    php artisan migrate --force
    php artisan storage:link
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
}

trap 'log "❌ Deployment failed with exit code $?"' ERR
deploy
