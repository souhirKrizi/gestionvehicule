#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Set working directory
cd /app || exit 1

# Ajouter /usr/local/bin au PATH au cas où
PATH="/usr/local/bin:$PATH"

# Vérification de l'environnement
echo "🔍 Checking environment..."
echo "PATH: $PATH"

# Vérifier l'accès à Node.js et npm
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed or not in PATH"
    echo "Trying to find Node.js..."
    find / -name node -type f 2>/dev/null || echo "Node.js not found"
    exit 1
fi

if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed or not in PATH"
    echo "Trying to find npm..."
    find / -name npm -type f 2>/dev/null || echo "npm not found"
    exit 1
fi

# Afficher les informations de version
echo "✅ Node.js version: $(node --version)"
echo "✅ npm version: $(npm --version)"
echo "✅ PHP version: $(php -v | head -n 1)"

# Afficher les chemins complets
echo "📁 Node.js path: $(which node)"
echo "📁 npm path: $(which npm)"

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