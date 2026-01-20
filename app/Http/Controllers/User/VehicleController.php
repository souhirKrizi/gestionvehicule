<?php
// app/Http/Controllers/User/VehicleController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        // Filtre par type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filtre par statut
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $vehicles = $query->latest()->paginate(12);

        return view('user.vehicles.index', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        return view('user.vehicles.show', compact('vehicle'));
    }
}