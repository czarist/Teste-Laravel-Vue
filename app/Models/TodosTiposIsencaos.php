<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TodosTiposIsencaos extends Model
{
    use SoftDeletes;

    protected $table = 'todo_tipos_isencao';
    protected $fillable = [
        'tipo_id',
        'user_id',
    ];
}
