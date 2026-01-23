#!/bin/bash
set -e

echo "🚀 Build pour Render.com..."

# Vérifier que nous avons les outils nécessaires
which php || { echo "❌ PHP non trouvé"; exit 1; }
which composer || { echo "❌ Composer non trouvé"; exit 1; }
which node || { echo "❌ Node.js non trouvé"; exit 1; }
which npm || { echo "❌ NPM non trouvé"; exit 1; }

echo "✅ Tous les outils sont disponibles"

# Installation des dépendances PHP
echo "📦 Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

# Installation des dépendances Node.js
echo "📦 Installation des dépendances Node.js..."
npm ci --silent

# Build des assets
echo "🎨 Build des assets..."
npm run build

# Créer les répertoires nécessaires
echo "📁 Création des répertoires..."
mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# Créer la base de données SQLite
echo "🗄️ Création de la base de données..."
touch database/database.sqlite

# Permissions
echo "🔐 Configuration des permissions..."
chmod -R 775 storage bootstrap/cache database

echo "✅ Build terminé avec succès !"