@extends('layouts.app')

@section('title', __('products.title_top_commented'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('products.top_commented_heading') }}</h1>

    <ol class="space-y-3">
        @foreach ($viewData['products'] as $product)
            <li class="bg-white rounded shadow p-4 flex flex-wrap items-center gap-4">
                <span class="w-9 h-9 shrink-0 bg-slate-800 text-white rounded-full flex items-center justify-center font-bold text-sm">{{ $loop->iteration }}</span>

                <a href="{{ route('products.show', ['id' => $product->getId()]) }}" class="flex-1 min-w-[12rem] font-semibold text-gray-800 hover:text-slate-600 transition">{{ $product->getName() }}</a>

                <span class="bg-slate-100 text-slate-700 text-xs font-medium px-3 py-1 rounded">{{ trans_choice('products.comments_count', $product->getReviewsCount()) }}</span>
            </li>
        @endforeach
    </ol>
@endsection
