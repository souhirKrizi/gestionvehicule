# Variables d'Environnement pour Railway

## Variables Obligatoires à Ajouter dans Railway

Allez dans votre projet Railway > Variables et ajoutez :

```
APP_NAME=Military Fleet Management
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:XuvyCgMJdH6yEMmGtIyilBSF3mdjq2RE4kgrw9j1BL0=
APP_URL=https://gestion-vehicule-production.up.railway.app

DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
MAIL_FROM_ADDRESS=admin@militaryfleet.com
MAIL_FROM_NAME=Military Fleet Management

LOG_CHANNEL=stack
LOG_LEVEL=error

VITE_APP_NAME=Military Fleet Management
```

## Comment Ajouter les Variables

1. Allez sur Railway.app
2. Sélectionnez votre projet "gestion-vehicule"
3. Cliquez sur l'onglet "Variables"
4. Cliquez sur "New Variable"
5. Ajoutez chaque variable une par une
6. Cliquez sur "Deploy" pour redéployer avec les nouvelles variables

## Variables Importantes

- **APP_KEY** : Clé de chiffrement (utilisez celle fournie ou générez-en une nouvelle)
- **APP_URL** : Remplacez par votre vraie URL Railway
- **DB_DATABASE** : Chemin absolu vers la base SQLite dans le conteneur