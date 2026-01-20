#!/usr/bin/env php
<?php
/**
 * Script de Test - Notification Email
 * Simule l'approbation d'un utilisateur et affiche l'email
 * 
 * Usage: php test-notification.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Notifications\UserApprovedNotification;
use Illuminate\Support\Facades\Mail;

echo "╔════════════════════════════════════════════╗\n";
echo "║  📧 TEST DE NOTIFICATION EMAIL             ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

// Créer un utilisateur test
echo "1️⃣ Recherche d'un utilisateur test...\n";
// Utiliser user2 qui est en pending
$testUser = User::where('email', 'user2@academy.mil')->first();

if (!$testUser) {
    echo "❌ Aucun utilisateur 'user2@academy.mil' trouvé\n";
    exit(1);
}

echo "✅ Utilisateur trouvé: {$testUser->email} (Status: {$testUser->status})\n\n";

// Envoyer la notification
echo "2️⃣ Envoi de la notification d'approbation...\n";
$testUser->notify(new UserApprovedNotification());

echo "✅ Notification envoyée!\n\n";

// Afficher les logs
echo "3️⃣ Vérification des logs:\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lastLines = array_slice(file($logFile), -30);
    foreach ($lastLines as $line) {
        if (strpos($line, 'Message sent') !== false || 
            strpos($line, 'email') !== false ||
            strpos($line, 'approval') !== false) {
            echo "   " . trim($line) . "\n";
        }
    }
} else {
    echo "   ⚠️ Fichier de log non trouvé\n";
}

echo "\n════════════════════════════════════════════\n";
echo "✅ TEST COMPLÉTÉ\n";
echo "════════════════════════════════════════════\n\n";

echo "Configuration Mail actuelle:\n";
echo "- MAIL_MAILER: " . config('mail.mailer') . "\n";
echo "- MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "- MAIL_FROM_NAME: " . config('mail.from.name') . "\n\n";

echo "Pour voir les emails en développement:\n";
echo "- Logs: storage/logs/laravel.log\n";
echo "- MailHog: http://localhost:8025\n";
echo "- Mailtrap: https://mailtrap.io\n\n";

// Nettoyer l'utilisateur test n'est pas nécessaire
echo "✅ Test terminé avec succès!\n";
