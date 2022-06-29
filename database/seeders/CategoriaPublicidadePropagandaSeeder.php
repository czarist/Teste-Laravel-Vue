<?php

namespace Database\Seeders;

use App\Models\CategoriaPublicidadePropaganda;
use Illuminate\Database\Seeder;

class CategoriaPublicidadePropagandaSeeder extends Seeder
{
    public function run()
    {
        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'descricao' => 'Agência Escola/Júnior de Publicidade e Propaganda (conjunto/série)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'descricao' => 'Anúncio impresso (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'descricao' => 'Campanha Publicitária (conjunto/série)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'descricao' => 'Cartaz (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'descricao' => 'Estratégia Publicitária para Mídia Digital (avulso ou conjunto/série)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'descricao' => 'Fotografia Publicitária (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'descricao' => 'Jingle (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'descricao' => 'Outdoor (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 9],
            [
                'id' => 9,
                'descricao' => 'Pesquisa mercadológica (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 10],
            [
                'id' => 10,
                'descricao' => 'Planejamento Promocional (conjunto/série)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 11],
            [
                'id' => 11,
                'descricao' => 'Produção Publiciária Audiovisual para Internet (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 12],
            [
                'id' => 12,
                'descricao' => 'Produção Publicitária Audiovisual Para TV e Cinema (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 13],
            [
                'id' => 13,
                'descricao' => 'Publicidade em Mídia Alternativa (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 14],
            [
                'id' => 14,
                'descricao' => 'Spot (avulso)',
            ]
        );

        CategoriaPublicidadePropaganda::updateOrCreate(
            ['id' => 15],
            [
                'id' => 15,
                'descricao' => 'TCC/Projeto Experimental em Publicidade e Propaganda',
            ]
        );
    }
}
