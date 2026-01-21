#!/bin/bash

echo "🚀 Déploiement sur Railway..."

# Copier le fichier de configuration de production
cp .env.production .env

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Construire les assets
npm ci
npm run build

# Nettoyer le cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Prêt pour le déploiement Railway"