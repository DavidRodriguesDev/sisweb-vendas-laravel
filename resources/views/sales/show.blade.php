@extends('layouts.app')

@section('title', 'Venda #' . $sale->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Venda #{{ $sale->id }}</h2>
        <a href="{{ route('sales.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Voltar</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div><span class="font-bold">Cliente:</span> {{ $sale->customer?->name ?? 'Sem cliente' }}</div>
            <div><span class="font-bold">Vendedor:</span> {{ $sale->user->name }}</div>
            <div><span class="font-bold">Data:</span> {{ $sale->created_at->format('d/m/Y H:i') }}</div>
            <div><span class="font-bold">Status:</span>
                <span class="px-2 py-1 rounded text-xs {{ $sale->status === 'completed' ? 'bg-green-100 text-green-700' : ($sale->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ $sale->status === 'completed' ? 'Concluída' : ($sale->status === 'cancelled' ? 'Cancelada' : 'Pendente') }}
                </span>
            </div>
            <div><span class="font-bold">Forma de Pagamento:</span> {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}</div>
        </div>
        @if($sale->notes)
        <div class="mt-4"><span class="font-bold">Observações:</span> {{ $sale->notes }}</div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold mb-4">Itens</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-2 px-4">Produto</th>
                    <th class="text-right py-2 px-4">Qtd</th>
                    <th class="text-right py-2 px-4">Preço Unit.</th>
                    <th class="text-right py-2 px-4">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $item->product->name }}</td>
                    <td class="py-2 px-4 text-right">{{ $item->quantity }}</td>
                    <td class="py-2 px-4 text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t-2">
                    <td colspan="3" class="py-2 px-4 text-right font-bold">Subtotal:</td>
                    <td class="py-2 px-4 text-right">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="py-2 px-4 text-right font-bold">Desconto:</td>
                    <td class="py-2 px-4 text-right">R$ {{ number_format($sale->discount, 2, ',', '.') }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <td colspan="3" class="py-2 px-4 text-right font-bold text-lg">Total:</td>
                    <td class="py-2 px-4 text-right font-bold text-lg">R$ {{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($sale->payments->isNotEmpty())
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold mb-4">Pagamentos</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-2 px-4">Método</th>
                    <th class="text-right py-2 px-4">Valor</th>
                    <th class="text-center py-2 px-4">Status</th>
                    <th class="text-left py-2 px-4">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->payments as $payment)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>
                    <td class="py-2 px-4 text-right">R$ {{ number_format($payment->amount, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 text-center">
                        <span class="px-2 py-1 rounded text-xs {{ $payment->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4">{{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection