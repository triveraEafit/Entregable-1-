@extends('layouts.admin')

@section('title', __('products.title_index'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('products.title_index') }}</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700 transition">
            {{ __('products.new_link') }}
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.image') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.name') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.brand') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.category') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.price') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.stock') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.active') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('products.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($viewData['products'] as $product)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($product->getImage())
                                <img src="{{ asset('storage/'.$product->getImage()) }}" alt="{{ $product->getName() }}" class="w-14 h-14 object-cover rounded">
                            @else
                                <span class="text-sm text-gray-400">{{ __('products.no_image') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $product->getName() }}</td>
                        <td class="px-4 py-3">{{ $product->getBrand()->getName() }}</td>
                        <td class="px-4 py-3">{{ $product->getCategory()->getName() }}</td>
                        <td class="px-4 py-3">{{ $product->getFormattedPrice() }}</td>
                        <td class="px-4 py-3">{{ $product->getStock() }}</td>
                        <td class="px-4 py-3">
                            @if ($product->getActive())
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ __('products.yes') }}</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded">{{ __('products.no') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.products.edit', ['id' => $product->getId()]) }}" class="inline-block bg-amber-500 text-white px-3 py-1 rounded text-sm hover:bg-amber-600 transition">
                                {{ __('products.edit') }}
                            </a>
                            @if ($product->getActive())
                                <form action="{{ route('admin.products.deactivate', ['id' => $product->getId()]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('{{ __('products.confirm_deactivate') }}')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                                        {{ __('products.deactivate') }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">{{ __('products.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $viewData['products']->links() }}
    </div>
@endsection
