<?php

namespace Database\Seeders;

use App\Models\ProdutosRegionais;
use Illuminate\Database\Seeder;

class ProdutosRegionaisSeeder extends Seeder
{
    public function run()
    {
        ProdutosRegionais::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'nome' => 'Estudantes de Graduação e recém-graduado',
                'valor' => 1.25,
            ]
        );

        ProdutosRegionais::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'nome' => ' Sócio da Intercom',
                'valor' => 0.00,
            ]
        );

        ProdutosRegionais::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'nome' => 'Estudante de Pós-graduação',
                'valor' => 1.25,
            ]
        );

        ProdutosRegionais::updateOrCreate(
            ['id' => 4],
            [
                'id'  => 4,
                'nome' => 'Professores e pesquisadores',
                'valor' => 1.25,
            ]
        );

        ProdutosRegionais::updateOrCreate(
            ['id' => 5],
            [
                'id'  => 5,
                'nome' => 'Demais profissionais',
                'valor' => 1.25,
            ]
        );
    }
}
