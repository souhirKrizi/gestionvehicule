#!/bin/bash
set -e

echo "🚀 Build pour Render.com - Laravel App"

# Vérifier l'environnement
echo "📋 Vérification de l'environnement..."
echo "Node version: $(node --version)"
echo "NPM version: $(npm --version)"
echo "PHP version: $(php --version | head -n 1)"

# Installation de Composer si nécessaire
if ! command -v composer &> /dev/null; then
    echo "📦 Installation de Composer..."
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer
fi

echo "Composer version: $(composer --version)"

# Installation des dépendances PHP
echo "📦 Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader --no-interaction --verbose

# Installation des dépendances Node.js
echo "📦 Installation des dépendances Node.js..."
npm ci --silent

# Build des assets
echo "🎨 Build des assets avec Vite..."
npm run build

# Copier le fichier d'environnement
echo "📋 Configuration de l'environnement..."
cp .env.render .env

# Créer les répertoires nécessaires
echo "📁 Création des répertoires..."
mkdir -p database
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions  
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Créer la base de données SQLite
echo "🗄️ Création de la base de données SQLite..."
touch database/database.sqlite

# Définir les permissions
echo "🔐 Configuration des permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 664 database/database.sqlite

# Générer la clé d'application
echo "🔑 Génération de la clé d'application..."
php artisan key:generate --force --no-interaction

# Exécuter les migrations
echo "🔄 Exécution des migrations..."
php artisan migrate --force --no-interaction

# Exécuter les seeders
echo "🌱 Exécution des seeders..."
php artisan db:seed --force --no-interaction

# Optimiser Laravel pour la production
echo "⚡ Optimisation Laravel..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "✅ Build terminé avec succès !"