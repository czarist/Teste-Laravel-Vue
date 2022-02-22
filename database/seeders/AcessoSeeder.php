<?php

namespace Database\Seeders;

use App\Models\Acesso;
use Illuminate\Database\Seeder;

class AcessoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acesso::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'pagina' => 'Tipo Sexo',
                'link' => 'config/sexo'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'pagina' => 'Categoria',
                'link' => 'config/categoria'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'pagina' => 'Usuário',
                'link' => 'config/usuario'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 4],
            [
                'id'  => 4,
                'pagina' => 'Instituição',
                'link' => 'config/instituicao'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 5],
            [
                'id'  => 5,
                'pagina' => 'Titulação',
                'link' => 'config/titulacao'
            ]
        );

    }
}
