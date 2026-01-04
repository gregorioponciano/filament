<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'nome' => 'Camiseta Básica Preta Essential',
                'descricao' => 'Camiseta de algodão 100%, corte moderno, confortável e durável para o dia a dia.',
                'preco' => 49.90,
                'imagem' => 'image/camisa/camisa1.webp',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Branca Listrada Navy',
                'descricao' => 'Camiseta com listras finas estilo náutico, ideal para compor looks casuais.',
                'preco' => 59.90,
                'imagem' => 'image/camisa/camisa2.webp',
                'estoque' => 30,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Oversized Cinza Street',
                'descricao' => 'Modelagem oversized ampla em tecido de algodão premium, cor cinza chumbo.',
                'preco' => 69.90,
                'imagem' => 'image/camisa/camisa3.webp',
                'estoque' => 35,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Preta Gola V',
                'descricao' => 'Camiseta preta clássica com gola V, tecido leve e respirável.',
                'preco' => 54.90,
                'imagem' => 'image/camisa/camisa4.webp',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Listrada Urban',
                'descricao' => 'Estilo urbano com listras marcantes, perfeita para combinações com jeans.',
                'preco' => 64.90,
                'imagem' => 'image/camisa/camisa5.webp',
                'estoque' => 30,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Cinza Mescla Sport',
                'descricao' => 'Tecido mescla confortável, ideal para atividades físicas ou lazer.',
                'preco' => 59.90,
                'imagem' => 'image/camisa/camisa6.webp',
                'estoque' => 35,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Preta Slim Fit',
                'descricao' => 'Modelagem mais ajustada ao corpo, realçando a silhueta.',
                'preco' => 55.90,
                'imagem' => 'image/camisa/camisa7.webp',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'BLUSA DE MOLETOM EXCLUSIVA CODIGO 43',
                'descricao' => 'Moletom de alta qualidade com estampa exclusiva e forro térmico.',
                'preco' => 250.00,
                'imagem' => 'image/blusa/blusa1.webp',
                'estoque' => 25,
                'categoria_id' => $blusas->id,
            ],
            [
                'nome' => 'Vestido Floral Midi',
                'descricao' => 'Vestido floral com comprimento midi, tecido leve e caimento fluido.',
                'preco' => 159.90,
                'imagem' => 'vestido-floral.jpg',
                'estoque' => 15,
                'categoria_id' => $bone->id,
            ],
            [
                'nome' => 'Calça de Moletom Confort',
                'descricao' => 'Calça de moletom confortável com elástico na cintura, ideal para casa.',
                'preco' => 89.90,
                'imagem' => 'calca-moletom.jpg',
                'estoque' => 40,
                'categoria_id' => $blusas->id,
            ],
        ];

        foreach ($produtos as $produto) {
            // Gera o slug automaticamente baseado no nome único
            $produto['slug'] = Str::slug($produto['nome']);
            Produto::create($produto);
        }
    }
}