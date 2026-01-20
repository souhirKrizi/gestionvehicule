# 🚀 Guide de Déploiement - Military Fleet Management

## Options de Déploiement Gratuit

### 1. 🚂 Railway (Recommandé - Le plus simple)

**Avantages :**
- ✅ Déploiement en 1 clic depuis GitHub
- ✅ Base de données PostgreSQL gratuite incluse
- ✅ SSL automatique
- ✅ 500h/mois gratuites
- ✅ Support PHP/Laravel natif

**Étapes :**
1. Créer un compte sur [Railway.app](https://railway.app)
2. Connecter votre repository GitHub
3. Sélectionner "Deploy from GitHub repo"
4. Railway détecte automatiquement Laravel
5. Ajouter les variables d'environnement :
   ```
   APP_KEY=base64:VOTRE_CLE_GENEREE
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=pgsql
   ```
6. Déploiement automatique !

### 2. 🎨 Render

**Avantages :**
- ✅ 750h/mois gratuites
- ✅ Base de données PostgreSQL gratuite
- ✅ SSL automatique
- ✅ Déploiement automatique depuis Git

**Étapes :**
1. Créer un compte sur [Render.com](https://render.com)
2. Créer un "Web Service"
3. Connecter votre repository GitHub
4. Utiliser le fichier `render.yaml` inclus
5. Configurer les variables d'environnement
6. Déployer !

### 3. 🐙 Heroku (Classique)

**Étapes :**
1. Installer Heroku CLI
2. Créer une app Heroku :
   ```bash
   heroku create votre-app-name
   ```
3. Ajouter le buildpack PHP :
   ```bash
   heroku buildpacks:set heroku/php
   ```
4. Configurer les variables :
   ```bash
   heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   ```
5. Déployer :
   ```bash
   git push heroku main
   ```

### 4. 🌐 Vercel (Pour sites statiques)

Si vous voulez convertir en site statique :
1. Installer Vercel CLI
2. Configurer `vercel.json`
3. Déployer avec `vercel --prod`

## 📋 Checklist Avant Déploiement

### Configuration Requise :
- [ ] Fichier `.env.production` configuré
- [ ] Base de données SQLite créée (`touch database/database.sqlite`)
- [ ] Clé d'application générée (`php artisan key:generate`)
- [ ] Migrations exécutées (`php artisan migrate`)
- [ ] Assets compilés (`npm run build`)
- [ ] Cache configuré (`php artisan config:cache`)

### Variables d'Environnement Essentielles :
```env
APP_NAME="Military Fleet Management"
APP_ENV=production
APP_KEY=base64:VOTRE_CLE_ICI
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=sqlite
DB_DATABASE=/chemin/vers/database.sqlite

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

## 🔧 Scripts Utiles

### Déploiement Local de Test :
```bash
# Tester en mode production localement
php artisan serve --env=production
```

### Réinitialisation Complète :
```bash
php artisan migrate:fresh --seed
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 🌍 Domaine Personnalisé (Optionnel)

### Avec Railway :
1. Aller dans Settings > Domains
2. Ajouter votre domaine personnalisé
3. Configurer les DNS chez votre registrar

### Avec Render :
1. Aller dans Settings > Custom Domains
2. Ajouter votre domaine
3. Configurer les enregistrements DNS

## 🔒 Sécurité en Production

### Variables Sensibles :
- Toujours utiliser `APP_DEBUG=false`
- Générer une nouvelle `APP_KEY` pour la production
- Utiliser HTTPS (automatique sur les plateformes)
- Configurer les CORS si nécessaire

### Base de Données :
- SQLite pour les petites applications
- PostgreSQL pour plus de robustesse (gratuit sur Railway/Render)

## 📊 Monitoring

### Logs :
- Railway : Onglet "Logs" dans le dashboard
- Render : Section "Logs" dans le service
- Heroku : `heroku logs --tail`

### Performance :
- Utiliser `php artisan optimize` avant déploiement
- Activer le cache des configurations
- Minifier les assets avec Vite

## 🆘 Dépannage

### Erreurs Communes :

**"No application encryption key"**
```bash
php artisan key:generate --force
```

**"Permission denied"**
```bash
chmod -R 755 storage bootstrap/cache
```

**"Class not found"**
```bash
composer dump-autoload --optimize
```

## 💡 Conseils

1. **Testez localement** avec `APP_ENV=production` avant de déployer
2. **Utilisez SQLite** pour commencer (simple et gratuit)
3. **Activez les caches** pour de meilleures performances
4. **Surveillez les logs** après déploiement
5. **Configurez un domaine personnalisé** pour plus de professionnalisme

---

🎉 **Votre application Military Fleet Management sera accessible à tous une fois déployée !**