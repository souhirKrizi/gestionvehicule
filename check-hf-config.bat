@echo off
echo 🔍 Vérification de la configuration Hugging Face...

echo.
echo 📋 Vérification des fichiers requis :

if exist "README.md" (
    echo ✅ README.md trouvé
    findstr /C:"sdk: docker" README.md >nul
    if %ERRORLEVEL% EQU 0 (
        echo ✅ Configuration SDK Docker trouvée
    ) else (
        echo ❌ Configuration SDK manquante dans README.md
        goto :error
    )
) else (
    echo ❌ README.md manquant
    goto :error
)

if exist "dockerfile" (
    echo ✅ dockerfile trouvé
    findstr /C:"EXPOSE 7860" dockerfile >nul
    if %ERRORLEVEL% EQU 0 (
        echo ✅ Port 7860 configuré
    ) else (
        echo ❌ Port 7860 manquant dans dockerfile
        goto :error
    )
) else (
    echo ❌ dockerfile manquant
    goto :error
)

if exist ".env.huggingface" (
    echo ✅ .env.huggingface trouvé
) else (
    echo ❌ .env.huggingface manquant
    goto :error
)

if exist "start-huggingface.sh" (
    echo ✅ start-huggingface.sh trouvé
) else (
    echo ❌ start-huggingface.sh manquant
    goto :error
)

if exist "database/seeders/DemoDataSeeder.php" (
    echo ✅ DemoDataSeeder.php trouvé
) else (
    echo ❌ DemoDataSeeder.php manquant
    goto :error
)

echo.
echo 🎯 Configuration Hugging Face :
echo    - Titre: Gestion de Véhicules Militaires
echo    - SDK: Docker
echo    - Port: 7860
echo    - Emoji: 🚗
echo    - Licence: MIT

echo.
echo ✅ Tous les fichiers sont prêts pour Hugging Face !
echo 🚀 Vous pouvez maintenant exécuter : update-huggingface.bat
goto :end

:error
echo.
echo ❌ Configuration incomplète ! Veuillez corriger les erreurs ci-dessus.
echo.

:end
pause