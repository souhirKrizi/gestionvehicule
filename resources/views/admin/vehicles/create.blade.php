<!-- resources/views/admin/vehicles/create.blade.php -->
@extends('layouts.admin')

@section('page-title', 'Ajouter un Véhicule')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" x-data="vehicleForm()">
            @csrf
            
            <!-- Nom du véhicule -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    🚗 Nom du véhicule <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="Ex: Toyota Hilux #123">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type de véhicule -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📋 Type de véhicule <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-4">
                    @foreach(\App\Models\Vehicle::TYPES as $key => $label)
                    <label class="relative">
                        <input type="radio" name="type" value="{{ $key }}" 
                               {{ old('type') === $key ? 'checked' : '' }}
                               class="peer sr-only" required>
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer transition
                                    peer-checked:border-green-500 peer-checked:bg-green-50
                                    hover:border-green-300 text-center">
                            <div class="text-3xl mb-2">
                                {{ $key === 'light' ? '🚗' : ($key === 'heavy' ? '🚚' : '🚙') }}
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ $label }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- État du véhicule -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    🔧 État du véhicule <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                    @foreach(\App\Models\Vehicle::STATUSES as $key => $label)
                    <label class="relative">
                        <input type="radio" name="status" value="{{ $key }}" 
                               x-model="status"
                               {{ old('status') === $key ? 'checked' : '' }}
                               class="peer sr-only" required>
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer transition
                                    peer-checked:border-{{ $key === 'operational' ? 'green' : ($key === 'broken' ? 'red' : 'orange') }}-500 
                                    peer-checked:bg-{{ $key === 'operational' ? 'green' : ($key === 'broken' ? 'red' : 'orange') }}-50
                                    hover:border-{{ $key === 'operational' ? 'green' : ($key === 'broken' ? 'red' : 'orange') }}-300
                                    flex items-center">
                            <span class="text-2xl mr-3">
                                {{ $key === 'operational' ? '🟢' : ($key === 'broken' ? '🔴' : '🟠') }}
                            </span>
                            <div>
                                <p class="font-medium text-gray-900">{{ $label }}</p>
                                <p class="text-sm text-gray-600">
                                    @if($key === 'operational')
                                    Véhicule fonctionnel et prêt à l'emploi
                                    @elseif($key === 'broken')
                                    Véhicule hors service - Description requise
                                    @else
                                    Véhicule en réparation ou diagnostic
                                    @endif
                                </p>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description (obligatoire si en panne) -->
            <div class="mb-6" x-show="status === 'broken' || status === 'maintenance'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📝 Description 
                    <span class="text-red-500" x-show="status === 'broken'">*</span>
                </label>
                <textarea name="description" rows="4" 
                          :required="status === 'broken'"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                          placeholder="Décrivez le problème ou l'intervention en cours...">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex items-center space-x-4">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    ✅ Ajouter le véhicule
                </button>
                <a href="{{ route('admin.vehicles.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function vehicleForm() {
    return {
        status: '{{ old("status", "operational") }}'
    }
}
</script>
@endsection