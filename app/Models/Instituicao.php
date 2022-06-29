<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instituicao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'instituicao',
        'sigla_instituicao',
    ];
}
