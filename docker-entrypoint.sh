#!/bin/bash
set -e

# Génération de la clé d'application
if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Configuration du cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécution des migrations (à décommenter si nécessaire)
# php artisan migrate --force

exec apache2-foreground
