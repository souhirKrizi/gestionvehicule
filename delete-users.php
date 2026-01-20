<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "🗑️  Suppression des utilisateurs...\n\n";

// Supprimer Mohamed Slim
$user1 = User::where('email', 'user1@academy.mil')->first();
if ($user1) {
    $user1->delete();
    echo "✅ Mohamed Slim (user1@academy.mil) supprimé\n";
}

// Supprimer Ahmed Ben Ali
$user2 = User::where('email', 'user2@academy.mil')->first();
if ($user2) {
    $user2->delete();
    echo "✅ Ahmed Ben Ali (user2@academy.mil) supprimé\n";
}

// Afficher les utilisateurs restants
echo "\n📋 Utilisateurs restants dans la base:\n";
echo "──────────────────────────────────────\n";
$users = User::all();
foreach ($users as $u) {
    echo "- " . $u->name . " (" . $u->email . ") - Rôle: " . $u->role . "\n";
}
echo "──────────────────────────────────────\n";
echo "\nTotal: " . $users->count() . " utilisateur(s)\n";
