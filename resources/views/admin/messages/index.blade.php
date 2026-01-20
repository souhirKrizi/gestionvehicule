@extends('layouts.admin')

@section('page-title', 'Gestion des Messages')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-700">{{ $messages->total() }} message(s)</h3>
    </div>

    <!-- Liste des messages -->
    @if($messages->isEmpty())
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="text-6xl mb-4">📭</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun message</h3>
        <p class="text-gray-600">Vous n'avez aucun message pour le moment</p>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="divide-y divide-gray-200">
            @foreach($messages as $message)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-sm font-bold text-blue-800">
                                {{ strtoupper(substr($message->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $message->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-900 ml-13">{{ $message->subject }}</p>
                        <p class="text-sm text-gray-600 ml-13 line-clamp-2">{{ $message->content }}</p>
                    </div>
                    <div class="ml-4 flex items-center space-x-3">
                        @if($message->status === 'unread')
                        <span class="px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">Non lu</span>
                        @elseif($message->status === 'replied')
                        <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Répondu</span>
                        @else
                        <span class="px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">Lu</span>
                        @endif
                        <a href="{{ route('admin.messages.show', $message) }}" 
                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition">
                            Voir
                        </a>
                    </div>
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

