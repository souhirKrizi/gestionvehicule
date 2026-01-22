<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Message;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un administrateur
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'phone' => '+33123456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);

        // Créer un utilisateur normal
        $user = User::create([
            'name' => 'Utilisateur Test',
            'email' => 'user@example.com',
            'phone' => '+33987654321',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);

        // Créer quelques véhicules
        $vehicles = [
            [
                'brand' => 'Renault',
                'model' => 'Sherpa Light',
                'year' => 2020,
                'license_plate' => 'ML-001-AA',
                'type' => 'Véhicule blindé léger',
                'status' => 'available',
                'description' => 'Véhicule blindé léger pour missions de reconnaissance.',
            ],
            [
                'brand' => 'Iveco',
                'model' => 'Daily 4x4',
                'year' => 2019,
                'license_plate' => 'ML-002-BB',
                'type' => 'Véhicule utilitaire',
                'status' => 'available',
                'description' => 'Véhicule utilitaire tout-terrain pour transport de matériel.',
            ],
            [
                'brand' => 'Mercedes',
                'model' => 'Unimog U5000',
                'year' => 2021,
                'license_plate' => 'ML-003-CC',
                'type' => 'Camion militaire',
                'status' => 'maintenance',
                'description' => 'Camion militaire polyvalent pour missions lourdes.',
            ],
            [
                'brand' => 'Peugeot',
                'model' => 'P4',
                'year' => 2018,
                'license_plate' => 'ML-004-DD',
                'type' => 'Véhicule de liaison',
                'status' => 'available',
                'description' => 'Véhicule de liaison léger pour déplacements rapides.',
            ],
        ];

        foreach ($vehicles as $vehicleData) {
            Vehicle::create($vehicleData);
        }

        // Créer quelques messages
        Message::create([
            'user_id' => $user->id,
            'subject' => 'Demande de réservation véhicule',
            'content' => 'Bonjour, je souhaiterais réserver le véhicule Renault Sherpa Light pour une mission prévue la semaine prochaine. Pourriez-vous me confirmer sa disponibilité ?',
            'status' => 'pending',
        ]);

        Message::create([
            'user_id' => $user->id,
            'subject' => 'Question sur maintenance',
            'content' => 'Le véhicule Mercedes Unimog est-il bientôt disponible après maintenance ?',
            'status' => 'replied',
            'admin_reply' => 'Bonjour, le véhicule sera disponible d\'ici la fin de la semaine. Nous vous tiendrons informé.',
            'replied_at' => now(),
        ]);
    }
}