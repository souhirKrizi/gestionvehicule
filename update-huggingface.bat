@echo off
echo 🔄 Mise à jour de votre Space Hugging Face...

echo 📁 Création du dossier temporaire...
if exist "hf-update" rmdir /s /q "hf-update"
mkdir hf-update
cd hf-update

echo 📥 Clonage du repository...
git clone https://huggingface.co/spaces/souhlrmk/vehicules .

echo 🧹 Nettoyage des anciens fichiers (sauf .git)...
for /f "delims=" %%i in ('dir /b /a-d') do (
    if not "%%i"==".git" del "%%i" 2>nul
)
for /f "delims=" %%i in ('dir /b /ad') do (
    if not "%%i"==".git" rmdir /s /q "%%i" 2>nul
)

echo 📋 Copie de tous les nouveaux fichiers...
robocopy ".." . /E /XD .git node_modules vendor "hf-update" /XF "*.bat" "exclude-list.txt" "manual-steps.md" /NFL /NDL /NJH /NJS

echo 📝 Vérification du README.md...
if not exist "README.md" (
    echo ❌ README.md manquant !
    exit /b 1
)

findstr /C:"sdk: docker" README.md >nul
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Configuration Hugging Face manquante dans README.md !
    exit /b 1
)

echo ✅ README.md correctement configuré pour Hugging Face

echo 📝 Configuration Git...
git config user.email "admin@gestion-vehicule.mil"
git config user.name "Vehicle Management System"

echo 📦 Ajout des nouveaux fichiers...
git add .

echo 💬 Commit des changements...
git commit -m "🚀 Application Laravel complète avec configuration Hugging Face"

echo 🚀 Push vers Hugging Face...
git push

echo ✅ Mise à jour terminée !
echo 🌐 Votre application sera disponible dans quelques minutes à :
echo    https://souhlrmk-vehicules.hf.space

cd ..
echo 🧹 Nettoyage...
rmdir /s /q hf-update

echo.
echo 📋 Comptes de test disponibles :
echo    Admin: admin@example.com / password
echo    User:  user@example.com / password
echo.
echo 🔧 Configuration Hugging Face :
echo    - SDK: Docker ✅
echo    - Port: 7860 ✅  
echo    - README: Configuré ✅

pause