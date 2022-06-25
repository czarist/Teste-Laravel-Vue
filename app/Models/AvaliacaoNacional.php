<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoNacional extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'avaliador_1',
        'status_avaliador_1',
        'justificativa_avaliador_1',
        'avaliador_2',
        'status_avaliador_2',
        'justificativa_avaliador_2',
        'avaliador_3',
        'status_avaliador_3',
        'justificativa_avaliador_3',
        'status_coordenador',
        'justificativa_coordenador',
        'edit'
    ];

    public function avaliador_1(){
        return $this->hasOne(User::class, 'id', 'avaliador_1');
    }

    public function avaliador_2(){
        return $this->hasOne(User::class, 'id', 'avaliador_2');
    }

    public function avaliador_3(){
        return $this->hasOne(User::class, 'id', 'avaliador_3');
    }

    public function sub_gp(){
        return $this->hasOne(SubmissaoNacional::class, 'avaliacao', 'id')->whereTipo('Grupo de Pesquisa');
    }

    public function sub_ij(){
        return $this->hasOne(SubmissaoNacional::class, 'avaliacao', 'id')->whereTipo('Intercom Júnior');
    }

    public function sub_publicom(){
        return $this->hasOne(SubmissaoNacional::class, 'avaliacao', 'id')->whereTipo('Publicom');
    }



}
