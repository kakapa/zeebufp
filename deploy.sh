#!/bin/bash

set -e

APP_DIR="/home/ubuntu/apps/zeebufp"
cd "$APP_DIR" || exit

echo "🚀 Pulling latest code..."
git pull origin main

echo "📦 Running composer update..."
./vendor/bin/sail composer update --no-interaction --prefer-dist --optimize-autoloader

echo "📦 Installing npm packages..."
./vendor/bin/sail npm install

echo "🛠️ Building frontend..."
./vendor/bin/sail npm run build

echo "🧬 Running migrations..."
./vendor/bin/sail artisan migrate --force

echo "🔗 Linking storage..."
./vendor/bin/sail artisan storage:link

echo "⚙️  Clear cache for config, routes & view..."
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear

echo "⚙️  Caching config, view and routes..."
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache

echo "✅ Deployment completed!"
