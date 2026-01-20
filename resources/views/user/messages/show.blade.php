<!-- resources/views/user/messages/show.blade.php -->
@extends('layouts.user')

@section('title', 'Détails du Message')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-8">
        <!-- Titre et Navigation -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $message->subject }}</h1>
            <a href="{{ route('user.messages.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← Retour</a>
        </div>

        <!-- Métadonnées -->
        <div class="flex flex-wrap gap-4 mb-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-xs text-gray-500 uppercase">Statut</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($message->status === 'unread') bg-yellow-100 text-yellow-800
                    @elseif($message->status === 'read') bg-blue-100 text-blue-800
                    @elseif($message->status === 'replied') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($message->status) }}
                </span>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Date d'Envoi</p>
                <p class="text-sm font-medium text-gray-900">{{ $message->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>

        <!-- Contenu du Message -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Votre Message</h2>
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 whitespace-pre-wrap text-gray-800">
                {{ $message->content }}
            </div>
        </div>

        <!-- Réponse Admin (si présente) -->
        @if($message->admin_reply)
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Réponse de l'Administrateur</h2>
                <div class="bg-green-50 p-6 rounded-lg border-2 border-green-200 whitespace-pre-wrap text-gray-800">
                    {{ $message->admin_reply }}
                </div>
                <p class="text-xs text-gray-500 mt-2">Répondu le {{ $message->updated_at->format('d/m/Y à H:i') }}</p>
            </div>
        @else
            <div class="mb-8 bg-blue-50 p-6 rounded-lg border border-blue-200">
                <p class="text-blue-800">
                    ℹ️ Aucune réponse pour le moment. L'administrateur examinera votre message bientôt.
                </p>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('user.messages.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium rounded-lg transition">
                Retour à mes Messages
            </a>
            <a href="{{ route('user.messages.create') }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                Envoyer un Nouveau Message
            </a>
        </div>
    </div>
</div>
@endsection
