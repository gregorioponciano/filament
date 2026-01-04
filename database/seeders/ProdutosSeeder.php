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
        // Categorias existentes (SEM mudar lógica)
        $camisetas = Categoria::where('slug', 'camisetas')->first();
        $blusas    = Categoria::where('slug', 'blusas')->first();
        $bone      = Categoria::where('slug', 'bone')->first();
        $casacos   = Categoria::where('slug', 'casacos')->first();
        $shorts    = Categoria::where('slug', 'shorts')->first();

        if (!$camisetas || !$blusas || !$bone || !$casacos || !$shorts) {
            $this->call(CategoriasSeeder::class);

            $camisetas = Categoria::where('slug', 'camisetas')->first();
            $blusas    = Categoria::where('slug', 'blusas')->first();
            $bone      = Categoria::where('slug', 'bone')->first();
            $casacos   = Categoria::where('slug', 'casacos')->first();
            $shorts    = Categoria::where('slug', 'shorts')->first();
        }

        $produtos = [

            /* ================= CAMISETAS ================= */
            [
                'nome' => 'Camiseta Básica Preta Essential',
                'descricao' => 'Camiseta de algodão 100%, confortável e durável.',
                'preco' => 49.90,
                'imagem' => 'image/camisa/camisa1.webp',
                'estoque' => 50,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Branca Minimal',
                'descricao' => 'Visual clean para qualquer ocasião.',
                'preco' => 54.90,
                'imagem' => 'image/camisa/camisa2.webp',
                'estoque' => 40,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Oversized Street',
                'descricao' => 'Modelagem oversized moderna.',
                'preco' => 69.90,
                'imagem' => 'image/camisa/camisa3.webp',
                'estoque' => 35,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Preta Slim Fit',
                'descricao' => 'Caimento ajustado e tecido respirável.',
                'preco' => 55.90,
                'imagem' => 'image/camisa/camisa4.webp',
                'estoque' => 45,
                'categoria_id' => $camisetas->id,
            ],

            /* ================= BLUSAS ================= */
            [
                'nome' => 'Blusa de Moletom Premium',
                'descricao' => 'Moletom flanelado de alta qualidade.',
                'preco' => 199.90,
                'imagem' => 'image/blusa/blusa1.webp',
                'estoque' => 25,
                'categoria_id' => $blusas->id,
            ],
            [
                'nome' => 'Blusa Canguru Street',
                'descricao' => 'Blusa com capuz e bolso frontal.',
                'preco' => 179.90,
                'imagem' => 'image/blusa/blusa2.webp',
                'estoque' => 30,
                'categoria_id' => $blusas->id,
            ],

            /* ================= BONÉS ================= */
            [
                'nome' => 'Boné Snapback Preto',
                'descricao' => 'Boné ajustável com design urbano.',
                'preco' => 79.90,
                'imagem' => 'image/bone/bone1.webp',
                'estoque' => 35,
                'categoria_id' => $bone->id,
            ],
            [
                'nome' => 'Boné Dad Hat Bege',
                'descricao' => 'Estilo casual com aba curva.',
                'preco' => 69.90,
                'imagem' => 'image/bone/bone2.webp',
                'estoque' => 40,
                'categoria_id' => $bone->id,
            ],

            /* ================= CASACOS ================= */
            [
                'nome' => 'Casaco Jeans Slim',
                'descricao' => 'Casaco jeans com lavagem premium.',
                'preco' => 249.90,
                'imagem' => 'image/casaco/casaco1.webp',
                'estoque' => 20,
                'categoria_id' => $casacos->id,
            ],
            [
                'nome' => 'Casaco Puffer Inverno',
                'descricao' => 'Casaco térmico ideal para dias frios.',
                'preco' => 329.90,
                'imagem' => 'image/casaco/casaco2.webp',
                'estoque' => 15,
                'categoria_id' => $casacos->id,
            ],

            /* ================= SHORTS ================= */
            [
                'nome' => 'Shorts Moletom Confort',
                'descricao' => 'Shorts confortável para o dia a dia.',
                'preco' => 89.90,
                'imagem' => 'image/shorts/short1.webp',
                'estoque' => 45,
                'categoria_id' => $shorts->id,
            ],
            [
                'nome' => 'Shorts Jeans Destroyed',
                'descricao' => 'Visual moderno com lavagem estonada.',
                'preco' => 119.90,
                'imagem' => 'image/shorts/short2.webp',
                'estoque' => 30,
                'categoria_id' => $shorts->id,
            ],
        ];

        foreach ($produtos as $produto) {
            $produto['slug'] = Str::slug($produto['nome']);
            Produto::create($produto);
        }
    }
}
