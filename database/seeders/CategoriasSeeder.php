<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nome' => 'Camisetas', 'slug' => 'camisetas'],
            ['nome' => 'Calças', 'slug' => 'calcas'],
            ['nome' => 'Vestidos', 'slug' => 'vestidos'],
            ['nome' => 'Casacos', 'slug' => 'casacos'],
            ['nome' => 'Shorts', 'slug' => 'shorts'],
            ['nome' => 'Blusas', 'slug' => 'blusas'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}