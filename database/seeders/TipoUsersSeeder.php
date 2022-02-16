<?php

namespace Database\Seeders;

use App\Models\TipoUsers;
use Illuminate\Database\Seeder;

class TipoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoUsers::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'nome' => 'Root',
                'descricao' => 'Administrador Master do sistema',
            ]
        );

        TipoUsers::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'nome' => 'Administrador',
                'descricao' => 'Administrador do sistema',
            ]
        );

        TipoUsers::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'nome' => 'Associado',
                'descricao' => 'Associado do Sistema',
            ]
        );

        TipoUsers::updateOrCreate(
            ['id'=>4],
            ['id'=>4,
                'nome' => 'Usuário',
                'descricao' => 'Usuário do Sistema',
            ]
        );

    }
}
