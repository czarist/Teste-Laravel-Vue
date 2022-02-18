<?php

namespace Database\Seeders;

use App\Models\Acesso;
use Illuminate\Database\Seeder;

class AcessoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acesso::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'pagina' => 'Tipo Sexo',
                'link' => 'config/sexo'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'pagina' => 'Sales',
                'link' => 'sales'
            ]
        );

    }
}
