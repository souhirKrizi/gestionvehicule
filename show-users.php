<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "===== TOUS LES UTILISATEURS =====\n\n";

$users = \App\Models\User::all();

foreach ($users as $user) {
    $phone = $user->phone ?? '(vide)';
    echo "ID: {$user->id}\n";
    echo "  Nom: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Téléphone: {$phone}\n";
    echo "  Statut: {$user->status}\n";
    echo "  Rôle: {$user->role}\n";
    echo "\n";
}

echo "\n===== UTILISATEURS SANS TÉLÉPHONE =====\n";
$usersNoPhone = \App\Models\User::whereNull('phone')->orWhere('phone', '')->get();
foreach ($usersNoPhone as $user) {
    echo "- {$user->name} ({$user->email})\n";
}
