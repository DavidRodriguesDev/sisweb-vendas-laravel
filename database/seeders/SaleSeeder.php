<?php
namespace Database\Seeders;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class SaleSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa dados anteriores para evitar duplicatas
        Payment::query()->delete();
        SaleItem::query()->delete();
        Sale::query()->delete();

        $salesData = [
            ['date' => '2026-04-02', 'customer_id' => 1, 'user_id' => 1, 'items' => [1 => 2, 3 => 1], 'payment' => 'pix', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-03', 'customer_id' => 2, 'user_id' => 2, 'items' => [2 => 1], 'payment' => 'credit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-05', 'customer_id' => 3, 'user_id' => 1, 'items' => [7 => 5, 8 => 3], 'payment' => 'cash', 'discount' => 50, 'status' => 'completed'],
            ['date' => '2026-04-08', 'customer_id' => 1, 'user_id' => 1, 'items' => [4 => 1, 5 => 1], 'payment' => 'debit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-10', 'customer_id' => 4, 'user_id' => 2, 'items' => [9 => 2, 10 => 3], 'payment' => 'boleto', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-12', 'customer_id' => 5, 'user_id' => 1, 'items' => [1 => 1, 2 => 1, 3 => 2], 'payment' => 'pix', 'discount' => 100, 'status' => 'completed'],
            ['date' => '2026-04-15', 'customer_id' => 2, 'user_id' => 2, 'items' => [6 => 1], 'payment' => 'credit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-17', 'customer_id' => 3, 'user_id' => 1, 'items' => [8 => 10, 9 => 5], 'payment' => 'cash', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-20', 'customer_id' => null, 'user_id' => 1, 'items' => [1 => 1], 'payment' => 'cash', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-22', 'customer_id' => 4, 'user_id' => 2, 'items' => [4 => 2, 7 => 3], 'payment' => 'pix', 'discount' => 75, 'status' => 'completed'],
            ['date' => '2026-04-25', 'customer_id' => 1, 'user_id' => 1, 'items' => [5 => 1, 10 => 2], 'payment' => 'debit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-04-28', 'customer_id' => 5, 'user_id' => 2, 'items' => [2 => 2, 3 => 1, 4 => 1], 'payment' => 'boleto', 'discount' => 0, 'status' => 'cancelled'],
            ['date' => '2026-05-01', 'customer_id' => 2, 'user_id' => 1, 'items' => [6 => 2, 8 => 5], 'payment' => 'pix', 'discount' => 80, 'status' => 'completed'],
            ['date' => '2026-05-03', 'customer_id' => 3, 'user_id' => 2, 'items' => [1 => 1, 7 => 2], 'payment' => 'cash', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-05', 'customer_id' => 1, 'user_id' => 1, 'items' => [4 => 1, 5 => 2, 10 => 1], 'payment' => 'credit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-08', 'customer_id' => 4, 'user_id' => 2, 'items' => [3 => 4, 9 => 3], 'payment' => 'boleto', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-10', 'customer_id' => 5, 'user_id' => 1, 'items' => [2 => 1, 6 => 1, 8 => 2], 'payment' => 'pix', 'discount' => 40, 'status' => 'completed'],
            ['date' => '2026-05-12', 'customer_id' => null, 'user_id' => 2, 'items' => [10 => 3], 'payment' => 'cash', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-15', 'customer_id' => 1, 'user_id' => 1, 'items' => [1 => 2, 4 => 1, 7 => 3], 'payment' => 'debit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-18', 'customer_id' => 2, 'user_id' => 2, 'items' => [5 => 2, 9 => 1], 'payment' => 'pix', 'discount' => 30, 'status' => 'completed'],
            ['date' => '2026-05-20', 'customer_id' => 3, 'user_id' => 1, 'items' => [8 => 4, 10 => 2], 'payment' => 'cash', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-22', 'customer_id' => 4, 'user_id' => 2, 'items' => [1 => 1, 2 => 1, 3 => 1, 4 => 1], 'payment' => 'boleto', 'discount' => 0, 'status' => 'pending'],
            ['date' => '2026-05-25', 'customer_id' => 1, 'user_id' => 1, 'items' => [6 => 1, 7 => 2], 'payment' => 'credit_card', 'discount' => 0, 'status' => 'completed'],
            ['date' => '2026-05-27', 'customer_id' => 5, 'user_id' => 2, 'items' => [5 => 3, 6 => 1], 'payment' => 'pix', 'discount' => 20, 'status' => 'completed'],
            ['date' => '2026-05-28', 'customer_id' => 2, 'user_id' => 1, 'items' => [9 => 4, 10 => 2], 'payment' => 'cash', 'discount' => 0, 'status' => 'completed'],
        ];

        foreach ($salesData as $saleData) {
            $sale = Sale::create([
                'customer_id' => $saleData['customer_id'],
                'user_id'     => $saleData['user_id'],
                'total'       => 0,
                'discount'    => $saleData['discount'],
                'grand_total' => 0,
                'status'      => $saleData['status'],
                'payment_method' => $saleData['payment'],
                'notes'       => 'Venda demonstrativa - ' . Str::random(10),
                'created_at'  => $saleData['date'] . ' 10:00:00',
                'updated_at'  => $saleData['date'] . ' 10:00:00',
            ]);

            $total = 0;
            foreach ($saleData['items'] as $productId => $quantity) {
                $product  = Product::find($productId);
                $subtotal = $product->price * $quantity;
                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $productId,
                    'quantity'   => $quantity,
                    'unit_price' => $product->price,
                    'subtotal'   => $subtotal,
                    'created_at' => $saleData['date'] . ' 10:00:00',
                    'updated_at' => $saleData['date'] . ' 10:00:00',
                ]);
                $total += $subtotal;
            }

            $grandTotal = $total - $saleData['discount'];
            $sale->update(['total' => $total, 'grand_total' => $grandTotal]);

            if ($saleData['status'] !== 'cancelled') {
                Payment::create([
                    'sale_id'    => $sale->id,
                    'method'     => $saleData['payment'],
                    'amount'     => $grandTotal,
                    'status'     => $saleData['status'] === 'completed' ? 'confirmed' : 'pending',
                    'reference'  => 'REF-' . strtoupper(Str::random(8)),
                    'paid_at'    => $saleData['status'] === 'completed' ? $saleData['date'] . ' 10:30:00' : null,
                    'created_at' => $saleData['date'] . ' 10:00:00',
                    'updated_at' => $saleData['date'] . ' 10:00:00',
                ]);
            }
        }

        $this->command->info('25 vendas demonstrativas criadas com sucesso!');
    }
}
