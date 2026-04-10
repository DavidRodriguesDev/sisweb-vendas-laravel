@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Categorias</h2>
    <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nova Categoria</a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" action="{{ route('categories.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categoria..." class="flex-1 px-3 py-2 border rounded">
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Buscar</button>
    </form>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="text-left py-3 px-4">Nome</th>
                <th class="text-left py-3 px-4">Slug</th>
                <th class="text-left py-3 px-4">Descrição</th>
                <th class="text-center py-3 px-4">Status</th>
                <th class="text-center py-3 px-4">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $category->name }}</td>
                <td class="py-2 px-4 text-gray-500">{{ $category->slug }}</td>
                <td class="py-2 px-4">{{ $category->description ?? '-' }}</td>
                <td class="py-2 px-4 text-center">
                    <span class="px-2 py-1 rounded text-xs {{ $category->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $category->active ? 'Ativa' : 'Inativa' }}
                    </span>
                </td>
                <td class="py-2 px-4 text-center">
                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 mr-2">Editar</a>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Confirmar exclusão?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->withQueryString()->links() }}
</div>
@endsection