<?php

namespace Database\Seeders;

use App\Models\Customization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customization::create([
            'nome' => 'logo',
            'imagem' => 'images/customizations/01KF6SAPQQ6Q1YVBNGDT2D9T10.webp',
        ]);
    }
}
