#!/bin/bash

echo "🚀 Redéploiement sur Railway..."

# Vérifier que nous avons Railway CLI
if ! command -v railway &> /dev/null; then
    echo "❌ Railway CLI n'est pas installé. Installez-le avec: npm install -g @railway/cli"
    exit 1
fi

# Nettoyer les fichiers temporaires
echo "🧹 Nettoyage des fichiers temporaires..."
rm -rf storage/logs/*.log
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# Commit et push si nécessaire
if [ -n "$(git status --porcelain)" ]; then
    echo "📝 Commit des changements..."
    git add .
    git commit -m "Fix: Amélioration du déploiement Railway"
    git push
fi

# Redéployer
echo "🚀 Redéploiement..."
railway up --detach

echo "✅ Redéploiement lancé ! Vérifiez les logs avec: railway logs"