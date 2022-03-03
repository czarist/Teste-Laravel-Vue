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
                'valor' => 1.25,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'nome' => 'Anuidade 2022',
                'valor' => 1.35,
            ]
        );

    }
}
