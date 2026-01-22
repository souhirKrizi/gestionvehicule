#!/bin/bash

# 🚀 Script de Déploiement - Gestion de Véhicule
# Cet script configure tout pour rendre l'application accessible

set -e

echo "🚀 Démarrage du déploiement - Gestion de Véhicule"
echo "=================================================="

# 1. Vérifier les prérequis
echo ""
echo "1️⃣ Vérification des prérequis..."
php -v | head -1
composer --version
npm --version

# 2. Nettoyer les caches
echo ""
echo "2️⃣ Nettoyage des caches..."
php artisan optimize:clear 2>/dev/null || true

# 3. Installer les dépendances
echo ""
echo "3️⃣ Installation des dépendances..."
composer install --no-dev --optimize-autoloader --no-interaction
npm ci
npm run build

# 4. Configuration de l'environnement
echo ""
echo "4️⃣ Configuration de l'environnement..."
cp .env.production .env
php artisan key:generate --force

# 5. Base de données
echo ""
echo "5️⃣ Configuration de la base de données..."
php artisan migrate --force
php artisan db:seed --force

# 6. Optimisation
echo ""
echo "6️⃣ Optimisation pour la production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 7. Permissions
echo ""
echo "7️⃣ Configuration des permissions..."
chmod -R 775 storage bootstrap/cache || true
chmod -R 775 database || true

# 8. Tests finaux
echo ""
echo "8️⃣ Tests de validation..."
php artisan route:list | head -20
echo ""
echo "✅ Vérification des migrations..."
php artisan migrate:status

echo ""
echo "=================================================="
echo "✅ DÉPLOIEMENT RÉUSSI!"
echo "=================================================="
echo ""
echo "🌐 Application disponible sur: http://localhost:8000"
echo ""
echo "👤 Comptes de test:"
echo "   Admin:  admin@gmail.com / admin123"
echo "   User 1: user1@gmail.com / user123"
echo "   User 2: user2@gmail.com / user123"
echo ""
echo "📊 Pour démarrer le serveur:"
echo "   php artisan serve --host=0.0.0.0 --port=8000"
echo ""
echo "📚 Documentation: Consultez DEPLOYMENT.md"
echo ""
