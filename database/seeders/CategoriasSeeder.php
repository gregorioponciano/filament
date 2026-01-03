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
            ['nome' => 'Blusas', 'slug' => 'blusas'],
            ['nome' => 'Bone', 'slug' => 'bone'],
            ['nome' => 'Casacos', 'slug' => 'casacos'],
            ['nome' => 'Shorts', 'slug' => 'shorts'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}