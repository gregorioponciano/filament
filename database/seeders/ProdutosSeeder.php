<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutosSeeder extends Seeder
{
    public function run()
    {
        // Primeiro, garanta que as categorias existam
        $camisetas = Categoria::where('slug', 'camisetas')->first();
        $blusas = Categoria::where('slug', 'blusas')->first();
        $bone = Categoria::where('slug', 'bone')->first();

        // Se não existirem categorias, execute o seeder
        if (!$camisetas || !$blusas || !$bone) {
            $this->call(CategoriasSeeder::class);
            $camisetas = Categoria::where('slug', 'camisetas')->first();
            $blusas = Categoria::where('slug', 'blusas')->first();
            $bone = Categoria::where('slug', 'bone')->first();
        }

        $produtos = [
            [
                'nome' => 'Camiseta Básica Preta',
                'descricao' => 'Camiseta de algodão 100%, confortável e durável',
                'slug' => 'slug',
                'preco' => 49.90,
                'imagem' => 'image/camisa/camisa1.webp',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Branca Listrada',
                'descricao' => 'Camiseta com listras finas, ideal para o dia a dia',
                'slug' => 'slug',
                'preco' => 59.90,
                'imagem' => 'image/camisa/camisa2.webp',
                'estoque' => 30,
                'categoria_id' => $camisetas->id,
            ],
                        [
                'nome' => 'Camiseta Oversized Cinza',
                'descricao' => 'Camiseta oversized em tecido de algodão, cor cinza',
                'slug' => 'image/camisa/camisa3.webp',
                'preco' => 69.90,
                'imagem' => 'image/camisa/camisa3.webp',
                'estoque' => 35,
                'categoria_id' => $camisetas->id,
            ],
             [
                'nome' => 'Camiseta Básica Preta',
                'descricao' => 'Camiseta de algodão 100%, confortável e durável',
                'slug' => 'slug',
                'preco' => 49.90,
                'imagem' => 'image/camisa/camisa1.webp',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Branca Listrada',
                'descricao' => 'Camiseta com listras finas, ideal para o dia a dia',
                'slug' => 'slug',
                'preco' => 59.90,
                'imagem' => 'image/camisa/camisa2.webp',
                'estoque' => 30,
                'categoria_id' => $camisetas->id,
            ],
                        [
                'nome' => 'Camiseta Oversized Cinza',
                'descricao' => 'Camiseta oversized em tecido de algodão, cor cinza',
                'slug' => 'image/camisa/camisa3.webp',
                'preco' => 69.90,
                'imagem' => 'image/camisa/camisa3.webp',
                'estoque' => 35,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'BLUSA DE MOLETOM EXCLUSIVA CODIGO 43',
                'descricao' => 'Calça jeans modelo skinny, cor azul claro',
                'slug' => 'slug',
                'preco' => 250.00,
                'imagem' => 'image/blusa/blusa1.webp',
                'estoque' => 25,
                'categoria_id' => $blusas->id,
            ],
            [
                'nome' => 'Vestido Floral Midi',
                'descricao' => 'Vestido floral com comprimento midi, tecido leve',
                'slug' => 'vestido-floral-midi',
                'preco' => 159.90,
                'imagem' => 'vestido-floral.jpg',
                'estoque' => 15,
                'categoria_id' => $bone->id,
            ],
            [
                'nome' => 'Calça de Moletom',
                'descricao' => 'Calça de moletom confortável, ideal para casa',
                'slug' => 'calca-moletom',
                'preco' => 89.90,
                'imagem' => 'calca-moletom.jpg',
                'estoque' => 40,
                'categoria_id' => $blusas->id,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}