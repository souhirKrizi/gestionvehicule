<!-- resources/views/user/messages/create.blade.php -->
@extends('layouts.user')

@section('title', 'Nouveau Message')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">📩 Contacter l'Administrateur</h2>
        <p class="text-gray-600 mt-2">Envoyez un message à Ali Krizi</p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('user.messages.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📋 Sujet <span class="text-red-500">*</span>
                </label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Ex: Demande de réservation de véhicule">
                @error('subject')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    ✏️ Message <span class="text-red-500">*</span>
                </label>
                <textarea name="content" rows="8" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Écrivez votre message ici...">{{ old('content') }}</textarea>
                @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
                <p class="text-sm text-blue-800">
                    <strong>💡 Conseil:</strong> Soyez précis dans votre demande pour obtenir une réponse rapide.
                </p>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    📤 Envoyer le message
                </button>
                <a href="{{ route('user.messages.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection