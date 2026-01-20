<!-- resources/views/admin/messages/show.blade.php -->
@extends('layouts.admin')

@section('page-title', 'Message de ' . $message->user->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- En-tête -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-lg font-bold text-blue-800">
                        {{ strtoupper(substr($message->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $message->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $message->user->email }}</p>
                        <p class="text-xs text-gray-500">{{ $message->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
                
                @if($message->status === 'unread')
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    📩 Non lu
                </span>
                @elseif($message->status === 'replied')
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    ✅ Répondu
                </span>
                @endif
            </div>
        </div>

        <!-- Contenu du message -->
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $message->subject }}</h3>
            <div class="prose max-w-none">
                <p class="text-gray-700 whitespace-pre-line">{{ $message->content }}</p>
            </div>
        </div>

        <!-- Formulaire de réponse -->
        @if($message->status !== 'replied')
        <div class="border-t border-gray-200 p-6 bg-gray-50">
            <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📝 Votre réponse
                </label>
                <textarea name="admin_reply" rows="5" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('admin_reply') border-red-500 @enderror"
                          placeholder="Écrivez votre réponse...">{{ old('admin_reply') }}</textarea>
                @error('admin_reply')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <div class="flex items-center space-x-3 mt-4">
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                        ✅ Envoyer la réponse
                    </button>
                    <a href="{{ route('admin.messages.index') }}" 
                       class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                        Retour
                    </a>
                </div>
            </form>
        </div>
        @else
        <div class="border-t border-gray-200 p-6 bg-green-50">
            <p class="text-sm font-medium text-gray-700 mb-2">✅ Votre réponse:</p>
            <div class="bg-white p-4 rounded-lg border border-green-200">
                <p class="text-gray-700 whitespace-pre-line">{{ $message->admin_reply }}</p>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.messages.index') }}" 
                   class="inline-block px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                    Retour aux messages
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
