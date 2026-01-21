#!/bin/bash

# Script de démarrage pour Railway
echo "🚀 Démarrage de l'application Laravel..."

# Créer le répertoire de base de données s'il n'existe pas
mkdir -p database

# S'assurer que la base de données existe
if [ ! -f database/database.sqlite ]; then
    echo "📁 Création de la base de données SQLite..."
    touch database/database.sqlite
fi

# Donner les permissions appropriées
chmod 664 database/database.sqlite
chmod 775 database

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
php artisan serve --host=0.0.0.0 --port=$PORT