<?php

namespace Database\Seeders;

use App\Models\Titulacao;
use Illuminate\Database\Seeder;

class TitulacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Titulacao::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'titulacao' => 'Mestrando',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'titulacao' => 'PosDoutor',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'titulacao' => 'Doutorando',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>4],
            ['id'=>4,
                'titulacao' => 'Doutor',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>5],
            ['id'=>5,
                'titulacao' => 'Bacharel',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>6],
            ['id'=>6,
                'titulacao' => 'Especialista',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>7],
            ['id'=>7,
                'titulacao' => 'Mestre',
            ]
        );


    }
}
