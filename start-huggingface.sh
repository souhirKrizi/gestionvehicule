#!/bin/bash
set -e

echo "🚀 Démarrage de l'application sur Hugging Face Spaces..."

# Vérifier que la base de données existe et est initialisée
if [ ! -f /app/database/database.sqlite ] || [ ! -s /app/database/database.sqlite ]; then
    echo "📁 Initialisation de la base de données..."
    touch /app/database/database.sqlite
    php artisan migrate --force
    php artisan db:seed --force
fi

# Nettoyer les caches
echo "🧹 Nettoyage des caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimiser pour la production
echo "⚡ Optimisation..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer le serveur sur le port 7860 (requis par Hugging Face)
echo "🌐 Démarrage du serveur sur le port 7860..."
exec php artisan serve --host=0.0.0.0 --port=7860