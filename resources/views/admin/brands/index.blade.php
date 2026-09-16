@extends('layouts.admin')

@section('title', __('brands.title_index'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('brands.title_index') }}</h1>
        <a href="{{ route('admin.brands.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700 transition">
            {{ __('brands.new_link') }}
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('brands.name') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('brands.country') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('brands.products_count') }}</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('brands.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($viewData['brands'] as $brand)
                    <tr>
                        <td class="px-4 py-3">{{ $brand->getName() }}</td>
                        <td class="px-4 py-3">{{ $brand->getCountry() }}</td>
                        <td class="px-4 py-3">{{ $brand->getProductsCount() }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="inline-block bg-amber-500 text-white px-3 py-1 rounded text-sm hover:bg-amber-600 transition">
                                {{ __('brands.edit') }}
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('{{ __('brands.confirm_delete') }}')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                                    {{ __('brands.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $viewData['brands']->links() }}
    </div>
@endsection