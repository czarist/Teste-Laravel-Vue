<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DivisoesTematicasJr extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'dt',
        'descricao',
    ];
}
