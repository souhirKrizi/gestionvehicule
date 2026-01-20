<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::all();

echo "===== UTILISATEURS ACTUELS =====\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Phone: {$user->phone}\n";
}

echo "\n===== MISE À JOUR DES TÉLÉPHONES =====\n";

// Mise à jour des téléphones
$phones = [
    'Souhir Krizi' => '21863548',
    'souhir' => '22123456',
];

foreach ($users as $user) {
    if (array_key_exists($user->name, $phones)) {
        $user->update(['phone' => $phones[$user->name]]);
        echo "✓ {$user->name} -> {$user->phone}\n";
    }
}

echo "\n===== UTILISATEURS APRÈS MISE À JOUR =====\n";
$users->fresh();
$users = \App\Models\User::all();
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Phone: {$user->phone}\n";
}
