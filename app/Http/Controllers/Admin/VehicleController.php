<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(12);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:light,heavy,specialized',
            'status' => 'required|in:operational,broken,maintenance',
            'description' => 'required_if:status,broken|nullable|string'
        ]);

        Vehicle::create($validated);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Véhicule ajouté avec succès');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:light,heavy,specialized',
            'status' => 'required|in:operational,broken,maintenance',
            'description' => 'required_if:status,broken|nullable|string'
        ]);

        $vehicle->update($validated);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Véhicule modifié avec succès');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Véhicule supprimé avec succès');
    }
}