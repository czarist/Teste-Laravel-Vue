<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'categoria',
        'nome',
        'valor'
    ];
}
