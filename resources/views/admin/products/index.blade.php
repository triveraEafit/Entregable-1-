@extends('layouts.admin')

@section('title', __('products.title_index'))

@section('content')
    <h1>{{ __('products.title_index') }}</h1>
    <a href="{{ route('admin.products.create') }}">{{ __('products.new_link') }}</a>

    <table>
        <thead>
            <tr>
                <th>{{ __('products.image') }}</th>
                <th>{{ __('products.name') }}</th>
                <th>{{ __('products.brand') }}</th>
                <th>{{ __('products.category') }}</th>
                <th>{{ __('products.price') }}</th>
                <th>{{ __('products.stock') }}</th>
                <th>{{ __('products.active') }}</th>
                <th>{{ __('products.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->getImage())
                            <img src="{{ asset('storage/'.$product->getImage()) }}" alt="{{ $product->getName() }}" width="60">
                        @else
                            {{ __('products.no_image') }}
                        @endif
                    </td>
                    <td>{{ $product->getName() }}</td>
                    <td>{{ $product->getBrand()->getName() }}</td>
                    <td>{{ $product->getCategory()->getName() }}</td>
                    <td>{{ $product->getFormattedPrice() }}</td>
                    <td>{{ $product->getStock() }}</td>
                    <td>{{ $product->getActive() ? __('products.yes') : __('products.no') }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', ['id' => $product->getId()]) }}">{{ __('products.edit') }}</a>
                        @if ($product->getActive())
                            <form action="{{ route('admin.products.deactivate', ['id' => $product->getId()]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('{{ __('products.confirm_deactivate') }}')">{{ __('products.deactivate') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">{{ __('products.empty') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
