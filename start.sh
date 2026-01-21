#!/bin/bash
set -e

# Script de démarrage pour Railway
echo "🚀 Démarrage de l'application Laravel..."

# Vérifier que nous sommes dans le bon répertoire
cd /app || exit 1

# Installer/mettre à jour les dépendances Composer
echo "📦 Installation des dépendances..."
composer install --no-dev --optimize-autoloader --no-interaction

# Créer les répertoires nécessaires
mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# S'assurer que la base de données existe
if [ ! -f database/database.sqlite ]; then
    echo "📁 Création de la base de données SQLite..."
    touch database/database.sqlite
fi

# Donner les permissions appropriées
chmod -R 775 storage bootstrap/cache
chmod 664 database/database.sqlite 2>/dev/null || true

# Nettoyer les caches existants
echo "🧹 Nettoyage des caches..."
php artisan config:clear --no-interaction || true
php artisan route:clear --no-interaction || true
php artisan view:clear --no-interaction || true
php artisan cache:clear --no-interaction || true

# Générer la clé d'application si nécessaire
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate --no-interaction --force
fi

# Optimiser Laravel pour la production
echo "⚡ Optimisation de Laravel..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

# Exécuter les migrations
echo "🔄 Exécution des migrations..."
php artisan migrate --force --no-interaction

# Démarrer le serveur
echo "🌐 Démarrage du serveur sur le port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT