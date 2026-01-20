@echo off
REM 🚀 Script de Déploiement Windows - Gestion de Véhicule

echo.
echo 🚀 DEMARRAGE DU DEPLOIEMENT - Gestion de Vehicule
echo ==================================================
echo.

REM 1. Vérifier les prérequis
echo 1️⃣ Verification des prerequis...
php -v | findstr /R "PHP"
composer --version
npm --version

REM 2. Nettoyer les caches
echo.
echo 2️⃣ Nettoyage des caches...
php artisan optimize:clear 2>nul

REM 3. Installer les dépendances
echo.
echo 3️⃣ Installation des dependances...
call composer install --no-dev --optimize-autoloader --no-interaction
call npm ci
call npm run build

REM 4. Configuration de l'environnement
echo.
echo 4️⃣ Configuration de l'environnement...
copy .env.production .env /Y
php artisan key:generate --force

REM 5. Base de données
echo.
echo 5️⃣ Configuration de la base de donnees...
php artisan migrate --force
php artisan db:seed --force

REM 6. Optimisation
echo.
echo 6️⃣ Optimisation pour la production...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

REM 7. Vérifications finales
echo.
echo 7️⃣ Verification des migrations...
php artisan migrate:status

echo.
echo ==================================================
echo ✅ DEPLOIEMENT REUSSI!
echo ==================================================
echo.
echo 🌐 Application disponible sur: http://localhost:8000
echo.
echo 👤 Comptes de test:
echo    Admin:  admin@gmail.com / admin123
echo    User 1: user1@gmail.com / user123
echo    User 2: user2@gmail.com / user123
echo.
echo 📊 Pour demarrer le serveur:
echo    php artisan serve --host=0.0.0.0 --port=8000
echo.
echo 📚 Documentation: Consultez DEPLOYMENT.md
echo.
pause
