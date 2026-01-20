<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Gestion du Véhicule</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .military-gradient {
            background: linear-gradient(135deg, #1a3a1a 0%, #2d5016 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 military-gradient text-white flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center text-2xl">
                        🎖️
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Gestion du Véhicule</h1>
                        <p class="text-xs text-gray-300">Administration</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                        <span class="text-xl">📊</span>
                        <span>Tableau de bord</span>
                    </a>
                    
                    <a href="{{ route('admin.vehicles.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.vehicles.*') ? 'bg-white/20' : '' }}">
                        <span class="text-xl">🚗</span>
                        <span>Véhicules</span>
                    </a>
                    
                    <a href="{{ route('admin.messages.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.messages.*') ? 'bg-white/20' : '' }}">
                        <span class="text-xl">📩</span>
                        <span>Messages</span>
                        @if($unreadCount = \App\Models\Message::unread()->count())
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : '' }}">
                        <span class="text-xl">👥</span>
                        <span>Utilisateurs</span>
                        @if($pendingCount = \App\Models\User::where('status', 'pending')->count())
                        <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- Admin Info -->
            <div class="absolute bottom-0 w-64 p-6 border-t border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-300">Administrateur</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-800">@yield('page-title')</h2>
                        
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-600">
                                📞 Contact: <strong>21863548</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="mx-8 mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="mx-8 mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                ❌ {{ session('error') }}
            </div>
            @endif

            <!-- Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>