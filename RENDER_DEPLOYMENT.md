# Déploiement sur Render.com

## 🔧 Configuration pour corriger l'erreur 127

L'erreur 127 "command not found" sur Render indique que certaines commandes ne sont pas trouvées. Voici la solution :

### 1. **Utiliser le Dockerfile spécialisé**

Render doit utiliser `Dockerfile.render` qui contient :
- Installation correcte de PHP 8.2
- Installation de Node.js 20
- Installation de Composer
- Configuration SQLite

### 2. **Configuration dans Render Dashboard**

1. Allez dans votre service sur render.com
2. **Settings** → **Build & Deploy**
3. Changez la configuration :
   - **Environment** : Docker
   - **Dockerfile Path** : `./Dockerfile.render`
   - **Docker Command** : (laisser vide, utilise CMD du Dockerfile)

### 3. **Variables d'environnement**

Dans **Settings** → **Environment**, ajoutez :
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:XuvyCgMJdH6yEMmGtIyilBSF3mdjq2RE4kgrw9j1BL0=
APP_URL=https://carsmanagement.onrender.com
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
LOG_CHANNEL=stderr
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### 4. **Redéployer**

1. **Manual Deploy** → **Deploy Latest Commit**
2. Ou poussez un nouveau commit pour déclencher un auto-deploy

### 5. **Alternative : render.yaml**

Si vous préférez la configuration par fichier, utilisez le `render.yaml` mis à jour qui spécifie :
- `dockerfilePath: ./Dockerfile.render`
- Toutes les variables d'environnement nécessaires

## 🚀 Commandes de déploiement

```bash
# Pousser les changements
git add .
git commit -m "Fix Render deployment with proper Dockerfile"
git push origin main
```

## 🔍 Vérification

Une fois déployé, votre application sera disponible à :
**https://carsmanagement.onrender.com**

### Comptes de test :
- **Admin** : admin@example.com / password
- **User** : user@example.com / password

## 🛠️ Dépannage

Si le problème persiste :

1. **Vérifiez les logs** dans Render Dashboard → Logs
2. **Assurez-vous** que `Dockerfile.render` est utilisé
3. **Vérifiez** que toutes les variables d'environnement sont définies
4. **Redéployez manuellement** si nécessaire

## 📋 Différences avec autres plateformes

- **Render** : Utilise `Dockerfile.render` + port dynamique `$PORT`
- **Hugging Face** : Utilise `dockerfile` + port fixe `7860`
- **Railway** : Utilise `nixpacks.toml` + `start.sh`