@extends('layouts.admin')

@section('title', __('categories.title_index'))

@section('content')
    <h1>{{ __('categories.title_index') }}</h1>
    <a href="{{ route('admin.categories.create') }}">{{ __('categories.new_link') }}</a>

    <table>
        <thead>
            <tr>
                <th>{{ __('categories.name') }}</th>
                <th>{{ __('categories.products_count') }}</th>
                <th>{{ __('categories.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['categories'] as $category)
                <tr>
                    <td>{{ $category->getName() }}</td>
                    <td>{{ $category->getProductsCount() }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}">{{ __('categories.edit') }}</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('{{ __('categories.confirm_delete') }}')">{{ __('categories.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $viewData['categories']->links() }}
@endsection