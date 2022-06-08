<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TodosTiposPagamentos extends Model
{
    use SoftDeletes;

    protected $table = 'todos_tipos_pagamentos';
    protected $fillable = [
        'tipo_id',
        'user_id',
    ];

}
