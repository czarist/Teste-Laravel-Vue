<?php

namespace Database\Seeders;

use App\Models\CategoriaCinemaAudiovisual;
use Illuminate\Database\Seeder;

class CategoriaCinemaAudiovisualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'descricao' => 'Direção de Fotografia (avulso ou conjunto/série)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'descricao' => 'Filme de animação (avulso)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'descricao' => 'Filme de ficção (avulso)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'descricao' => 'Filme de não ficção/documentário/ docudrama (avulso)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'descricao' => 'Roteiro de ficção (avulso ou conjunto/série)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'descricao' => 'Roteiro de não ficção (avulso ou conjunto/série)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'descricao' => 'TCC – Projeto Experimental em Cinema e Audiovisual',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'descricao' => 'Videoclipe (avulso)',
            ]
        );

        CategoriaCinemaAudiovisual::updateOrCreate(
            ['id' => 9],
            [
                'id' => 9,
                'descricao' => 'Vinheta (avulso)',
            ]
        );
    }
}
