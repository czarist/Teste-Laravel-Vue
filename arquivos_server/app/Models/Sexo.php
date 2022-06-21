<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipo_sexo',
    ];
}
