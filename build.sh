#!/bin/bash
set -e

echo "🚀 Starting Laravel build process..."

# Copy .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "📋 Copying .env file..."
    cp .env.example .env
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Generate application key if it doesn't exist
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
fi

# Create necessary directories
echo "📁 Creating required directories..."
mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# Create SQLite database if it doesn't exist
echo "🗄️ Creating database..."
touch database/database.sqlite

# Set permissions
chmod -R 775 storage bootstrap/cache
chmod 664 database/database.sqlite 2>/dev/null || true

# Run migrations
echo "🔄 Running migrations..."
php artisan migrate --force --no-interaction

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm ci --silent

# Ensure Vite is available
if ! command -v vite &> /dev/null; then
    echo "⚡ Vite not found, installing globally..."
    npm install -g vite
fi

# Build assets
echo "🎨 Building assets..."
npm run build

# Cache configurations
echo "⚡ Caching configurations..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "✅ Build completed successfully!"

echo "✅ Build terminé !"