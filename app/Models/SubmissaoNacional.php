<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmissaoNacional extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inscricao_id',
        'avaliacao',
        'apresentacao',
        'vencedor',
        'ciente',
        'dt',
        'tipo',
        'titulo',
        'termo_autoria',
        'autorizacao',
        'link_trabalho',
        'ano',
        'editora',
        'lattes'
    ];

    public function CoautorOrganizadoresSubNaci()
    {
        return $this->hasMany(CoautorOrganizadoresSubNaci::class,  'submissao_id', 'id');
    }
    
    public function avaliacao(){
        return $this->hasOne(DistribuicaoTipo123::class, 'id', 'avaliacao');
    }

    public function inscricao(){
        return $this->belongsTo(RegionalCentrooeste::class, 'inscricao_id', 'id');
    }

}
