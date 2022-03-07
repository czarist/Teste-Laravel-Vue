<?php

namespace Database\Seeders;

use App\Models\CategoriaJornalismo;
use Illuminate\Database\Seeder;

class CategoriaJornalismoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 1],
            [
                'id' => 1,
                'descricao' => 'Agência Escola/Júnior de Jornalismo (conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 2],
            [
                'id' => 2,
                'descricao' => 'Documentário Jornalístico e Grande Reportagem em áudio e rádio',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 3],
            [
                'id' => 3,
                'descricao' => 'Documentário Jornalístico e Grande Reportagem em vídeo e televisão',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 4],
            [
                'id' => 4,
                'descricao' => 'JO04 - Revista-laboratório impressa (conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 5],
            [
                'id' => 5,
                'descricao' => 'Jornal-laboratório (avulso ou conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 6],
            [
                'id' => 6,
                'descricao' => 'Livro-reportagem (avulso)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 7],
            [
                'id' => 7,
                'descricao' => 'Produção em Fotojornalismo (avulso ou conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 8],
            [
                'id' => 8,
                'descricao' => 'Produção em Jornalismo digital (avulso ou conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 9],
            [
                'id' => 9,
                'descricao' => 'Produção Jornalismo Literário e/ou de Opinião (avulso ou conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 10],
            [
                'id' => 10,
                'descricao' => 'Produção laboratorial em audiojornalismo e radiojornalismo (avulso ou conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 11],
            [
                'id' => 11,
                'descricao' => 'Produção laboratorial em vídeojornalismo e televisão (avulso ou conjunto/série)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 12],
            [
                'id' => 12,
                'descricao' => 'Projeto de assessoria de Imprensa (avulso)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 13],
            [
                'id' => 13,
                'descricao' => 'Reportagem em Jornalismo impresso (avulso)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 14],
            [
                'id' => 14,
                'descricao' => 'Reportagem em Radiojornalismo (avulso)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 15],
            [
                'id' => 15,
                'descricao' => 'Reportagem em Telejornalismo (avulso)',
            ]
        );

        CategoriaJornalismo::updateOrCreate(
            [ 'id' => 16],
            [
                'id' => 16,
                'descricao' => 'TCC – Projeto Experimental em Jornalismo',
            ]
        );
    }
}
