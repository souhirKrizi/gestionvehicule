<!-- resources/views/admin/vehicles/index.blade.php -->
@extends('layouts.admin')

@section('page-title', 'Gestion des Véhicules')

@section('content')
<div class="space-y-6">
    <!-- Header avec bouton d'ajout -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">{{ $vehicles->total() }} véhicule(s) au total</h3>
        </div>
        <a href="{{ route('admin.vehicles.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un véhicule
        </a>
    </div>

    <!-- Grille des véhicules -->
    @if($vehicles->isEmpty())
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="text-6xl mb-4">🚗</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun véhicule</h3>
        <p class="text-gray-600 mb-6">Commencez par ajouter votre premier véhicule</p>
        <a href="{{ route('admin.vehicles.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
            Ajouter un véhicule
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vehicles as $vehicle)
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
            <!-- En-tête coloré selon le statut -->
            <div class="h-2 {{ $vehicle->status === 'operational' ? 'bg-green-500' : ($vehicle->status === 'broken' ? 'bg-red-500' : 'bg-orange-500') }}"></div>
            
            <div class="p-6">
                <!-- Type et Nom -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">{{ $vehicle->type_icon }}</span>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $vehicle->name }}</h3>
                            <p class="text-sm text-gray-600">{{ \App\Models\Vehicle::TYPES[$vehicle->type] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Badge Statut -->
                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $vehicle->status === 'operational' ? 'bg-green-100 text-green-800' : 
                           ($vehicle->status === 'broken' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800') }}">
                        <span class="mr-2">{{ $vehicle->status_badge }}</span>
                        {{ \App\Models\Vehicle::STATUSES[$vehicle->status] }}
                    </span>
                </div>

                <!-- Description si en panne -->
                @if($vehicle->status === 'broken' && $vehicle->description)
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800">
                        <strong>⚠️ Description:</strong><br>
                        {{ $vehicle->description }}
                    </p>
                </div>
                @endif

                @if($vehicle->status === 'maintenance' && $vehicle->description)
                <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                    <p class="text-sm text-orange-800">
                        <strong>🔧 En cours:</strong><br>
                        {{ $vehicle->description }}
                    </p>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                       class="flex-1 text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                        ✏️ Modifier
                    </a>
                    
                    <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
@endsection