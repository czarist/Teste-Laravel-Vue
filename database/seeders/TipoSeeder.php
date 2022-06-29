<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    public function run()
    {
        Tipo::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'nome' => 'Root',
                'descricao' => 'Administrador Master do sistema',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'nome' => 'Administrador',
                'descricao' => 'Administrador do sistema',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'nome' => 'Associado',
                'descricao' => 'Associado do Sistema',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>4],
            ['id'=>4,
                'nome' => 'Usuário',
                'descricao' => 'Usuário do Sistema',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>5],
            ['id'=>5,
                'nome' => 'Anuidade_2022',
                'descricao' => 'Anuidade 2022',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>6],
            ['id'=>6,
                'nome' => 'Regional_Sul_2022',
                'descricao' => 'Regional Sul 2022',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>7],
            ['id'=>7,
                'nome' => 'Regional_Nordeste_2022',
                'descricao' => 'Regional Nordeste 2022',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>8],
            ['id'=>8,
                'nome' => 'Regional_Suldeste_2022',
                'descricao' => 'Regional Suldeste 2022',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>9],
            ['id'=>9,
                'nome' => 'Regional_Centro_Oeste_2022',
                'descricao' => 'Regional Centro-Oeste 2022',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>10],
            ['id'=>10,
                'nome' => 'Regional_Norte_2022',
                'descricao' => 'Regional Norte 2022',
            ]
        );

        Tipo::updateOrCreate(
            ['id'=>11],
            ['id'=>11,
                'nome' => 'Nacional',
                'descricao' => 'Nacional 2022',
            ]
        );
    }
}
