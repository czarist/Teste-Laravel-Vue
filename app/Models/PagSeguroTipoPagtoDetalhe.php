<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagSeguroTipoPagtoDetalhe extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'nome',
    ];
}
