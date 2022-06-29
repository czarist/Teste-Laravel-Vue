<?php

namespace Database\Seeders;

use App\Models\TipoPagamento;
use Illuminate\Database\Seeder;

class TipoPagamentoSeeder extends Seeder
{
    public function run()
    {
        TipoPagamento::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'nome' => 'sul_pago_2022',
                'descricao' => 'Fez Pagamento do Regional Sul 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>2],
            ['id'=>2,
                'nome' => 'sul_usuario_isento_2022',
                'descricao' => 'Foi Isento do Regional Sul 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>3],
            ['id'=>3,
                'nome' => 'sul_associado_isento_2022',
                'descricao' => 'Associado Isento do Regional Sul 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>4],
            ['id'=>4,
                'nome' => 'nordeste_pago_2022',
                'descricao' => 'Fez Pagamento do Regional Nordeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>5],
            ['id'=>5,
                'nome' => 'nordeste_usuario_isento_2022',
                'descricao' => 'Foi Isento do Regional Nordeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>6],
            ['id'=>6,
                'nome' => 'nordeste_associado_isento_2022',
                'descricao' => 'Associado Isento do Regional Nordeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>7],
            ['id'=>7,
                'nome' => 'sudeste_pago_2022',
                'descricao' => 'Fez Pagamento do Regional Sudeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>8],
            ['id'=>8,
                'nome' => 'sudeste_usuario_isento_2022',
                'descricao' => 'Foi Isento do Regional Sudeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>9],
            ['id'=>9,
                'nome' => 'sudeste_associado_isento_2022',
                'descricao' => 'Associado Isento do Regional Sudeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>10],
            ['id'=>10,
                'nome' => 'centro_oeste_pago_2022',
                'descricao' => 'Fez Pagamento do Regional Centro-Oeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>11],
            ['id'=>11,
                'nome' => 'centro_oeste_usuario_isento_2022',
                'descricao' => 'Foi Isento do Regional Centro-Oeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>12],
            ['id'=>12,
                'nome' => 'centro_oeste_associado_isento_2022',
                'descricao' => 'Associado Isento do Regional Centro-Oeste 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>13],
            ['id'=>13,
                'nome' => 'norte_pago_2022',
                'descricao' => 'Fez Pagamento do Regional Norte 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>14],
            ['id'=>14,
                'nome' => 'norte_usuario_isento_2022',
                'descricao' => 'Foi Isento do Regional Norte 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>15],
            ['id'=>15,
                'nome' => 'norte_associado_isento_2022',
                'descricao' => 'Associado Isento do Regional Norte 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>16],
            ['id'=>16,
                'nome' => 'nacional_pago_2022',
                'descricao' => 'Fez Pagamento do Nacional 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>17],
            ['id'=>17,
                'nome' => 'nacional_usuario_isento_2022',
                'descricao' => 'Foi Isento do Nacional 2022',
            ]
        );

        TipoPagamento::updateOrCreate(
            ['id'=>18],
            ['id'=>18,
                'nome' => 'nacional_associado_2022',
                'descricao' => 'Associado Isento Nacional 2022',
            ]
        );
    }
}
