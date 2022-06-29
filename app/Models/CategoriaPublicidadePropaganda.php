<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaPublicidadePropaganda extends Model
{
    use SoftDeletes;

    protected $fillable = ['descricao'];
}
