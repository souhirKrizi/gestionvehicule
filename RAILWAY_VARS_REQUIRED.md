# Variables d'environnement requises pour Railway

Ajoutez ces variables dans votre dashboard Railway :

```
APP_NAME=Gestion de Véhicule
APP_ENV=production
APP_KEY=base64:XuvyCgMJdH6yEMmGtIyilBSF3mdjq2RE4kgrw9j1BL0=
APP_DEBUG=false
APP_URL=https://votre-app.railway.app

DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite

LOG_CHANNEL=stack
LOG_LEVEL=error

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
MAIL_FROM_ADDRESS=admin@gestion-vehicule.mil
MAIL_FROM_NAME=Gestion de Véhicule
```

## Étapes pour corriger l'erreur 500 :

1. **Ajoutez les variables ci-dessus dans Railway**
2. **Redéployez votre application**
3. **Vérifiez les logs Railway pour d'autres erreurs**

## Commandes utiles :
- `railway logs` - Voir les logs en temps réel
- `railway shell` - Accéder au shell de votre app