<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // O método unique() garante que o Faker não repita o nome
        $nome = $this->faker->unique()->sentence(3);

        return [
            'nome' => $nome,
            // Como o nome é único, o slug gerado também será único
            'slug' => \Illuminate\Support\Str::slug($nome),
            'descricao' => $this->faker->paragraph(5),
            'preco' => $this->faker->randomFloat(2, 10, 2000), // Preço entre 10 e 2000
            'imagem' => $this->faker->imageUrl(640, 480, 'products', true),
            // Garante uma categoria existente ou cria uma padrão
            'id_categoria' => \App\Models\Categoria::inRandomOrder()->first()->id ?? \App\Models\Categoria::factory(),
            'quantidade' => $this->faker->numberBetween(1, 100),
        ];
    }
}
