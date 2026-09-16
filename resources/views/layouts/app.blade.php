<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tienda de Tecnología')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('products.index') }}">Productos</a>
            <a href="{{ route('products.top-commented') }}">Más comentados</a>
            @auth
                <a href="{{ route('orders.index') }}">Mis pedidos</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.index') }}">Panel Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}">Registrarse</a>
            @endauth
        </nav>
    </header>

    <main>
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
