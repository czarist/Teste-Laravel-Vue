<?php

namespace Database\Seeders;

use App\Models\CategoriaRadioInternet;
use Illuminate\Database\Seeder;

class CategoriaRadioInternetSeeder extends Seeder
{
    public function run()
    {
        CategoriaRadioInternet::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'descricao' => 'Blog (avulso)',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'descricao' => 'Ficção em áudio e rádio - audiodramatização, peça radiofônica, radionovela e afins (avulso ou conjunto/série)',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'descricao' => 'Ficção em vídeo e tele - Telenovela, Séries Televisivas, webséries, ficção para internet e afins (avulso ou conjunto/sér...',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'descricao' => 'Produção Audiovisual para mídias digitais (avulso ou conjunto/série)',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'descricao' => 'Programa laboratorial de áudio (avulso ou conjunto/série)',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'descricao' => 'Programa laboratorial de TV (avulso ou conjunto/série)',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'descricao' => 'TCC/Projeto Experimental em Rádio, TV e Internet',
            ]
        );

        CategoriaRadioInternet::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'descricao' => 'Website (avulso)',
            ]
        );
    }
}
