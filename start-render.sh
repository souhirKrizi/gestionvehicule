#!/bin/bash
set -e

echo "🚀 Démarrage de l'application sur Render.com..."

# Vérifier que le manifest Vite existe
if [ ! -f /app/public/build/manifest.json ]; then
    echo "📦 Vite manifest non trouvé, reconstruction des assets..."
    npm ci --silent
    npm run build
fi

# Vérifier que la base de données existe et est initialisée
if [ ! -f /app/database/database.sqlite ] || [ ! -s /app/database/database.sqlite ]; then
    echo "📁 Initialisation de la base de données..."
    touch /app/database/database.sqlite
    php artisan migrate --force
    php artisan db:seed --force
fi

# Nettoyer les caches
echo "🧹 Nettoyage des caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Optimiser pour la production
echo "⚡ Optimisation..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer le serveur sur le port fourni par Render
echo "🌐 Démarrage du serveur sur le port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT