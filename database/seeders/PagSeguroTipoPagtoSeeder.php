<?php

namespace Database\Seeders;

use App\Models\PagSeguroTipoPagto;
use Illuminate\Database\Seeder;

class PagSeguroTipoPagtoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PagSeguroTipoPagto::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'nome' => 'Cartão de Crédito',
            ]
        );

        PagSeguroTipoPagto::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'nome' => 'Boleto',
            ]
        );

        PagSeguroTipoPagto::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'nome' => 'Cartão de Débito',
            ]
        );
    }
}
