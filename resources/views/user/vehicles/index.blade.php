<!-- resources/views/user/vehicles/index.blade.php -->
@extends('layouts.user')

@section('title', 'Consulter les Véhicules')

@section('content')
<div class="space-y-6">
    <!-- Header avec titre -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">🚗 Flotte de Véhicules</h2>
            <p class="text-gray-600 mt-1">Consultez l'état en temps réel de tous nos véhicules</p>
        </div>
        
        <a href="{{ route('user.messages.create') }}" 
           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
            <span class="mr-2">📩</span>
            Contacter l'Admin
        </a>
    </div>

    <!-- Filtres -->
    <div x-data="{ 
        type: '{{ request('type', 'all') }}', 
        status: '{{ request('status', 'all') }}',
        search: '{{ request('search', '') }}'
    }">
        <div class="bg-white rounded-xl shadow-md p-6">
            <form method="GET" class="space-y-4" @submit="$el.submit()">
                <!-- Recherche -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Rechercher</label>
                    <input type="text" name="search" x-model="search"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nom du véhicule...">
                </div>

                <!-- Filtres Type et Statut -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Filtre Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">📋 Type de véhicule</label>
                        <select name="type" x-model="type" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all">Tous les types</option>
                            <option value="light">🚗 Véhicules légers</option>
                            <option value="heavy">🚚 Véhicules lourds</option>
                            <option value="specialized">🚙 Véhicules spécialisés</option>
                        </select>
                    </div>

                    <!-- Filtre Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">🔧 État</label>
                        <select name="status" x-model="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all">Tous les états</option>
                            <option value="operational">🟢 Fonctionnels</option>
                            <option value="broken">🔴 En panne</option>
                            <option value="maintenance">🟠 En traitement</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        Filtrer
                    </button>
                    <a href="{{ route('user.vehicles.index') }}" 
                       class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Résultats -->
    @if($vehicles->isEmpty())
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun véhicule trouvé</h3>
        <p class="text-gray-600">Essayez de modifier vos filtres de recherche</p>
    </div>
    @else
    <!-- Statistiques rapides -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl mb-2">🚗</div>
            <p class="text-2xl font-bold text-gray-900">{{ $vehicles->total() }}</p>
            <p class="text-sm text-gray-600">Total</p>
        </div>
        
        <div class="bg-green-50 rounded-lg shadow p-4 text-center border border-green-200">
            <div class="text-2xl mb-2">🟢</div>
            <p class="text-2xl font-bold text-green-700">{{ \App\Models\Vehicle::where('status', 'operational')->count() }}</p>
            <p class="text-sm text-gray-600">Fonctionnels</p>
        </div>
        
        <div class="bg-red-50 rounded-lg shadow p-4 text-center border border-red-200">
            <div class="text-2xl mb-2">🔴</div>
            <p class="text-2xl font-bold text-red-700">{{ \App\Models\Vehicle::where('status', 'broken')->count() }}</p>
            <p class="text-sm text-gray-600">En Panne</p>
        </div>
        
        <div class="bg-orange-50 rounded-lg shadow p-4 text-center border border-orange-200">
            <div class="text-2xl mb-2">🟠</div>
            <p class="text-2xl font-bold text-orange-700">{{ \App\Models\Vehicle::where('status', 'maintenance')->count() }}</p>
            <p class="text-sm text-gray-600">En Traitement</p>
        </div>
    </div>

    <!-- Grille des véhicules -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vehicles as $vehicle)
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
            <!-- Bande colorée -->
            <div class="h-2 {{ $vehicle->status === 'operational' ? 'bg-green-500' : ($vehicle->status === 'broken' ? 'bg-red-500' : 'bg-orange-500') }}"></div>
            
            <div class="p-6">
                <!-- En-tête -->
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $vehicle->name }}</h3>
                        <p class="text-sm text-gray-600">{{ \App\Models\Vehicle::TYPES[$vehicle->type] }}</p>
                    </div>
                </div>

                <!-- Badge statut -->
                <div class="mb-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        {{ $vehicle->status === 'operational' ? 'bg-green-100 text-green-800' : 
                           ($vehicle->status === 'broken' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800') }}">
                        <span class="text-lg mr-2">{{ $vehicle->status_badge }}</span>
                        {{ \App\Models\Vehicle::STATUSES[$vehicle->status] }}
                    </span>
                </div>

                <!-- Bouton voir détails -->
                <div>
                    <a href="{{ route('user.vehicles.show', $vehicle) }}" 
                       class="block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center font-medium rounded-lg transition">
                        👁️ Voir les Détails
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $vehicles->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
