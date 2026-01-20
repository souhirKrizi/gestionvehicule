#!/bin/bash
set -e

echo "🚀 Début du processus de build..."

# Copier le fichier d'environnement
echo "📋 Configuration de l'environnement..."
cp .env.example .env

# Installation des dépendances sans scripts
echo "📦 Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Génération de la clé d'application
echo "🔑 Génération de la clé d'application..."
php artisan key:generate --force --no-interaction

# Création de la base de données SQLite
echo "🗄️ Création de la base de données..."
touch database/database.sqlite

# Exécution des migrations
echo "🔄 Exécution des migrations..."
php artisan migrate --force --no-interaction

# Installation des dépendances Node.js
echo "📦 Installation des dépendances Node.js..."
npm ci --silent

# Build des assets
echo "🎨 Build des assets..."
npm run build

# Cache des configurations
echo "⚡ Mise en cache des configurations..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

# Découverte des packages (maintenant que tout est configuré)
echo "🔍 Découverte des packages..."
php artisan package:discover --ansi

echo "✅ Build terminé avec succès !"