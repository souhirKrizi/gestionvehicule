#!/bin/bash
set -e

echo "🚀 Début du build Laravel..."

# Copier le fichier d'environnement si nécessaire
if [ ! -f .env ]; then
    echo "📋 Copie du fichier .env..."
    cp .env.example .env
fi

# Installation des dépendances PHP
echo "📦 Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

# Génération de la clé si elle n'existe pas
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate --force --no-interaction
fi

# Création des répertoires nécessaires
echo "📁 Création des répertoires..."
mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# Création de la base de données SQLite
echo "🗄️ Création de la base de données..."
touch database/database.sqlite

# Permissions
chmod -R 775 storage bootstrap/cache
chmod 664 database/database.sqlite 2>/dev/null || true

# Exécution des migrations
echo "🔄 Exécution des migrations..."
php artisan migrate --force --no-interaction

# Installation des dépendances Node.js et build
echo "📦 Installation des dépendances Node.js..."
npm ci --silent

echo "🎨 Build des assets..."
npm run build

# Cache des configurations
echo "⚡ Mise en cache..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction  
php artisan view:cache --no-interaction

echo "✅ Build terminé !"