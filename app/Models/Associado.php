<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Associado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero_socio',
        'isencao',
        'instituicao_id',
        'titulacao_id',
        'anuidade',
        'divisao_tematica',
        'obs_isentamos',
    ];

}
