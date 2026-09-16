<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin · @yield('title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-800 text-white flex flex-col">
            <div class="p-6 border-b border-slate-700">
                <h2 class="text-lg font-bold">Panel Administrador</h2>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700 transition">Productos</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700 transition">Categorías</a>
                <a href="{{ route('admin.brands.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700 transition">Marcas</a>
            </nav>
            <div class="p-4 border-t border-slate-700">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded hover:bg-slate-700 transition text-sm text-slate-300">← Ver tienda pública</a>
            </div>
        </aside>

        <section class="flex-1 p-8">
            @if (session('status'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </section>
    </div>
</body>
</html>