#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Set working directory
cd /app || exit 1

# Définir le PATH pour inclure les binaires Node.js
export PATH="/usr/local/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"

# Vérification de l'environnement
echo "🔍 Checking environment..."
echo "PATH: $PATH"
echo "Current directory: $(pwd)"

# Vérifier l'accès à Node.js et npm
NODE_PATH=$(command -v node || echo "")
NPM_PATH=$(command -v npm || echo "")

if [ -z "$NODE_PATH" ]; then
    echo "❌ Node.js is not installed or not in PATH"
    echo "Searching for Node.js..."
    find / -name node -type f 2>/dev/null | grep -v "node_modules" || echo "Node.js not found"
    exit 1
else
    echo "✅ Found Node.js at: $NODE_PATH"
    echo "✅ Node.js version: $(node --version)"
fi

if [ -z "$NPM_PATH" ]; then
    echo "❌ npm is not installed or not in PATH"
    echo "Searching for npm..."
    find / -name npm -type f 2>/dev/null | grep -v "node_modules" || echo "npm not found"
    exit 1
else
    echo "✅ Found npm at: $NPM_PATH"
    echo "✅ npm version: $(npm --version)"
fi

echo "✅ PHP version: $(php -v | head -n 1)"

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories
echo "📂 Creating required directories..."
mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# Set permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chmod 664 database/database.sqlite 2>/dev/null || true

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
if [ -f "/usr/local/bin/npm" ]; then
    /usr/local/bin/npm ci --silent --legacy-peer-deps
else
    npm ci --silent --legacy-peer-deps
fi

# Build assets
echo "🎨 Building assets..."
if [ -f "/usr/local/bin/npx" ]; then
    /usr/local/bin/npx vite build
else
    npx vite build
fi

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear --no-interaction
php artisan route:clear --no-interaction
php artisan view:clear --no-interaction
php artisan cache:clear --no-interaction

# Generate application key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --no-interaction --force
fi

# Optimize Laravel for production
echo "⚡ Optimizing Laravel..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

# Run migrations
echo "🔄 Running migrations..."
php artisan migrate --force --no-interaction

# Start the server
echo "🌐 Démarrage du serveur sur le port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT