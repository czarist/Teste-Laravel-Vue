<?php

namespace Database\Seeders;

use App\Models\Titulacao;
use Illuminate\Database\Seeder;

class TitulacaoSeeder extends Seeder
{
    public function run()
    {
        Titulacao::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'titulacao' => 'Estudante de Graduação',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'titulacao' => 'Bacharel',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'titulacao' => 'Livre Docente',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>4],
            ['id'=>4,
                'titulacao' => 'Mestrando',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>5],
            ['id'=>5,
                'titulacao' => 'Doutorando',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>6],
            ['id'=>6,
                'titulacao' => 'Mestre',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>7],
            ['id'=>7,
                'titulacao' => 'Doutor',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>8],
            ['id'=>8,
                'titulacao' => 'Cursando Especialização',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>9],
            ['id'=>9,
                'titulacao' => 'Especialista',
            ]
        );

        Titulacao::updateOrCreate(
            ['id'=>10],
            ['id'=>10,
                'titulacao' => 'Licenciado',
            ]
        );
    }
}
