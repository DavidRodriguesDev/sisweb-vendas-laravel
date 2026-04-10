<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Eletrônicos', 'description' => 'Produtos eletrônicos em geral'],
            ['name' => 'Informática', 'description' => 'Computadores e acessórios'],
            ['name' => 'Casa e Jardim', 'description' => 'Produtos para casa e jardim'],
            ['name' => 'Esportes', 'description' => 'Artigos esportivos'],
            ['name' => 'Roupas', 'description' => 'Vestuário em geral'],
            ['name' => 'Alimentos', 'description' => 'Produtos alimentícios'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}