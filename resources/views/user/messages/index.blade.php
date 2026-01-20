<!-- resources/views/user/messages/index.blade.php -->
@extends('layouts.user')

@section('title', 'Mes Messages')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold text-gray-900">📩 Mes Messages</h2>
        <a href="{{ route('user.messages.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
            <span class="mr-2">+</span>
            Nouveau Message
        </a>
    </div>

    <!-- Liste des messages -->
    @if($messages->isEmpty())
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="text-6xl mb-4">📭</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun message</h3>
        <p class="text-gray-600 mb-6">Vous n'avez envoyé aucun message pour le moment</p>
        <a href="{{ route('user.messages.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
            Envoyer un Message
        </a>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="divide-y divide-gray-200">
            @foreach($messages as $message)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $message->subject }}</h3>
                            @if($message->status === 'unread')
                            <span class="px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Non lu</span>
                            @elseif($message->status === 'replied')
                            <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Répondu</span>
                            @else
                            <span class="px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">Lu</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $message->content }}</p>
                        <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('user.messages.show', $message) }}" 
                       class="ml-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition">
                        Voir
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
