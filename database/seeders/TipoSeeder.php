<?php

namespace Database\Seeders;

use App\Models\Tipo;
use App\Models\TipoPagamento;
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

        TipoPagamento::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'nome' => 'sul_pago_2022',
                'descricao' => 'Fez Pagamento do Regional Sul 2022',
            ]
        );

    }
}
