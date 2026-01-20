#!/bin/bash

# Arrêter le script en cas d'erreur
set -e

# Afficher les commandes exécutées
set -x

# Installer les dépendances PHP
composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Créer le fichier .env pour la production
if [ ! -f ".env" ]; then
    cp .env.example .env
    # Générer une clé d'application
    php artisan key:generate
fi

# Configurer les permissions des dossiers
chmod -R 777 storage bootstrap/cache

# Créer les dossiers de stockage s'ils n'existent pas
mkdir -p storage/framework/{sessions,views,cache}

# Nettoyer le cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Installer et compiler les assets
if [ -f "package.json" ]; then
    npm install
    npm run build
fi

# Créer un lien symbolique pour le stockage
php artisan storage:link

# Nettoyer les anciens fichiers compilés
php artisan optimize:clear
