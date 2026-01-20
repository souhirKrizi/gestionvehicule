<!-- resources/views/admin/messages/reply.blade.php -->
@extends('layouts.admin')

@section('page-title', 'Répondre au Message')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Répondre au Message</h2>
    
    <!-- Message Original -->
    <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div class="mb-4">
            <p class="text-sm text-gray-500">De: {{ $message->user->name }} ({{ $message->user->email }})</p>
            <h3 class="text-xl font-semibold text-gray-900">{{ $message->subject }}</h3>
        </div>
        <div class="text-gray-700 whitespace-pre-wrap">{{ $message->content }}</div>
    </div>

    <!-- Formulaire de réponse -->
    <form method="POST" action="{{ route('admin.messages.reply', $message) }}" class="space-y-6">
        @csrf

        <div>
            <label for="admin_reply" class="block text-sm font-medium text-gray-700 mb-2">Votre Réponse</label>
            <textarea
                id="admin_reply"
                name="admin_reply"
                rows="8"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('admin_reply') border-red-500 @enderror"
                placeholder="Tapez votre réponse ici..."
                required>{{ old('admin_reply') }}</textarea>
            @error('admin_reply')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                Envoyer la Réponse
            </button>
            <a href="{{ route('admin.messages.index') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
