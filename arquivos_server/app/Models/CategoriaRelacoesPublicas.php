<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CategoriaRelacoesPublicas extends Model
{
    use SoftDeletes;

    protected $fillable = ['descricao'];
}
