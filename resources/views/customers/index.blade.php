@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Clientes</h2>
    <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Cliente</a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" action="{{ route('customers.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome, e-mail, documento ou telefone..." class="flex-1 px-3 py-2 border rounded">
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Buscar</button>
    </form>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="text-left py-3 px-4">Nome</th>
                <th class="text-left py-3 px-4">E-mail</th>
                <th class="text-left py-3 px-4">Telefone</th>
                <th class="text-left py-3 px-4">Documento</th>
                <th class="text-center py-3 px-4">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $customer->name }}</td>
                <td class="py-2 px-4">{{ $customer->email ?? '-' }}</td>
                <td class="py-2 px-4">{{ $customer->phone ?? '-' }}</td>
                <td class="py-2 px-4">{{ $customer->document ?? '-' }}</td>
                <td class="py-2 px-4 text-center">
                    <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-800 mr-2">Ver</a>
                    <a href="{{ route('customers.edit', $customer) }}" class="text-green-600 hover:text-green-800 mr-2">Editar</a>
                    <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="inline" onsubmit="return confirm('Confirmar exclusão?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $customers->withQueryString()->links() }}
</div>
@endsection