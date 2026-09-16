@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="bg-slate-800 text-white rounded-lg px-8 py-12 mb-8">
        <h1 class="text-4xl font-bold mb-3">{{ __('home.heading') }}</h1>
        <p class="text-slate-300 text-lg">{{ __('home.intro') }}</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('products.index') }}" class="bg-white rounded shadow p-6 hover:shadow-lg transition block">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ __('home.catalog_link') }}</h2>
            <span class="text-sm text-slate-600">Explora todo el catálogo →</span>
        </a>

        <a href="{{ route('products.top-selling') }}" class="bg-white rounded shadow p-6 hover:shadow-lg transition block">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ __('home.top_selling_link') }}</h2>
            <span class="text-sm text-slate-600">Lo que más se vende →</span>
        </a>

        <a href="{{ route('products.top-commented') }}" class="bg-white rounded shadow p-6 hover:shadow-lg transition block">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ __('home.top_commented_link') }}</h2>
            <span class="text-sm text-slate-600">Lo que más comentan →</span>
        </a>
    </div>
@endsection
