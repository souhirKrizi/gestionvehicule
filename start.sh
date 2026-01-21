#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Set working directory
cd /app || exit 1

# Définir le PATH pour inclure les binaires Node.js
export PATH="/usr/local/bin:/usr/local/sbin:/usr/bin:/bin:/usr/sbin:/sbin"

# Configuration de la base de données SQLite
SQLITE_DB_PATH="/app/database/database.sqlite"
SQLITE_DIR="/app/database"

# Créer le répertoire de la base de données s'il n'existe pas
if [ ! -d "$SQLITE_DIR" ]; then
    echo "🔧 Creating database directory..."
    mkdir -p "$SQLITE_DIR"
    chmod -R 755 "$SQLITE_DIR"
    echo "✅ Database directory created at $SQLITE_DIR"
fi

# Créer le fichier de base de données s'il n'existe pas
if [ ! -f "$SQLITE_DB_PATH" ]; then
    echo "🔧 Creating SQLite database file..."
    touch "$SQLITE_DB_PATH"
    chmod 666 "$SQLITE_DB_PATH"
    echo "✅ SQLite database created at $SQLITE_DB_PATH"
    
    # Exécuter les migrations après la création de la base de données
    echo "🔄 Running database migrations..."
    php artisan migrate --force
    
    # Exécuter les seeders si nécessaire
    # php artisan db:seed --force
else
    echo "ℹ️  SQLite database already exists at $SQLITE_DB_PATH"
fi

# Vérification de l'environnement
echo "🔍 Checking environment..."
echo "PATH: $PATH"
echo "Current directory: $(pwd)"
echo "SQLite database: $SQLITE_DB_PATH"

# Vérifier l'accès à Node.js et npm
echo "🔍 Checking Node.js installation..."
if command -v node >/dev/null 2>&1; then
    NODE_PATH=$(which node)
    echo "✅ Found Node.js at: $NODE_PATH"
    echo "✅ Node.js version: $(node --version)"
    
    # Vérifier npm
    if command -v npm >/dev/null 2>&1; then
        NPM_PATH=$(which npm)
        echo "✅ Found npm at: $NPM_PATH"
        echo "✅ npm version: $(npm --version)"
    else
        echo "❌ npm not found in PATH"
        exit 1
    fi
else
    echo "❌ Node.js not found in PATH"
    echo "Trying to find Node.js in common locations..."
    
    # Vérifier dans les emplacements courants
    POSSIBLE_PATHS=(
        "/usr/local/bin/node"
        "/usr/bin/node"
        "/opt/homebrew/bin/node"
        "/usr/local/n/versions/node/*/bin/node"
    )
    
    FOUND=0
    for path in "${POSSIBLE_PATHS[@]}"; do
        if [ -f "$path" ] || [ -n "$(ls -d $path 2>/dev/null)" ]; then
            export PATH="$(dirname $path):$PATH"
            echo "✅ Found Node.js at: $(which node)"
            echo "✅ Node.js version: $(node --version)"
            FOUND=1
            break
        fi
    done
    
    if [ $FOUND -eq 0 ]; then
        echo "❌ Node.js not found in common locations"
        echo "Trying to install Node.js..."
        
        # Tenter d'installer Node.js via apt si disponible
        if command -v apt-get >/dev/null 2>&1; then
            echo "Installing Node.js via apt..."
            curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
                && apt-get install -y nodejs \
                && npm install -g npm@latest
            
            if [ $? -eq 0 ]; then
                echo "✅ Node.js installed successfully"
                echo "✅ Node.js version: $(node --version)"
                echo "✅ npm version: $(npm --version)"
            else
                echo "❌ Failed to install Node.js"
                exit 1
            fi
        else
            echo "❌ Cannot install Node.js (apt not available)"
            exit 1
        fi
    fi
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