#!/usr/bin/env php
<?php
/**
 * Script de Configuration du Mail
 * Configure le système d'email pour envoyer des emails réels
 */

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║          📧 CONFIGURATION DU SYSTÈME D'EMAIL               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Afficher les options
echo "Choisissez votre fournisseur d'email:\n\n";
echo "1️⃣  GMAIL (Recommandé - Gratuit)\n";
echo "2️⃣  MAILTRAP (Service Cloud - Gratuit)\n";
echo "3️⃣  MAILHOG (Local SMTP Server - Gratuit)\n";
echo "4️⃣  AUTRE (Configuration manuelle)\n";
echo "5️⃣  VOIR LOGS (Logs seulement - Actuel)\n\n";

echo "Sélectionnez une option (1-5): ";
$choice = trim(fgets(STDIN));

$envFile = __DIR__ . '/.env';
$envContent = file_get_contents($envFile);

switch ($choice) {
    case '1':
        // Gmail
        echo "\n═══════════════════════════════════════════════════════════\n";
        echo "📧 CONFIGURATION GMAIL\n";
        echo "═══════════════════════════════════════════════════════════\n\n";
        
        echo "Étape 1: Aller à https://myaccount.google.com/apppasswords\n";
        echo "Étape 2: Copier le mot de passe généré (16 caractères)\n\n";
        
        echo "Votre email Gmail: ";
        $email = trim(fgets(STDIN));
        
        echo "Votre app password (sans espaces): ";
        $password = trim(fgets(STDIN));
        
        // Remplacer dans .env
        $mailConfig = <<<ENV
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=$email
MAIL_PASSWORD=$password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@gestion-vehicule.mil"
MAIL_FROM_NAME="Gestion de Véhicule"
ENV;
        
        $envContent = preg_replace(
            '/MAIL_MAILER=.*?MAIL_FROM_NAME=.*?$/ms',
            $mailConfig,
            $envContent
        );
        
        file_put_contents($envFile, $envContent);
        
        echo "\n✅ Configuration Gmail appliquée!\n";
        echo "   Email: $email\n";
        echo "   Password: " . substr($password, 0, 4) . "****\n\n";
        break;
        
    case '2':
        // Mailtrap
        echo "\n═══════════════════════════════════════════════════════════\n";
        echo "📧 CONFIGURATION MAILTRAP\n";
        echo "═══════════════════════════════════════════════════════════\n\n";
        
        echo "Aller à: https://mailtrap.io/dashboard\n";
        echo "Copier les credentials:\n\n";
        
        echo "Username: ";
        $username = trim(fgets(STDIN));
        
        echo "Password/Token: ";
        $password = trim(fgets(STDIN));
        
        $mailConfig = <<<ENV
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=$username
MAIL_PASSWORD=$password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@gestion-vehicule.mil"
MAIL_FROM_NAME="Gestion de Véhicule"
ENV;
        
        $envContent = preg_replace(
            '/MAIL_MAILER=.*?MAIL_FROM_NAME=.*?$/ms',
            $mailConfig,
            $envContent
        );
        
        file_put_contents($envFile, $envContent);
        
        echo "\n✅ Configuration Mailtrap appliquée!\n";
        echo "   Voir les emails: https://mailtrap.io/dashboard\n\n";
        break;
        
    case '3':
        // MailHog
        echo "\n═══════════════════════════════════════════════════════════\n";
        echo "📧 CONFIGURATION MAILHOG\n";
        echo "═══════════════════════════════════════════════════════════\n\n";
        
        echo "1. Télécharger MailHog:\n";
        echo "   https://github.com/mailhog/MailHog/releases\n";
        echo "2. Lancer: MailHog_windows_amd64.exe\n";
        echo "3. Interface: http://localhost:8025\n\n";
        
        $mailConfig = <<<ENV
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS="admin@gestion-vehicule.mil"
MAIL_FROM_NAME="Gestion de Véhicule"
ENV;
        
        $envContent = preg_replace(
            '/MAIL_MAILER=.*?MAIL_FROM_NAME=.*?$/ms',
            $mailConfig,
            $envContent
        );
        
        file_put_contents($envFile, $envContent);
        
        echo "✅ Configuration MailHog appliquée!\n";
        echo "   N'oubliez pas de lancer MailHog d'abord!\n\n";
        break;
        
    case '4':
        echo "Configuration manuelle: Éditer .env directement\n";
        break;
        
    case '5':
        echo "Configuration actuelle: LOGS SEULEMENT\n";
        echo "Les emails sont loggés dans: storage/logs/laravel.log\n";
        echo "Pas d'emails réels envoyés\n\n";
        break;
        
    default:
        echo "❌ Option invalide\n";
        exit(1);
}

echo "═══════════════════════════════════════════════════════════\n";
echo "Exécutez maintenant:\n";
echo "php artisan config:clear\n";
echo "php artisan optimize\n";
echo "═══════════════════════════════════════════════════════════\n\n";
echo "✅ Configuration terminée!\n";
echo "Les emails seront maintenant envoyés lors de l'approbation.\n\n";
