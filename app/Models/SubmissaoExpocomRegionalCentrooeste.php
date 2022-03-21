<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmissaoExpocomRegionalCentrooeste extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inscricao_id',
        'ciente',
        'ano',
        'campus',
        'desc_obj_estudo',
        'desc_pesquisa',
        'desc_producao',
        'termo_autoria',
        'autorizacao',
        'link_trabalho',
    ];

    public function coautorOrientadorSubCentrooeste()
    {
        return $this->hasMany(CoauOriExpoSubCentrooeste::class,  'submissao_id', 'id');
    }

}
