#!/bin/bash
set -euo pipefail

# Configuration
APP_NAME="zeebufp"
APP_DIR="/home/ubuntu/apps/$APP_NAME"
REPO_URL="git@github.com:kakapa/$APP_NAME.git"
DOCKER_COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"
LOG_FILE="$APP_DIR/deploy.log"

# Logging function
log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "🧼 Cleaning up leftovers (nginx/ssl)..."
sudo rm -rf "$APP_DIR/nginx/ssl" || true

# Initialize directory structure
init_directories() {
  log "📂 Initializing directory structure..."
  sudo mkdir -p "$APP_DIR"/{storage,nginx/ssl,bootstrap/cache}
  sudo mkdir -p "$APP_DIR"/storage/framework/{cache/data,sessions,views}
  sudo mkdir -p "$APP_DIR"/storage/logs
}

# Clean up old Docker artifacts
clean_docker() {
  log "🧹 Cleaning up old Docker artifacts..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" down --remove-orphans --volumes --timeout 30 || true
  docker system prune -af || true
}

# Git operations
git_operations() {
  if [ -d "$APP_DIR/.git" ]; then
    log "🔄 Pulling latest changes..."
    cd "$APP_DIR"
    git reset --hard HEAD
    git clean -fd
    git pull origin main
  else
    log "📥 Cloning repository..."
    sudo rm -rf "$APP_DIR"
    git clone "$REPO_URL" "$APP_DIR"
    cd "$APP_DIR"
  fi
}

# Main deployment function
deploy() {
  log "🚀 Starting deployment of $APP_NAME..."

  # Initialize environment
  init_directories
  cd "$APP_DIR"

  # Get latest code
  git_operations

  # Docker operations
  clean_docker

  log "🐳 Building containers..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" build

  log "🚀 Starting services..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" up -d

  # Wait for services to initialize
  sleep 15

  # Laravel setup inside container
  log "⚙️ Configuring Laravel..."
  docker-compose -f "$DOCKER_COMPOSE_FILE" exec -T $APP_NAME bash -c "
    set -e
    composer install --no-dev --optimize-autoloader --no-interaction
    php artisan migrate --force
    php artisan storage:link
    php artisan optimize
    if [ -e /var/run/supervisor.sock ]; then
        supervisorctl reread
        supervisorctl update
        supervisorctl restart all
    fi
    "

  log "✅ Deployment completed successfully!"
  exit 0
}

# Error handling
trap 'log "❌ Deployment failed with exit code $?"' ERR
deploy
