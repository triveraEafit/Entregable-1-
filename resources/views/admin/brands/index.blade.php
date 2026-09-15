@extends('layouts.admin')

@section('title', __('brands.title_index'))

@section('content')
    <h1>{{ __('brands.title_index') }}</h1>
    <a href="{{ route('admin.brands.create') }}">{{ __('brands.new_link') }}</a>

    <table>
        <thead>
            <tr>
                <th>{{ __('brands.name') }}</th>
                <th>{{ __('brands.country') }}</th>
                <th>{{ __('brands.products_count') }}</th>
                <th>{{ __('brands.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->getName() }}</td>
                    <td>{{ $brand->getCountry() }}</td>
                    <td>{{ $brand->getProductsCount() }}</td>
                    <td>
                        <a href="{{ route('admin.brands.edit', $brand) }}">{{ __('brands.edit') }}</a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('{{ __('brands.confirm_delete') }}')">{{ __('brands.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $brands->links() }}
@endsection