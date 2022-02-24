<?php

namespace Database\Seeders;

use App\Models\PagSeguroTipoPagtoDetalhe;
use Illuminate\Database\Seeder;

class PagSeguroTipoPagtoDetalheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'codigo' => 101,
                'nome' => 'Cartão de crédito Visa',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 2],
            ['id'=> 2,
                'codigo' => 102,
                'nome' => 'Cartão de crédito MasterCard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 3],
            ['id'=> 3,
                'codigo' => 103,
                'nome' => 'Cartão de crédito American Express',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 4],
            ['id'=> 4,
                'codigo' => 104,
                'nome' => 'Cartão de crédito Diners',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 5],
            ['id'=> 5,
                'codigo' => 105,
                'nome' => 'Cartão de crédito Hipercard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 6],
            ['id'=> 6,
                'codigo' => 106,
                'nome' => 'Cartão de crédito Aura',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 7],
            ['id'=> 7,
                'codigo' => 107,
                'nome' => 'Cartão de crédito Elo',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 8],
            ['id'=> 8,
                'codigo' => 108,
                'nome' => 'Cartão de crédito PLENOCard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 9],
            ['id'=> 9,
                'codigo' => 109,
                'nome' => 'Cartão de crédito PersonalCard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 10],
            ['id'=> 10,
                'codigo' => 110,
                'nome' => 'Cartão de crédito JCB',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 11],
            ['id'=> 11,
                'codigo' => 111,
                'nome' => 'Cartão de crédito Discover',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 12],
            ['id'=> 12,
                'codigo' => 112,
                'nome' => 'Cartão de crédito BrasilCard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 13],
            ['id'=> 13,
                'codigo' => 113,
                'nome' => 'Cartão de crédito FORTBRASIL',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 14],
            ['id'=> 14,
                'codigo' => 114,
                'nome' => 'Cartão de crédito CARDBAN',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 15],
            ['id'=> 15,
                'codigo' => 115,
                'nome' => 'Cartão de crédito VALECARD',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 16],
            ['id'=> 16,
                'codigo' => 116,
                'nome' => 'Cartão de crédito Cabal',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 17],
            ['id'=> 17,
                'codigo' => 117,
                'nome' => 'Cartão de crédito Mais!',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 18],
            ['id'=> 18,
                'codigo' => 118,
                'nome' => 'Cartão de crédito Avista',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 19],
            ['id'=> 19,
                'codigo' => 119,
                'nome' => 'Cartão de crédito GRANDCARD',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 20],
            ['id'=> 20,
                'codigo' => 120,
                'nome' => 'Cartão de crédito Sorocred',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 21],
            ['id'=> 21,
                'codigo' => 122,
                'nome' => 'Cartão de crédito Up Policard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 22],
            ['id'=> 22,
                'codigo' => 123,
                'nome' => 'Cartão de crédito BaneseCard',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 23],
            ['id'=> 23,
                'codigo' => 201,
                'nome' => 'Boleto Bradesco',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 24],
            ['id'=> 24,
                'codigo' => 202,
                'nome' => 'Boleto Santander',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 25],
            ['id'=> 25,
                'codigo' => 301,
                'nome' => 'Débito online Bradesco',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 26],
            ['id'=> 26,
                'codigo' => 302,
                'nome' => 'Débito online Itaú',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 27],
            ['id'=> 27,
                'codigo' => 303,
                'nome' => 'Débito online Unibanco',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 28],
            ['id'=> 28,
                'codigo' => 304,
                'nome' => 'Débito online Banco do Brasil',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 29],
            ['id'=> 29,
                'codigo' => 305,
                'nome' => 'Débito online Banco Real',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 30],
            ['id'=> 30,
                'codigo' => 306,
                'nome' => 'Débito online Banrisul',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 31],
            ['id'=> 31,
                'codigo' => 307,
                'nome' => 'Débito online HSBC',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 31],
            ['id'=> 31,
                'codigo' => 401,
                'nome' => 'Saldo PagSeguro',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 32],
            ['id'=> 32,
                'codigo' => 501,
                'nome' => 'Oi Paggo',
            ]
        );

        PagSeguroTipoPagtoDetalhe::updateOrCreate(
            ['id'=> 33],
            ['id'=> 33,
                'codigo' => 701,
                'nome' => 'Depósito em conta - Banco do Brasil',
            ]
        );

    }
}
