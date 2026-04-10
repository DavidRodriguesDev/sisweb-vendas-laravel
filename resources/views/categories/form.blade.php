@extends('layouts.app')

@section('title', $category->exists ? 'Editar Categoria' : 'Nova Categoria')

@section('content')
<div class="max-w-xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $category->exists ? 'Editar Categoria' : 'Nova Categoria' }}</h2>

    <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
        @csrf
        @if($category->exists) @method('PUT') @endif

        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" {{ old('active', ($category->active ?? true) ? '1' : '0') ? 'checked' : '' }} class="rounded">
                    <span class="text-gray-700 text-sm font-bold">Ativa</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            </div>
        </div>
    </form>
</div>
@endsection