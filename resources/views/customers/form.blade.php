@extends('layouts.app')

@section('title', $customer->exists ? 'Editar Cliente' : 'Novo Cliente')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $customer->exists ? 'Editar Cliente' : 'Novo Cliente' }}</h2>

    <form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}">
        @csrf
        @if($customer->exists) @method('PUT') @endif

        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}"
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}"
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Documento (CPF/CNPJ)</label>
                <input type="text" name="document" value="{{ old('document', $customer->document ?? '') }}"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Endereço</label>
                <textarea name="address" rows="2" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $customer->address ?? '') }}</textarea>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            </div>
        </div>
    </form>
</div>
@endsection