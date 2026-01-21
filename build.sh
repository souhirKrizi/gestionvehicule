#!/bin/bash
set -e

echo "🚀 Starting Laravel build process..."

# Set NODE_ENV to production
export NODE_ENV=production

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
# Clean npm cache and node_modules to prevent any conflicts
rm -rf node_modules/
npm cache clean --force

# Install dependencies with legacy peer deps to avoid peer dependency issues
npm ci --legacy-peer-deps

# Ensure Vite is available
echo "🔍 Verifying Vite installation..."
if ! command -v vite &> /dev/null; then
    echo "⚡ Vite not found in PATH, installing globally..."
    npm install -g vite@4.5.0
fi

# Ensure local Vite is available
if [ ! -f node_modules/.bin/vite ]; then
    echo "📦 Installing Vite locally..."
    npm install --save-dev vite@4.5.0
fi

# Build assets
echo "🎨 Building assets..."
# Use local Vite binary explicitly
./node_modules/.bin/vite build

# Double check if build was successful
if [ $? -ne 0 ]; then
    echo "❌ Vite build failed, trying alternative approach..."
    # Try with npx as fallback
    npx vite build || {
        echo "❌ All build attempts failed"
        exit 1
    }
fi

# Cache configurations
echo "⚡ Caching configurations..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "✅ Build completed successfully!"

echo "✅ Build terminé !"