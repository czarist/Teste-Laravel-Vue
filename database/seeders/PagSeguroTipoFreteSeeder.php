<?php

namespace Database\Seeders;

use App\Models\PagSeguroTipoFrete;
use Illuminate\Database\Seeder;
use PDO;

class PagSeguroTipoFreteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PagSeguroTipoFrete::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'nome' => 'Encomenda normal (PAC)',
            ]
        );

        PagSeguroTipoFrete::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'nome' => 'SEDEX',
            ]
        );

        PagSeguroTipoFrete::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'nome' => 'Tipo de frete não especificado',
            ]
        );

    }
}
