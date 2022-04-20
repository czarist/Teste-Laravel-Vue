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
                'link' => 'admin/sexo'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'pagina' => 'Associados',
                'link' => 'admin/associado'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'pagina' => 'Usuários',
                'link' => 'admin/usuarios'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 4],
            [
                'id'  => 4,
                'pagina' => 'Instituição',
                'link' => 'admin/instituicao'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 5],
            [
                'id'  => 5,
                'pagina' => 'Titulação',
                'link' => 'admin/titulacao'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 6],
            [
                'id'  => 6,
                'pagina' => 'Coordenador',
                'link' => 'admin/coordenador'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 7],
            [
                'id'  => 7,
                'pagina' => 'Pagamentos',
                'link' => 'admin/pagamento'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 8],
            [
                'id'  => 8,
                'pagina' => 'Indicação Expocom',
                'link' => 'admin/indicacao'
            ]
        );
    }
}
