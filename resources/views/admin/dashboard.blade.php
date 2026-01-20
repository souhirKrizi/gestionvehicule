<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Véhicules -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Véhicules</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_vehicles'] }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl">
                    🚗
                </div>
            </div>
        </div>

        <!-- Véhicules Fonctionnels -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Fonctionnels</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['operational'] }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center text-3xl">
                    🟢
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_vehicles'] > 0 ? ($stats['operational'] / $stats['total_vehicles'] * 100) : 0 }}%"></div>
                </div>
                <span class="ml-2 text-xs text-gray-600">{{ $stats['total_vehicles'] > 0 ? round($stats['operational'] / $stats['total_vehicles'] * 100) : 0 }}%</span>
            </div>
        </div>

        <!-- Véhicules en Panne -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">En Panne</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['broken'] }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center text-3xl">
                    🔴
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $stats['total_vehicles'] > 0 ? ($stats['broken'] / $stats['total_vehicles'] * 100) : 0 }}%"></div>
                </div>
                <span class="ml-2 text-xs text-gray-600">{{ $stats['total_vehicles'] > 0 ? round($stats['broken'] / $stats['total_vehicles'] * 100) : 0 }}%</span>
            </div>
        </div>

        <!-- En Maintenance -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">En Traitement</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['maintenance'] }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center text-3xl">
                    🟠
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $stats['total_vehicles'] > 0 ? ($stats['maintenance'] / $stats['total_vehicles'] * 100) : 0 }}%"></div>
                </div>
                <span class="ml-2 text-xs text-gray-600">{{ $stats['total_vehicles'] > 0 ? round($stats['maintenance'] / $stats['total_vehicles'] * 100) : 0 }}%</span>
            </div>
        </div>
    </div>

    <!-- Actions Rapides et Messages Récents -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Actions Rapides -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">⚡ Actions Rapides</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.vehicles.create') }}" 
                   class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-lg transition border border-green-200">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">➕</span>
                        <span class="font-medium text-gray-900">Ajouter un véhicule</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('admin.messages.index') }}" 
                   class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition border border-blue-200">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">📩</span>
                        <div>
                            <p class="font-medium text-gray-900">Messages non lus</p>
                            <p class="text-sm text-gray-600">{{ $stats['unread_messages'] }} nouveau(x)</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center justify-between p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition border border-orange-200">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">👤</span>
                        <div>
                            <p class="font-medium text-gray-900">Comptes en attente</p>
                            <p class="text-sm text-gray-600">{{ $stats['pending_users'] }} à approuver</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Messages Récents -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">📨 Messages Récents</h3>
                <a href="{{ route('admin.messages.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                    Tout voir →
                </a>
            </div>
            
            @if($recent_messages->isEmpty())
            <p class="text-gray-500 text-center py-8">Aucun message</p>
            @else
            <div class="space-y-3">
                @foreach($recent_messages as $message)
                <a href="{{ route('admin.messages.show', $message) }}" 
                   class="block p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $message->subject }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($message->content, 60) }}</p>
                            <p class="text-xs text-gray-500 mt-2">👤 {{ $message->user->name }} • {{ $message->created_at->diffForHumans() }}</p>
                        </div>
                        @if($message->status === 'unread')
                        <span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection