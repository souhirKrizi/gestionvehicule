# 🚀 Configuration Railway Simplifiée

## Problème Résolu
L'erreur `npm` dans Nixpacks a été corrigée en supprimant les configurations complexes.

## Configuration Actuelle
- ✅ Détection automatique Laravel par Railway
- ✅ Procfile simple pour le serveur
- ✅ Script de build optimisé
- ✅ Configuration SQLite

## Variables à Ajouter sur Railway

Dans votre projet Railway, allez dans **Variables** et ajoutez :

### Variables Essentielles
```
APP_NAME=Military Fleet Management
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:XuvyCgMJdH6yEMmGtIyilBSF3mdjq2RE4kgrw9j1BL0=
```

### Base de Données
```
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
```

### Session et Cache
```
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### Mail
```
MAIL_MAILER=log
MAIL_FROM_ADDRESS=admin@militaryfleet.com
MAIL_FROM_NAME=Military Fleet Management
```

## Étapes de Déploiement

1. **Pousser le code** :
   ```bash
   git add .
   git commit -m "Fix: Configuration Railway simplifiée"
   git push origin main
   ```

2. **Ajouter les variables** sur Railway (voir ci-dessus)

3. **Railway va automatiquement** :
   - Détecter Laravel
   - Installer PHP et Node.js
   - Exécuter `composer install`
   - Exécuter `npm ci && npm run build`
   - Lancer le serveur avec le Procfile

## Si ça ne marche toujours pas

### Option Alternative : Heroku
```bash
# Installer Heroku CLI puis :
heroku create votre-app-name
heroku config:set APP_KEY=base64:XuvyCgMJdH6yEMmGtIyilBSF3mdjq2RE4kgrw9j1BL0=
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
git push heroku main
```

### Option Alternative : Render
1. Créer un compte sur Render.com
2. Connecter GitHub
3. Utiliser le fichier `render.yaml` existant
4. Déployer

## Test Local
```bash
# Tester la configuration de production localement
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install && npm run build
php artisan serve
```

Railway devrait maintenant déployer sans erreur ! 🎉