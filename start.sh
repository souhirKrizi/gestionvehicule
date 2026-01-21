#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Set working directory
cd /app || exit 1

# Load NVM
export NVM_DIR="/usr/local/nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# Add NVM to PATH
export PATH="$NVM_DIR/versions/node/v20.19.0/bin:$PATH"

# Verify Node.js and npm are available
echo "🔍 Checking Node.js and npm..."
node --version || { echo "❌ Node.js is not installed"; exit 1; }
npm --version || { echo "❌ npm is not installed"; exit 1; }

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