<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        Produto::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'categoria' => 'Produto Teste',
                'nome' => 'Produto Teste',
                'valor' => 100.00,
            ]
        );
    }
}
