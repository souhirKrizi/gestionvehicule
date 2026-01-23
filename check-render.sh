#!/bin/bash

echo "🔍 Vérification de la configuration Render..."

echo "📋 Fichiers requis :"
files=("render.yaml" "render-build.sh" "render-start.sh" ".env.render" "Procfile")

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file manquant"
        exit 1
    fi
done

echo "📋 Vérification du contenu :"

# Vérifier render.yaml
if grep -q "buildCommand: bash render-build.sh" render.yaml; then
    echo "✅ buildCommand configuré"
else
    echo "❌ buildCommand incorrect"
    exit 1
fi

if grep -q "startCommand: bash render-start.sh" render.yaml; then
    echo "✅ startCommand configuré"
else
    echo "❌ startCommand incorrect"
    exit 1
fi

# Vérifier les scripts
if [ -x "render-build.sh" ] || chmod +x render-build.sh; then
    echo "✅ render-build.sh exécutable"
else
    echo "❌ render-build.sh non exécutable"
fi

if [ -x "render-start.sh" ] || chmod +x render-start.sh; then
    echo "✅ render-start.sh exécutable"
else
    echo "❌ render-start.sh non exécutable"
fi

echo "✅ Configuration Render prête !"
echo "🚀 Vous pouvez maintenant déployer sur Render.com"