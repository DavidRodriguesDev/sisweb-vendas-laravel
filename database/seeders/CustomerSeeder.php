<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'João Silva', 'email' => 'joao@email.com', 'phone' => '(11) 99999-1111', 'document' => '123.456.789-00', 'address' => 'Rua A, 123 - São Paulo/SP'],
            ['name' => 'Maria Santos', 'email' => 'maria@email.com', 'phone' => '(11) 99999-2222', 'document' => '987.654.321-00', 'address' => 'Av B, 456 - São Paulo/SP'],
            ['name' => 'Pedro Oliveira', 'email' => 'pedro@email.com', 'phone' => '(21) 99999-3333', 'document' => '456.789.123-00', 'address' => 'Rua C, 789 - Rio de Janeiro/RJ'],
            ['name' => 'Ana Costa', 'email' => 'ana@email.com', 'phone' => '(31) 99999-4444', 'document' => '321.654.987-00', 'address' => 'Rua D, 321 - Belo Horizonte/MG'],
            ['name' => 'Empresa XYZ Ltda', 'email' => 'contato@xyz.com.br', 'phone' => '(11) 3333-5555', 'document' => '12.345.678/0001-90', 'address' => 'Av F, 1000 - São Paulo/SP'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}