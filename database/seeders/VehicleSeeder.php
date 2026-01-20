<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            // Véhicules légers
            [
                'name' => 'Toyota Hilux #001',
                'type' => 'light',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'Land Rover Defender #002',
                'type' => 'light',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'Nissan Patrol #003',
                'type' => 'light',
                'status' => 'broken',
                'description' => 'Problème de transmission. Pièces commandées, réparation prévue dans 3 jours.',
            ],
            [
                'name' => 'Mitsubishi L200 #004',
                'type' => 'light',
                'status' => 'maintenance',
                'description' => 'Révision complète 50 000km en cours. Changement des filtres et huiles.',
            ],
            [
                'name' => 'Ford Ranger #005',
                'type' => 'light',
                'status' => 'operational',
                'description' => null,
            ],

            // Véhicules lourds
            [
                'name' => 'Mercedes Actros #101',
                'type' => 'heavy',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'Scania R500 #102',
                'type' => 'heavy',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'MAN TGX #103',
                'type' => 'heavy',
                'status' => 'broken',
                'description' => 'Panne moteur majeure. Système de refroidissement défaillant. En attente du mécanicien spécialisé.',
            ],
            [
                'name' => 'Volvo FH16 #104',
                'type' => 'heavy',
                'status' => 'maintenance',
                'description' => 'Remplacement du système de freinage et contrôle des suspensions.',
            ],

            // Véhicules spécialisés
            [
                'name' => 'Ambulance Mercedes Sprinter #201',
                'type' => 'specialized',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'Camion-citerne Renault #202',
                'type' => 'specialized',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'Grue mobile Liebherr #203',
                'type' => 'specialized',
                'status' => 'maintenance',
                'description' => 'Vérification du système hydraulique et des câbles de levage. Maintenance préventive annuelle.',
            ],
            [
                'name' => 'Véhicule de commandement #204',
                'type' => 'specialized',
                'status' => 'operational',
                'description' => null,
            ],
            [
                'name' => 'Dépanneuse MAN #205',
                'type' => 'specialized',
                'status' => 'broken',
                'description' => 'Système de treuil bloqué. Nécessite intervention technique spécialisée.',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}

