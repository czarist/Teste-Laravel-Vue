<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagSeguroTipoStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'memo',
    ];
}
