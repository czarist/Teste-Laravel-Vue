<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmissaoExpocomRegionalSudeste extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inscricao_id',
        'avaliacao',
        'apresentacao',
        'vencedor',
        'regiao',
        'ciente',
        'ano',
        'campus',
        'desc_obj_estudo',
        'desc_pesquisa',
        'desc_producao',
        'termo_autoria',
        'autorizacao',
        'link_trabalho',
        'link_aceite',
    ];

    public function coautorOrientadorSubSudeste()
    {
        return $this->hasMany(CoauOriExpoSubSudeste::class, 'submissao_id', 'id');
    }

    public function avaliacao()
    {
        return $this->hasOne(DistribuicaoTipoExpocom::class, 'id', 'avaliacao');
    }

    public function inscricao()
    {
        return $this->belongsTo(RegionalSuldeste::class, 'inscricao_id', 'id');
    }
}
