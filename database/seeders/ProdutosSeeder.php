<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdutosSeeder extends Seeder
{
    public function run()
    {
        // Categorias existentes (SEM mudar lógica)
        $camisetas = Categoria::where('slug', 'camisetas')->first();
        $user  = User::first();

        if (!$user) {
            $this->call(UserSeeder::class);
            $user = User::first();
        }

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
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 50,
                'user_id' => $user->id,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Branca Minimal',
                'descricao' => 'Visual clean para qualquer ocasião.',
                'preco' => 54.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 40,
                'user_id' => $user->id,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Oversized Street',
                'descricao' => 'Modelagem oversized moderna.',
                'preco' => 69.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 35,
                'user_id' => $user->id,
                'categoria_id' => $camisetas->id,
            ],
            [
                'nome' => 'Camiseta Preta Slim Fit',
                'descricao' => 'Caimento ajustado e tecido respirável.',
                'preco' => 55.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 45,
                'user_id' => $user->id,
                'categoria_id' => $camisetas->id,
            ],

            /* ================= BLUSAS ================= */
            [
                'nome' => 'Blusa de Moletom Premium',
                'descricao' => 'Moletom flanelado de alta qualidade.',
                'preco' => 199.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 25,
                'user_id' => $user->id,
                'categoria_id' => $blusas->id,
            ],
            [
                'nome' => 'Blusa Canguru Street',
                'descricao' => 'Blusa com capuz e bolso frontal.',
                'preco' => 179.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 30,
                'user_id' => $user->id,
                'categoria_id' => $blusas->id,
            ],

            /* ================= BONÉS ================= */
            [
                'nome' => 'Boné Snapback Preto',
                'descricao' => 'Boné ajustável com design urbano.',
                'preco' => 79.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 35,
                'user_id' => $user->id,
                'categoria_id' => $bone->id,
            ],
            [
                'nome' => 'Boné Dad Hat Bege',
                'descricao' => 'Estilo casual com aba curva.',
                'preco' => 69.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 40,
                'user_id' => $user->id,
                'categoria_id' => $bone->id,
            ],

            /* ================= CASACOS ================= */
            [
                'nome' => 'Casaco Jeans Slim',
                'descricao' => 'Casaco jeans com lavagem premium.',
                'preco' => 249.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 20,
                'user_id' => $user->id,
                'categoria_id' => $casacos->id,
            ],
            [
                'nome' => 'Casaco Puffer Inverno',
                'descricao' => 'Casaco térmico ideal para dias frios.',
                'preco' => 329.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 15,
                'user_id' => $user->id,
                'categoria_id' => $casacos->id,
            ],

            /* ================= SHORTS ================= */
            [
                'nome' => 'Shorts Moletom Confort',
                'descricao' => 'Shorts confortável para o dia a dia.',
                'preco' => 89.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 45,
                'user_id' => $user->id,
                'categoria_id' => $shorts->id,
            ],
            [
                'nome' => 'Shorts Jeans Destroyed',
                'descricao' => 'Visual moderno com lavagem estonada.',
                'preco' => 119.90,
                'imagem' => 'images/produtos/01KF6RQD57QQN5HTA6FNGERCFT.png',
                'estoque' => 30,
                'user_id' => $user->id,
                'categoria_id' => $shorts->id,
            ],
        ];

        foreach ($produtos as $produto) {
            $produto['slug'] = Str::slug($produto['nome']);
            Produto::create($produto);
        }
    }
}
