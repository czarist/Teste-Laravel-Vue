<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Associado extends Model
{
    use SoftDeletes;

    protected $table = 'associados';
    protected $fillable = [
        'numero_socio',
        'isencao',
        'instituicao_id',
        'titulacao_id',
        'anuidade',
        'divisao_tematica',
        'obs_isentamos',
        'user_id'
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }
    public function titulacao()
    {
        return $this->belongsTo(Titulacao::class);
    }
}