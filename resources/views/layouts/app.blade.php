<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Vendas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'" class="bg-gray-900 text-white transition-all duration-300 flex-shrink-0">
            <div class="p-4">
                <h1 class="text-xl font-bold text-white">Sistema de Vendas</h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('dashboard.*') ? 'bg-gray-700' : '' }}">
                    <span class="mr-3">&#9632;</span> Dashboard
                </a>
                @can('manage products')
                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('products.*') ? 'bg-gray-700' : '' }}">
                    <span class="mr-3">&#9632;</span> Produtos
                </a>
                @endcan
                @can('manage categories')
                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('categories.*') ? 'bg-gray-700' : '' }}">
                    <span class="mr-3">&#9632;</span> Categorias
                </a>
                @endcan
                @can('manage customers')
                <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('customers.*') ? 'bg-gray-700' : '' }}">
                    <span class="mr-3">&#9632;</span> Clientes
                </a>
                @endcan
                @can('manage sales')
                <a href="{{ route('sales.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('sales.*') ? 'bg-gray-700' : '' }}">
                    <span class="mr-3">&#9632;</span> Vendas
                </a>
                @endcan
                @can('view reports')
                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('reports.*') ? 'bg-gray-700' : '' }}">
                    <span class="mr-3">&#9632;</span> Relatórios
                </a>
                @endcan
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-4" x-data="{ open: false }">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <div class="relative">
                        <button @click="open = !open" class="text-sm text-gray-600 hover:text-gray-900">&#9660;</button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-1 z-50">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sair</a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="p-6">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>