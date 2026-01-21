@echo off
echo 🐳 Test du build Docker pour Hugging Face...

echo 📦 Construction de l'image Docker...
docker build -t vehicules-hf .

if %ERRORLEVEL% NEQ 0 (
    echo ❌ Erreur lors du build Docker
    exit /b 1
)

echo ✅ Image Docker construite avec succès !
echo 🚀 Démarrage du conteneur de test...
docker run -p 7860:7860 --name vehicules-test vehicules-hf

echo 🧹 Nettoyage...
docker stop vehicules-test 2>nul
docker rm vehicules-test 2>nul