<?php

namespace Database\Seeders;

use App\Models\DivisoesTematicas;
use Illuminate\Database\Seeder;

class DivisoesTematicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DivisoesTematicas::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'dt' => 'DT01',
                'descricao' => 'Jornalismo',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'dt' => 'DT02',
                'descricao' => 'Publicidade e Propaganda',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'dt' => 'DT03',
                'descricao' => 'Relações Públicas e Comunicação Organizacional',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'dt' => 'DT04',
                'descricao' => 'Comunicação Audiovisual',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'dt' => 'DT05',
                'descricao' => 'Comunicação Multimídia',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'dt' => 'DT06',
                'descricao' => 'Interfaces Comunicacionais',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'dt' => 'DT07',
                'descricao' => 'Comunicação, Espaço e Cidadania',
            ]
        );

        DivisoesTematicas::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'dt' => 'DT08',
                'descricao' => 'Estudos Interdisciplinares da Comunicação',
            ]
        );
    }
}
