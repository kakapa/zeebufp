#!/bin/bash

set -e

APP_NAME="zeebufp"
APP_DIR="/home/ubuntu/apps/$APP_NAME"
COMMIT_FILE=".last-deploy-commit"

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

if [ "$REBUILD_NEEDED" = true ]; then
    echo "📦 Changes detected that require a rebuild..."
    docker-compose build "$APP_NAME"
    docker-compose up -d "$APP_NAME"
else
    echo "♻️ No rebuild needed. Just restarting container..."
    docker-compose restart "$APP_NAME"
fi

echo "🧬 Running Laravel tasks..."
docker-compose exec "$APP_NAME" composer update
docker-compose exec "$APP_NAME" npm install
docker-compose exec "$APP_NAME" npm run build
docker-compose exec "$APP_NAME" php artisan migrate --force
docker-compose exec "$APP_NAME" php artisan storage:link
docker-compose exec "$APP_NAME" php artisan config:clear
docker-compose exec "$APP_NAME" php artisan route:clear
docker-compose exec "$APP_NAME" php artisan view:clear
docker-compose exec "$APP_NAME" php artisan config:cache
docker-compose exec "$APP_NAME" php artisan route:cache
docker-compose exec "$APP_NAME" php artisan view:cache

# Tag this deployment version
NEW_COMMIT=$(git rev-parse HEAD)
echo "$NEW_COMMIT" > "$COMMIT_FILE"
echo "📌 Deployed commit: $NEW_COMMIT"

echo "✅ Deployment completed!"
