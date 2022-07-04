<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvaliacaoNacional extends Model
{
    use SoftDeletes;

    protected $table = 'avaliacao_nacional';

    protected $fillable = [
        'avaliador_1',
        'status_avaliador_1',
        'justificativa_avaliador_1',
        'pergunta_1_1',
        'pergunta_1_2',
        'pergunta_1_3',
        'pergunta_1_4',
        'pergunta_1_5',
        'pergunta_1_6',
        'pergunta_1_7',
        'pergunta_1_8',
        'pergunta_1_9',
        'pergunta_1_10',
        'pergunta_1_11',
        'avaliador_2',
        'status_avaliador_2',
        'justificativa_avaliador_2',
        'pergunta_2_1',
        'pergunta_2_2',
        'pergunta_2_3',
        'pergunta_2_4',
        'pergunta_2_5',
        'pergunta_2_6',
        'pergunta_2_7',
        'pergunta_2_8',
        'pergunta_2_9',
        'pergunta_2_10',
        'pergunta_2_11',
        'avaliador_3',
        'status_avaliador_3',
        'justificativa_avaliador_3',
        'pergunta_3_1',
        'pergunta_3_2',
        'pergunta_3_3',
        'pergunta_3_4',
        'pergunta_3_5',
        'pergunta_3_6',
        'pergunta_3_7',
        'pergunta_3_8',
        'pergunta_3_9',
        'pergunta_3_10',
        'pergunta_3_11',
        'status_coordenador',
        'justificativa_coordenador',
        'edit',
    ];

    public function avaliador_1()
    {
        return $this->hasOne(User::class, 'id', 'avaliador_1');
    }

    public function avaliador_2()
    {
        return $this->hasOne(User::class, 'id', 'avaliador_2');
    }

    public function avaliador_3()
    {
        return $this->hasOne(User::class, 'id', 'avaliador_3');
    }

    public function sub_gp()
    {
        return $this->hasOne(SubmissaoNacional::class, 'avaliacao', 'id')->whereTipo('Grupo de Pesquisa');
    }

    public function sub_ij()
    {
        return $this->hasOne(SubmissaoNacional::class, 'avaliacao', 'id')->whereTipo('Intercom Júnior');
    }

    public function sub_publicom()
    {
        return $this->hasOne(SubmissaoNacional::class, 'avaliacao', 'id')->whereTipo('Publicom');
    }
}
