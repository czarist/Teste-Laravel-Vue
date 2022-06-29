<?php

namespace Database\Seeders;

use App\Models\CategoriaRelacoesPublicas;
use Illuminate\Database\Seeder;

class CategoriaRelacoesPublicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'descricao' => 'Agência Escola/Júnior de Relações Públicas (conjunto/série)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'descricao' => 'Organização de evento (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'descricao' => 'Pesquisa em Relações Públicas (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'descricao' => 'Planejamento estratégico de Relações Públicas (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'descricao' => 'Produto de comunicação institucional audiovisual (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'descricao' => 'Produto de comunicação institucional digital (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'descricao' => 'Produto de comunicação institucional impresso (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'descricao' => 'Produto de comunicação institucional radiofônico (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 9],
            [
                'id' => 9,
                'descricao' => 'Projeto de assessoria de comunicação (avulso)',
            ]
        );

        CategoriaRelacoesPublicas::updateOrCreate(
            ['id' => 10],
            [
                'id' => 10,
                'descricao' => 'TCC/Projeto Experimental em Relações Públicas e/ou Comunicação Organizacional',
            ]
        );
    }
}
