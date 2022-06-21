<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PagSeguroTipoPagtoDetalhe extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'nome',
    ];

    
}
