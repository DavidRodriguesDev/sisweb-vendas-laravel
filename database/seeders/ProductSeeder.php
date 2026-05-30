<?php
namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Smartphone Samsung Galaxy', 'sku' => 'ELE-001', 'price' => 1299.90, 'cost' => 900.00, 'stock' => 50, 'min_stock' => 5, 'category_id' => 1],
            ['name' => 'Notebook Dell Inspiron', 'sku' => 'INF-001', 'price' => 3499.00, 'cost' => 2500.00, 'stock' => 20, 'min_stock' => 3, 'category_id' => 2],
            ['name' => 'Mouse Logitech MX', 'sku' => 'INF-002', 'price' => 349.90, 'cost' => 200.00, 'stock' => 100, 'min_stock' => 10, 'category_id' => 2],
            ['name' => 'Teclado Mecânico', 'sku' => 'INF-003', 'price' => 299.90, 'cost' => 150.00, 'stock' => 45, 'min_stock' => 5, 'category_id' => 2],
            ['name' => 'Monitor LG 27"', 'sku' => 'INF-004', 'price' => 1599.00, 'cost' => 1100.00, 'stock' => 15, 'min_stock' => 3, 'category_id' => 2],
            ['name' => 'Cadeira Gamer', 'sku' => 'ESP-001', 'price' => 899.90, 'cost' => 500.00, 'stock' => 30, 'min_stock' => 5, 'category_id' => 4],
            ['name' => 'Camiseta Polo', 'sku' => 'ROUP-001', 'price' => 79.90, 'cost' => 30.00, 'stock' => 200, 'min_stock' => 20, 'category_id' => 5],
            ['name' => 'Café Premium 500g', 'sku' => 'ALI-001', 'price' => 29.90, 'cost' => 15.00, 'stock' => 300, 'min_stock' => 30, 'category_id' => 6],
            ['name' => 'Vaso de Planta Decorativo', 'sku' => 'CASA-001', 'price' => 49.90, 'cost' => 20.00, 'stock' => 80, 'min_stock' => 10, 'category_id' => 3],
            ['name' => 'Fone de Ouvido Bluetooth', 'sku' => 'ELE-002', 'price' => 199.90, 'cost' => 80.00, 'stock' => 60, 'min_stock' => 8, 'category_id' => 1],
        ];
        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
