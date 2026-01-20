<!-- resources/views/layouts/user.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Utilisateur') - Gestion du Véhicule</title>
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
    <!-- Header -->
    <header class="military-gradient text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo et Titre -->
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center text-2xl">
                        🎖️
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Gestion du Véhicule</h1>
                        <p class="text-xs text-gray-300">Gestion de la Flotte</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('user.vehicles.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('user.vehicles.*') ? 'bg-white/20' : '' }}">
                        <span>🚗</span>
                        <span class="font-medium">Véhicules</span>
                    </a>
                    
                    <a href="{{ route('user.messages.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('user.messages.*') ? 'bg-white/20' : '' }}">
                        <span>📩</span>
                        <span class="font-medium">Messages</span>
                    </a>

                    <a href="tel:21863548" 
                       class="flex items-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg transition">
                        <span>📞</span>
                        <span class="font-medium">Appeler Admin</span>
                    </a>
                </nav>

                <!-- User Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white/10 transition">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden md:block font-medium">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 text-gray-900">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex items-center space-x-2">
                                <span>🚪</span>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden border-t border-white/10">
            <div class="px-4 py-3 flex items-center justify-around">
                <a href="{{ route('user.vehicles.index') }}" 
                   class="flex flex-col items-center space-y-1 {{ request()->routeIs('user.vehicles.*') ? 'text-green-300' : 'text-gray-300' }}">
                    <span class="text-xl">🚗</span>
                    <span class="text-xs">Véhicules</span>
                </a>
                
                <a href="{{ route('user.messages.index') }}" 
                   class="flex flex-col items-center space-y-1 {{ request()->routeIs('user.messages.*') ? 'text-green-300' : 'text-gray-300' }}">
                    <span class="text-xl">📩</span>
                    <span class="text-xs">Messages</span>
                </a>

                <a href="tel:21863548" 
                   class="flex flex-col items-center space-y-1 text-green-300">
                    <span class="text-xl">📞</span>
                    <span class="text-xs">Appeler</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Contact Banner -->
        <div class="mb-6 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg p-4 shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">📞</span>
                    <div>
                        <p class="font-semibold">Besoin d'assistance ?</p>
                        <p class="text-sm text-green-100">Contactez l'administrateur Ali Krizi</p>
                    </div>
                </div>
                <a href="tel:21863548" 
                   class="hidden sm:flex items-center space-x-2 px-4 py-2 bg-white text-green-700 font-medium rounded-lg hover:bg-green-50 transition">
                    <span>📱</span>
                    <span>21863548</span>
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <span class="text-xl mr-3">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
            <span class="text-xl mr-3">❌</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="military-gradient text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-sm text-gray-300">
                    © {{ date('Y') }} Gestion du Véhicule - Gestion de la Flotte
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Développé avec ❤️ pour l'excellence opérationnelle
                </p>
            </div>
        </div>
    </footer>
</body>
</html>