<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.admin')

@section('page-title', 'Gestion des Utilisateurs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-700">{{ $users->total() }} utilisateur(s)</h3>
    </div>

    <!-- Liste des utilisateurs -->
    @if($users->isEmpty())
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <div class="text-6xl mb-4">👥</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun utilisateur</h3>
        <p class="text-gray-600">Aucun utilisateur n'a encore demandé l'accès</p>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Téléphone</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Statut</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($user->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Approuvé</span>
                            @elseif($user->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">En attente</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejeté</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2 flex-wrap">
                                @if($user->status === 'pending')
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded transition">
                                            ✓ Approuver
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition">
                                            ✗ Rejeter
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded transition">
                                        🗑 Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
