#!/bin/bash

# Script de démarrage simple pour Railway
echo "🚀 Démarrage de l'application Laravel..."

# S'assurer que la base de données existe
if [ ! -f database/database.sqlite ]; then
    echo "📁 Création de la base de données SQLite..."
    touch database/database.sqlite
fi

# Exécuter les migrations si nécessaire
echo "🔄 Vérification des migrations..."
php artisan migrate --force --no-interaction

# Démarrer le serveur
echo "🌐 Démarrage du serveur sur le port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT