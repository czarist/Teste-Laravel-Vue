<?php

namespace Database\Seeders;

use App\Models\TipoIsencao;
use Illuminate\Database\Seeder;

class TipoIsencaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoIsencao::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'nome' => 'palestrante_nao_associado',
                'descricao' => 'Palestrante Não Associado',
            ]
        );

        TipoIsencao::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'nome' => 'palestrante_associado',
                'descricao' => 'Palestrante Associado Intercom',
            ]
        );

        TipoIsencao::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'nome' => 'convidado_nao_associado',
                'descricao' => 'Convidado Não Associado',
            ]
        );

        TipoIsencao::updateOrCreate(
            ['id'=>4],
            ['id'=>4,
                'nome' => 'convidado_associado',
                'descricao' => 'Convidado Associado Intercom',
            ]
        );
    }
}
