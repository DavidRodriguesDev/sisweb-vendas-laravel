@extends('layouts.app')

@section('title', 'Detalhes do Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">{{ $customer->name }}</h2>
        <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Editar</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div><span class="font-bold">E-mail:</span> {{ $customer->email ?? '-' }}</div>
            <div><span class="font-bold">Telefone:</span> {{ $customer->phone ?? '-' }}</div>
            <div><span class="font-bold">Documento:</span> {{ $customer->document ?? '-' }}</div>
            <div><span class="font-bold">Endereço:</span> {{ $customer->address ?? '-' }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4">Histórico de Compras</h3>
        @if($customer->sales->isEmpty())
        <p class="text-gray-500">Nenhuma venda encontrada.</p>
        @else
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-2 px-4">Data</th>
                    <th class="text-left py-2 px-4">Status</th>
                    <th class="text-right py-2 px-4">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->sales as $sale)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded text-xs {{ $sale->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4 text-right">R$ {{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Voltar para Clientes</a>
    </div>
</div>
@endsection