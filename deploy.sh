#!/bin/bash

# ============================================================
# deploy.sh — Safe deployment script for Railway/production
# Prevents product images from disappearing on each push.
# ============================================================
#
# USAGE: Run this after each git push on your Railway server
# or add it as your Railway Start Command in railway.toml
#

set -e

echo "🚀 Starting deployment..."

# Install dependencies (no dev packages in production)
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run only NEW migrations (never --fresh on production!)
echo "📦 Running migrations..."
php artisan migrate --force

# Do NOT run db:seed here — seeder runs only on first setup
# php artisan db:seed  ← REMOVED to prevent seeder data from overwriting real data

# Clear and rebuild caches
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Re-link storage (safe to run repeatedly)
echo "🔗 Linking storage..."
php artisan storage:link || true

# Build frontend assets
echo "🎨 Building assets..."
npm ci
npm run build

echo "✅ Deployment complete!"
