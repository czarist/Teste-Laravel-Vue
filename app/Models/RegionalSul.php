<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RegionalSul extends Model
{
    use SoftDeletes;

    protected $table = 'regional_suls';
    protected $fillable = [
        'user_id',
        'regiao',
        'categoria_inscricao',
        'numero_matricula',
        'ano',
        'guardador_sabado',
        'port_nece_espe',
        'port_nece_espe_qual',
        'port_nece_espe_outra'
    ];

    public function submissao(){
        return $this->hasOne(SubmissaoRegionalSul::class, 'inscricao_id', 'id');
    }
}
