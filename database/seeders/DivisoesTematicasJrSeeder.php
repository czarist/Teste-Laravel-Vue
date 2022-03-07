<?php

namespace Database\Seeders;

use App\Models\DivisoesTematicasJr;
use Illuminate\Database\Seeder;

class DivisoesTematicasJrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DivisoesTematicasJr::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'dt' => 'IJ01',
                'descricao' => 'Jornalismo',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'dt' => 'IJ02',
                'descricao' => 'Publicidade e Propaganda',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'dt' => 'IJ03',
                'descricao' => 'Relações Públicas e Comunicação Organizacional',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'dt' => 'IJ04',
                'descricao' => 'Comunicação Audiovisual',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'dt' => 'IJ05',
                'descricao' => 'Comunicação Multimídia',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'dt' => 'IJ06',
                'descricao' => 'Interfaces Comunicacionais',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'dt' => 'IJ07',
                'descricao' => 'Comunicação, Espaço e Cidadania',
            ]
        );

        DivisoesTematicasJr::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'dt' => 'IJ08',
                'descricao' => 'Estudos Interdisciplinares da Comunicação',
            ]
        );
    }
}
