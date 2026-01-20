<!-- resources/views/user/vehicles/show.blade.php -->
@extends('layouts.user')

@section('title', 'Détails du Véhicule')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
    <!-- En-tête avec statut -->
    <div class="h-2 {{ $vehicle->status === 'operational' ? 'bg-green-500' : ($vehicle->status === 'broken' ? 'bg-red-500' : 'bg-orange-500') }}"></div>
    
    <div class="p-8">
        <!-- Titre et Bouton Retour -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $vehicle->name }}</h1>
            <a href="{{ route('user.vehicles.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← Retour</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informations Principales -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations Générales</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="text-lg text-gray-900">{{ \App\Models\Vehicle::TYPES[$vehicle->type] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Statut</dt>
                        <dd class="inline-flex items-center">
                            <span class="text-2xl mr-2">{{ $vehicle->status_badge }}</span>
                            <span class="text-lg font-medium">
                                @if($vehicle->status === 'operational')
                                    <span class="text-green-600">Opérationnel</span>
                                @elseif($vehicle->status === 'broken')
                                    <span class="text-red-600">En Panne</span>
                                @else
                                    <span class="text-orange-600">En Maintenance</span>
                                @endif
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date d'Ajout</dt>
                        <dd class="text-lg text-gray-900">{{ $vehicle->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Statut Détaillé -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">État</h2>
                <div class="bg-gray-50 p-6 rounded-lg border-2 {{ $vehicle->status === 'operational' ? 'border-green-200' : ($vehicle->status === 'broken' ? 'border-red-200' : 'border-orange-200') }}">
                    @if($vehicle->status === 'operational')
                        <p class="text-green-800">✓ Ce véhicule est actuellement opérationnel et disponible.</p>
                    @elseif($vehicle->status === 'broken')
                        <p class="text-red-800">✗ Ce véhicule est actuellement en panne.</p>
                    @else
                        <p class="text-orange-800">⚙ Ce véhicule est actuellement en cours de maintenance.</p>
                    @endif
                    
                    @if($vehicle->description)
                        <div class="mt-4 p-4 bg-white rounded border border-gray-200">
                            <p class="text-sm font-medium text-gray-600 mb-2">Détails:</p>
                            <p class="text-gray-800">{{ $vehicle->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('user.vehicles.index') }}" class="text-center px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium rounded-lg transition">
                    Retour à la Liste
                </a>
                @if($vehicle->status === 'operational')
                    <div class="flex-1 px-4 py-2 bg-green-50 border border-green-200 rounded-lg text-green-800 text-center">
                        Ce véhicule est disponible pour les opérations
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
