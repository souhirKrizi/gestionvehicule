#!/bin/bash
set -e

echo "🚀 Démarrage de l'application Laravel sur Render..."

# Vérifier que la base de données existe
if [ ! -f database/database.sqlite ]; then
    echo "📁 Création de la base de données..."
    touch database/database.sqlite
    php artisan migrate --force --no-interaction
    php artisan db:seed --force --no-interaction
fi

# Nettoyer les caches si nécessaire
echo "🧹 Nettoyage des caches..."
php artisan config:clear --no-interaction || true
php artisan route:clear --no-interaction || true
php artisan view:clear --no-interaction || true

# Recréer les caches
echo "⚡ Recréation des caches..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

# Démarrer le serveur Laravel
echo "🌐 Démarrage du serveur sur le port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT