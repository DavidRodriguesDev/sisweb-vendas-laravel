<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@vendas.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $vendedor = User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@vendas.com',
            'password' => Hash::make('password'),
        ]);
        $vendedor->assignRole('vendedor');
    }
}