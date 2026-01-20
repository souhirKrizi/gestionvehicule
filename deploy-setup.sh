#!/bin/bash

echo "🚀 Configuration pour le déploiement..."

# Créer la base de données SQLite si elle n'existe pas
if [ ! -f database/database.sqlite ]; then
    echo "📁 Création de la base de données SQLite..."
    touch database/database.sqlite
fi

# Installation des dépendances
echo "📦 Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader

echo "📦 Installation des dépendances Node.js..."
npm ci

# Génération de la clé d'application si nécessaire
if [ -z "$APP_KEY" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate --force
fi

# Migrations et seeders
echo "🗄️ Exécution des migrations..."
php artisan migrate --force

# Cache des configurations
echo "⚡ Mise en cache des configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build des assets
echo "🎨 Build des assets frontend..."
npm run build

# Permissions
echo "🔐 Configuration des permissions..."
chmod -R 755 storage bootstrap/cache

echo "✅ Configuration terminée ! Prêt pour le déploiement."