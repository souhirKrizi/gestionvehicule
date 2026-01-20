<?php
// app/Models/Vehicle.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'description'
    ];

    public const TYPES = [
        'light' => 'Véhicules légers',
        'heavy' => 'Véhicules lourds',
        'specialized' => 'Véhicules spécialisés'
    ];

    public const STATUSES = [
        'operational' => 'Validée',
        'broken' => 'En panne',
        'maintenance' => 'En cours de traitement'
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'operational' => 'green',
            'broken' => 'red',
            'maintenance' => 'orange',
            default => 'gray'
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'operational' => '🟢',
            'broken' => '🔴',
            'maintenance' => '🟠',
            default => '⚪'
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'light' => '🚗',
            'heavy' => '🚚',
            'specialized' => '🚙',
            default => '🚗'
        };
    }
}