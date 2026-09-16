<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin · @yield('title', 'Panel')</title>
</head>
<body class="admin-panel">
    <aside class="admin-sidebar">
        <h2>Panel Administrador</h2>
        <nav>
            <a href="{{ route('admin.products.index') }}">Productos</a>
            <a href="{{ route('admin.categories.index') }}">Categorías</a>
            <a href="{{ route('admin.brands.index') }}">Marcas</a>
            <a href="{{ route('home') }}">Ver tienda pública</a>
        </nav>
    </aside>

    <section class="admin-content">
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        @yield('content')
    </section>
</body>
</html>
