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
                'nome' => 'Associado',
                'valor' => 0.20,
            ]
        );
    }
}
