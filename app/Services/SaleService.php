<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function createSale(array $data, User $user): Sale
    {
        return DB::transaction(function () use ($data, $user) {
            $sale = Sale::create([
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => $user->id,
                'discount' => $data['discount'] ?? 0,
                'payment_method' => $data['payment_method'],
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Estoque insuficiente para o produto: {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['quantity']);

                $total += $subtotal;
            }

            $sale->update([
                'total' => $total,
                'grand_total' => $total - ($data['discount'] ?? 0),
                'status' => 'completed',
            ]);

            return $sale;
        });
    }

    public function cancelSale(Sale $sale): void
    {
        if ($sale->status === 'cancelled') {
            throw new \Exception('Venda já está cancelada');
        }

        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $sale->update(['status' => 'cancelled']);
        });
    }
}