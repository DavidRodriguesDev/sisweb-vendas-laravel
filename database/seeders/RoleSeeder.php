<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'vendedor', 'cliente'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $permissions = [
            'view dashboard',
            'manage users',
            'manage categories',
            'manage products',
            'manage customers',
            'manage sales',
            'manage payments',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

        $vendedorRole = Role::where('name', 'vendedor')->first();
        $vendedorRole->givePermissionTo([
            'view dashboard',
            'manage categories',
            'manage products',
            'manage customers',
            'manage sales',
            'manage payments',
            'view reports',
        ]);

        $clienteRole = Role::where('name', 'cliente')->first();
        $clienteRole->givePermissionTo([
            'view dashboard',
        ]);
    }
}