# Déploiement sur Hugging Face Spaces

## Guide étape par étape

### 1. Préparer votre compte Hugging Face

1. Créez un compte sur [huggingface.co](https://huggingface.co)
2. Allez dans votre profil → Settings → Access Tokens
3. Créez un nouveau token avec les permissions d'écriture

### 2. Créer un nouveau Space

1. Allez sur [huggingface.co/new-space](https://huggingface.co/new-space)
2. Remplissez les informations :
   - **Space name** : `vehicules` (ou le nom de votre choix)
   - **License** : MIT
   - **Select the Space SDK** : Docker
   - **Space hardware** : CPU basic (gratuit)
   - **Visibility** : Public

### 3. Cloner et pousser votre code

```bash
# Cloner le repository du Space
git clone https://huggingface.co/spaces/VOTRE-USERNAME/vehicules
cd vehicules

# Copier tous les fichiers de votre projet Laravel
cp -r /chemin/vers/votre/projet/* .

# Ajouter et commiter
git add .
git commit -m "Initial commit: Laravel vehicle management app"

# Pousser vers Hugging Face
git push
```

### 4. Configuration automatique

Le déploiement se fera automatiquement grâce aux fichiers :
- `dockerfile` : Configuration Docker optimisée
- `.env.huggingface` : Variables d'environnement pour la production
- `start-huggingface.sh` : Script de démarrage

### 5. Accès à l'application

Une fois déployée, votre application sera accessible à :
`https://VOTRE-USERNAME-vehicules.hf.space`

### 6. Comptes de test

L'application sera pré-remplie avec :
- **Admin** : admin@example.com / password
- **Utilisateur** : user@example.com / password

## Fonctionnalités disponibles

✅ **Gratuit** : Hébergement gratuit sur Hugging Face  
✅ **Base de données** : SQLite intégrée avec données de démonstration  
✅ **Interface complète** : Toutes les fonctionnalités Laravel  
✅ **Responsive** : Compatible mobile et desktop  
✅ **Sécurisé** : Authentification et autorisation  

## Limitations

- **CPU Basic** : Performance limitée (suffisante pour démonstration)
- **Stockage temporaire** : Les données peuvent être perdues lors des redémarrages
- **Pas de domaine personnalisé** : URL Hugging Face uniquement

## Mise à jour

Pour mettre à jour l'application :
```bash
git add .
git commit -m "Update: description des changements"
git push
```

Le redéploiement se fera automatiquement.

## Support

En cas de problème :
1. Vérifiez les logs dans l'interface Hugging Face
2. Assurez-vous que le port 7860 est utilisé
3. Vérifiez que tous les fichiers sont présents dans le repository