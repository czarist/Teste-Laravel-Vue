<?php

namespace Database\Seeders;

use App\Models\CatProdEditProdTransComunic;
use Illuminate\Database\Seeder;

class CatProdEditProdTransComunicSeeder extends Seeder
{
    public function run()
    {
        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'descricao' => 'Charge/caricatura/ilustração (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 2],
            [
                'id' => 2,
                'descricao' => 'Comunicação e Inovação (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 3],
            [
                'id' => 3,
                'descricao' => 'Design Gráfico (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 4],
            [
                'id' => 4,
                'descricao' => 'Edição de Livro (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 5],
            [
                'id' => 5,
                'descricao' => 'Embalagem (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 6],
            [
                'id' => 6,
                'descricao' => 'Ensaio fotográfico artístico (conjunto)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 7],
            [
                'id' => 7,
                'descricao' => 'Fotografia artística (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 8],
            [
                'id' => 8,
                'descricao' => 'Fotonovela (avulso ou conjunto/série)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 9],
            [
                'id' => 9,
                'descricao' => 'Game (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 10],
            [
                'id' => 10,
                'descricao' => 'Histórias em Quadrinhos (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 11],
            [
                'id' => 11,
                'descricao' => 'Produção multimídia (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 12],
            [
                'id' => 12,
                'descricao' => 'Projeto de Comunicação integrada (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 13],
            [
                'id' => 13,
                'descricao' => 'Projetos de Extensão',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 14],
            [
                'id' => 14,
                'descricao' => 'Revista customizada (avulso)',
            ]
        );

        CatProdEditProdTransComunic::updateOrCreate(
            ['id' => 15],
            [
                'id' => 15,
                'descricao' => 'Roteiro de Games (avulso)',
            ]
        );
    }
}
