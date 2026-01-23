@echo off
echo 🚀 Déploiement automatique sur Hugging Face Spaces...

echo 📋 Vérification des prérequis...
where git >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Git n'est pas installé ou pas dans le PATH
    pause
    exit /b 1
)

echo ✅ Git trouvé

echo 📁 Création du dossier de déploiement...
if exist "hf-deploy" rmdir /s /q "hf-deploy"
mkdir hf-deploy
cd hf-deploy

echo 📥 Clonage de votre Space Hugging Face...
git clone https://huggingface.co/spaces/souhlrmk/vehicules .
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Erreur lors du clonage. Vérifiez l'URL du repository.
    pause
    exit /b 1
)

echo 🧹 Suppression des anciens fichiers...
for /f "delims=" %%i in ('dir /b /a-d 2^>nul') do (
    if not "%%i"==".git" del "%%i" 2>nul
)
for /f "delims=" %%i in ('dir /b /ad 2^>nul') do (
    if not "%%i"==".git" rmdir /s /q "%%i" 2>nul
)

echo 📋 Copie des fichiers du projet...
robocopy ".." . /E /XD .git node_modules vendor "hf-deploy" /XF "*.bat" "render*.yaml" "Dockerfile.render" "start-render.sh" "build-render.sh" ".env.render" "RENDER_DEPLOYMENT.md" /NFL /NDL /NJH /NJS

echo 📝 Vérification des fichiers critiques...
if not exist "README.md" (
    echo ❌ README.md manquant !
    cd ..
    rmdir /s /q hf-deploy
    pause
    exit /b 1
)

if not exist "dockerfile" (
    echo ❌ dockerfile manquant !
    cd ..
    rmdir /s /q hf-deploy
    pause
    exit /b 1
)

if not exist ".env.huggingface" (
    echo ❌ .env.huggingface manquant !
    cd ..
    rmdir /s /q hf-deploy
    pause
    exit /b 1
)

echo ✅ Tous les fichiers critiques sont présents

echo 📝 Configuration Git...
git config user.email "admin@gestion-vehicule.mil"
git config user.name "Vehicle Management System"

echo 📦 Ajout des fichiers...
git add .

echo 💬 Création du commit...
git commit -m "🚀 Déploiement complet de l'application Laravel avec données de démonstration"

echo 🚀 Push vers Hugging Face...
git push
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Erreur lors du push
    cd ..
    rmdir /s /q hf-deploy
    pause
    exit /b 1
)

echo ✅ Déploiement réussi !

cd ..
rmdir /s /q hf-deploy

echo.
echo 🎉 Votre application est en cours de déploiement !
echo 🌐 Elle sera disponible dans quelques minutes à :
echo    https://souhlrmk-vehicules.hf.space
echo.
echo 📋 Comptes de test disponibles :
echo    👤 Admin: admin@example.com / password
echo    👤 User:  user@example.com / password
echo.
echo 🔧 Fonctionnalités incluses :
echo    ✅ Gestion des véhicules
echo    ✅ Système de messagerie
echo    ✅ Authentification sécurisée
echo    ✅ Interface responsive
echo    ✅ Données de démonstration
echo.

pause