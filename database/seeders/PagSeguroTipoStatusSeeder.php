<?php

namespace Database\Seeders;

use App\Models\PagSeguroTipoStatus;
use Illuminate\Database\Seeder;

class PagSeguroTipoStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PagSeguroTipoStatus::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'nome' => 'Aguardando pagamento',
                'memo' =>  'O comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.'
            ]
        );


        PagSeguroTipoStatus::updateOrCreate(
            ['id'=> 2],
            ['id'=> 2,
                'nome' => 'Em análise',
                'memo' =>  'O comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.'
            ]
        );


        PagSeguroTipoStatus::updateOrCreate(
            ['id'=> 3],
            ['id'=>3,
                'nome' => 'Paga',
                'memo' =>  'A transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.'
            ]
        );


        PagSeguroTipoStatus::updateOrCreate(
            ['id'=> 4],
            ['id'=> 4,
                'nome' => 'Disponível',
                'memo' =>  'A transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.'
            ]
        );


        PagSeguroTipoStatus::updateOrCreate(
            ['id'=> 5],
            ['id'=> 5,
                'nome' => 'Em disputa',
                'memo' =>  'O comprador, dentro do prazo de liberação da transação, abriu uma disputa.'
            ]
        );


        PagSeguroTipoStatus::updateOrCreate(
            ['id'=> 6],
            ['id'=> 6,
                'nome' => 'Devolvida',
                'memo' =>  'O valor da transação foi devolvido para o comprador.'
            ]
        );

        PagSeguroTipoStatus::updateOrCreate(
            ['id'=> 7],
            ['id'=> 7,
                'nome' => 'Cancelada',
                'memo' =>  'A transação foi cancelada sem ter sido finalizada.'
            ]
        );


    }
}
