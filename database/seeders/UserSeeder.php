<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@vendas.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles(['admin']);

        $vendedor = User::firstOrCreate(
            ['email' => 'vendedor@vendas.com'],
            [
                'name' => 'Vendedor',
                'password' => Hash::make('password'),
            ]
        );
        $vendedor->syncRoles(['vendedor']);
    }
}
