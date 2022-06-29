<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        Produto::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'categoria' => 'Associado',
                'nome' => 'Associado',
                'valor' => 230.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'categoria' => 'Anuidade',
                'nome' => 'Anuidade 2022',
                'valor' => 230.00,
            ]
        );

        //Regional Sul
        Produto::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'categoria' => 'Regional-Sul',
                'nome' => 'Estudantes de Graduação e recém-graduado',
                'valor' => 40.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 4],
            [
                'id'  => 4,
                'categoria' => 'Regional-Sul',
                'nome' => ' Sócio da Intercom',
                'valor' => 0.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 5],
            [
                'id'  => 5,
                'categoria' => 'Regional-Sul',
                'nome' => 'Estudante de Pós-graduação',
                'valor' => 100.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 6],
            [
                'id'  => 6,
                'categoria' => 'Regional-Sul',
                'nome' => 'Professores e pesquisadores',
                'valor' => 220.00,
            ]
        );

        //Regional Nordeste
        Produto::updateOrCreate(
            ['id' => 8],
            [
                'id'  => 8,
                'categoria' => 'Regional-Nordeste',
                'nome' => 'Estudantes de Graduação e recém-graduado',
                'valor' => 40.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 9],
            [
                'id'  => 9,
                'categoria' => 'Regional-Nordeste',
                'nome' => ' Sócio da Intercom',
                'valor' => 0.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 10],
            [
                'id'  => 10,
                'categoria' => 'Regional-Nordeste',
                'nome' => 'Estudante de Pós-graduação',
                'valor' => 100.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 11],
            [
                'id'  => 11,
                'categoria' => 'Regional-Nordeste',
                'nome' => 'Professores e pesquisadores',
                'valor' => 220.00,
            ]
        );

        //Regional Suldeste
        Produto::updateOrCreate(
            ['id' => 13],
            [
                'id'  => 13,
                'categoria' => 'Regional-Suldeste',
                'nome' => 'Estudantes de Graduação e recém-graduado',
                'valor' => 40.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 14],
            [
                'id'  => 14,
                'categoria' => 'Regional-Suldeste',
                'nome' => ' Sócio da Intercom',
                'valor' => 0.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 15],
            [
                'id'  => 15,
                'categoria' => 'Regional-Suldeste',
                'nome' => 'Estudante de Pós-graduação',
                'valor' => 100.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 16],
            [
                'id'  => 16,
                'categoria' => 'Regional-Suldeste',
                'nome' => 'Professores e pesquisadores',
                'valor' => 220.00,
            ]
        );

        //Regional Centro-Oeste

        Produto::updateOrCreate(
            ['id' => 18],
            [
                'id'  => 18,
                'categoria' => 'Regional-Centro-Oeste',
                'nome' => 'Estudantes de Graduação e recém-graduado',
                'valor' => 40.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 19],
            [
                'id'  => 19,
                'categoria' => 'Regional-Centro-Oeste',
                'nome' => ' Sócio da Intercom',
                'valor' => 0.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 20],
            [
                'id'  => 20,
                'categoria' => 'Regional-Centro-Oeste',
                'nome' => 'Estudante de Pós-graduação',
                'valor' => 100.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 21],
            [
                'id'  => 21,
                'categoria' => 'Regional-Centro-Oeste',
                'nome' => 'Professores e pesquisadores',
                'valor' => 220.00,
            ]
        );

        //Regional Norte
        Produto::updateOrCreate(
            ['id' => 23],
            [
                'id'  => 23,
                'categoria' => 'Regional-Norte',
                'nome' => 'Estudantes de Graduação e recém-graduado',
                'valor' => 40.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 24],
            [
                'id'  => 24,
                'categoria' => 'Regional-Norte',
                'nome' => ' Sócio da Intercom',
                'valor' => 0.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 25],
            [
                'id'  => 25,
                'categoria' => 'Regional-Norte',
                'nome' => 'Estudante de Pós-graduação',
                'valor' => 100.00,
            ]
        );

        Produto::updateOrCreate(
            ['id' => 26],
            [
                'id'  => 26,
                'categoria' => 'Regional-Norte',
                'nome' => 'Professores e pesquisadores',
                'valor' => 220.00,
            ]
        );
    }
}
