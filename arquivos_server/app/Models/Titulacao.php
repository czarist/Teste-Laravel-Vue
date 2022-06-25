<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Titulacao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'titulacao'
    ];

}
