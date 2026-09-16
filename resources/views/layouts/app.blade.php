<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tienda de Tecnología')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-slate-800 text-white shadow">
        <nav class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap items-center gap-x-6 gap-y-2">
            <a href="{{ route('home') }}" class="font-bold text-lg mr-auto hover:text-slate-300 transition">
                Tienda de Tecnología
            </a>

            <a href="{{ route('products.index') }}" class="text-sm hover:text-slate-300 transition">Productos</a>
            <a href="{{ route('products.top-commented') }}" class="text-sm hover:text-slate-300 transition">{{ __('products.title_top_commented') }}</a>
            <a href="{{ route('products.top-selling') }}" class="text-sm hover:text-slate-300 transition">{{ __('products.title_top_selling') }}</a>

            @auth
                <a href="{{ route('orders.index') }}" class="text-sm hover:text-slate-300 transition">Mis pedidos</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="text-sm bg-amber-500 px-3 py-1 rounded hover:bg-amber-600 transition">Panel Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-slate-300 hover:text-white transition">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm hover:text-slate-300 transition">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="text-sm bg-white text-slate-800 px-3 py-1 rounded hover:bg-slate-200 transition">Registrarse</a>
            @endauth
        </nav>
    </header>

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-slate-800 text-slate-400 text-sm">
        <div class="max-w-6xl mx-auto px-4 py-4">Tienda de Tecnología</div>
    </footer>
</body>
</html>
