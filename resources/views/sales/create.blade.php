@extends('layouts.app')

@section('title', 'Nova Venda')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nova Venda</h2>

    <form method="POST" action="{{ route('sales.store') }}" x-data="saleForm()">
        @csrf

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold mb-4">Dados da Venda</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Cliente</label>
                    <select name="customer_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sem cliente (venda avulsa)</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Forma de Pagamento *</label>
                    <select name="payment_method" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="cash">Dinheiro</option>
                        <option value="credit_card">Cartão de Crédito</option>
                        <option value="debit_card">Cartão de Débito</option>
                        <option value="pix">PIX</option>
                        <option value="boleto">Boleto</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Desconto (R$)</label>
                <input type="number" name="discount" step="0.01" value="0" min="0"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Observações</label>
                <textarea name="notes" rows="2" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold mb-4">Itens da Venda</h3>

            <div class="flex gap-2 mb-4">
                <select id="product-select" class="flex-1 px-3 py-2 border rounded">
                    <option value="">Selecione um produto...</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}">{{ $product->name }} - R$ {{ number_format($product->price, 2, ',', '.') }} (Estoque: {{ $product->stock }})</option>
                    @endforeach
                </select>
                <input type="number" id="item-quantity" value="1" min="1" class="w-24 px-3 py-2 border rounded">
                <button type="button" @click="addItem()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Adicionar</button>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left py-2 px-4">Produto</th>
                        <th class="text-right py-2 px-4">Qtd</th>
                        <th class="text-right py-2 px-4">Preço Unit.</th>
                        <th class="text-right py-2 px-4">Subtotal</th>
                        <th class="text-center py-2 px-4">Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="border-b">
                            <td class="py-2 px-4">
                                <span x-text="item.name"></span>
                                <input type="hidden" :name="'items[' + index + '][product_id]'" :value="item.product_id">
                                <input type="hidden" :name="'items[' + index + '][quantity]'" :value="item.quantity">
                            </td>
                            <td class="py-2 px-4 text-right" x-text="item.quantity"></td>
                            <td class="py-2 px-4 text-right" x-text="formatCurrency(item.unit_price)"></td>
                            <td class="py-2 px-4 text-right font-bold" x-text="formatCurrency(item.subtotal)"></td>
                            <td class="py-2 px-4 text-center">
                                <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-800">X</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div class="mt-4 text-right">
                <p class="text-lg font-bold">Total: <span x-text="formatCurrency(total)"></span></p>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Finalizar Venda</button>
        </div>
    </form>
</div>

<script>
function saleForm() {
    return {
        items: [],
        total: 0,
        addItem() {
            const select = document.getElementById('product-select');
            const qtyInput = document.getElementById('item-quantity');
            const option = select.options[select.selectedIndex];

            if (!select.value) return;

            const item = {
                product_id: select.value,
                name: option.dataset.name,
                unit_price: parseFloat(option.dataset.price),
                quantity: parseInt(qtyInput.value) || 1,
                subtotal: parseFloat(option.dataset.price) * (parseInt(qtyInput.value) || 1)
            };

            this.items.push(item);
            this.calculateTotal();
            select.value = '';
            qtyInput.value = '1';
        },
        removeItem(index) {
            this.items.splice(index, 1);
            this.calculateTotal();
        },
        calculateTotal() {
            this.total = this.items.reduce((sum, item) => sum + item.subtotal, 0);
        },
        formatCurrency(value) {
            return 'R$ ' + parseFloat(value).toFixed(2).replace('.', ',');
        }
    };
}
</script>
@endsection