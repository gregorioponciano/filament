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
        $calcas = Categoria::where('slug', 'calcas')->first();
        $vestidos = Categoria::where('slug', 'vestidos')->first();

        // Se não existirem categorias, execute o seeder
        if (!$camisetas || !$calcas || !$vestidos) {
            $this->call(CategoriasSeeder::class);
            $camisetas = Categoria::where('slug', 'camisetas')->first();
            $calcas = Categoria::where('slug', 'calcas')->first();
            $vestidos = Categoria::where('slug', 'vestidos')->first();
        }

        $produtos = [
            [
                'nome' => 'Camiseta Básica Preta',
                'descricao' => 'Camiseta de algodão 100%, confortável e durável',
                'slug' => 'camiseta-basica-preta',
                'preco' => 49.90,
                'imagem' => 'camiseta-preta.jpg',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Branca Listrada',
                'descricao' => 'Camiseta com listras finas, ideal para o dia a dia',
                'slug' => 'camiseta-branca-listrada',
                'preco' => 59.90,
                'imagem' => 'camiseta-listrada.jpg',
                'estoque' => 30,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Jeans Skinny Azul',
                'descricao' => 'Calça jeans modelo skinny, cor azul claro',
                'slug' => 'jeans-skinny-azul',
                'preco' => 129.90,
                'imagem' => 'jeans-azul.jpg',
                'estoque' => 25,
                'categoria_id' => $calcas->id,
            ],
            [
                'nome' => 'Vestido Floral Midi',
                'descricao' => 'Vestido floral com comprimento midi, tecido leve',
                'slug' => 'vestido-floral-midi',
                'preco' => 159.90,
                'imagem' => 'vestido-floral.jpg',
                'estoque' => 15,
                'categoria_id' => $vestidos->id,
            ],
            [
                'nome' => 'Calça de Moletom',
                'descricao' => 'Calça de moletom confortável, ideal para casa',
                'slug' => 'calca-moletom',
                'preco' => 89.90,
                'imagem' => 'calca-moletom.jpg',
                'estoque' => 40,
                'categoria_id' => $calcas->id,
            ],
            [
                'nome' => 'Camiseta Oversized Cinza',
                'descricao' => 'Camiseta oversized em tecido de algodão, cor cinza',
                'slug' => 'camiseta-oversized-cinza',
                'preco' => 69.90,
                'imagem' => 'camiseta-cinza.jpg',
                'estoque' => 35,
                'categoria_id' => $camisetas->id,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}