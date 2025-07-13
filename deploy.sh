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
  fi
}

# Clean containers/images related to this app only
clean_docker() {
  log "🧹 Stopping old containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans --timeout 30 || true

  log "🧹 Removing dangling images (only if unused)..."
  docker image prune -f
}

deploy() {
  log "🚀 Starting deployment..."

  update_code
  cd "$APP_DIR"

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
