<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "🗑️  Suppression de Test User Notification...\n\n";

$user = User::where('email', 'test-notification@academy.mil')->first();
if ($user) {
    $user->delete();
    echo "✅ Test User Notification (test-notification@academy.mil) supprimé\n\n";
} else {
    echo "⚠️  Utilisateur non trouvé\n\n";
}

echo "📋 Utilisateurs restants:\n";
echo "──────────────────────────────────────\n";
User::all()->each(function($u) {
    echo "- " . $u->name . " (" . $u->email . ")\n";
});
echo "──────────────────────────────────────\n";
