<?php

namespace Database\Seeders;

use App\Models\Sexo;
use Illuminate\Database\Seeder;

class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sexo::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'tipo_sexo' => 'Masculino',
            ]
        );

        Sexo::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'tipo_sexo' => 'Feminino',
            ]
        );

        Sexo::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'tipo_sexo' => 'Não Informar',
            ]
        );
    }
}
