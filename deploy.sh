#!/bin/bash

set -e

APP_NAME="zeebufp"
BASE_DIR="/home/ubuntu/apps"
APP_DIR="$BASE_DIR/$APP_NAME"
COMMIT_FILE="$APP_DIR/.last-deploy-commit"

cd "$APP_DIR" || exit

echo "🔍 Checking for updates..."
git fetch origin main
LOCAL_COMMIT=$(git rev-parse HEAD)
REMOTE_COMMIT=$(git rev-parse origin/main)

if [ "$LOCAL_COMMIT" = "$REMOTE_COMMIT" ]; then
    echo "✅ Already up to date. No deployment needed."
    exit 0
fi

echo "🚀 Pulling latest code..."
git pull origin main

# Check for rebuild trigger
REBUILD_NEEDED=false
if git diff --name-only "$LOCAL_COMMIT" "$REMOTE_COMMIT" | grep -E "Dockerfile|docker-compose.yml|composer.json|package.json|vite.config|\.env"; then
    REBUILD_NEEDED=true
fi

cd "$BASE_DIR" # Go to folder where docker-compose.yml is

if [ "$REBUILD_NEEDED" = true ]; then
    echo "📦 Changes detected that require a rebuild..."
    docker-compose build --no-cache "$APP_NAME"
    docker-compose up -d "$APP_NAME"
else
    echo "♻️ No rebuild needed. Just restarting container..."
    docker-compose restart "$APP_NAME"
fi

echo "🧬 Running Laravel tasks..."

if [ -n "$CI" ]; then
  DOCKER_EXEC="docker-compose exec -T $APP_NAME"
else
  DOCKER_EXEC="docker-compose exec $APP_NAME"
fi

$DOCKER_EXEC composer install --no-dev --optimize-autoloader
$DOCKER_EXEC npm install
$DOCKER_EXEC npm run build
$DOCKER_EXEC php artisan migrate --force
$DOCKER_EXEC php artisan storage:link
$DOCKER_EXEC php artisan config:clear
$DOCKER_EXEC php artisan route:clear
$DOCKER_EXEC php artisan view:clear
$DOCKER_EXEC php artisan config:cache
$DOCKER_EXEC php artisan route:cache
$DOCKER_EXEC php artisan view:cache
$DOCKER_EXEC php artisan horizon:terminate

# Save deployed commit hash
NEW_COMMIT=$(git rev-parse HEAD)
echo "$NEW_COMMIT" > "$COMMIT_FILE"
echo "📌 Deployed commit: $NEW_COMMIT"

echo "✅ Deployment completed!"
