<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodosTiposIsencaos extends Model
{
    use SoftDeletes;

    protected $table = 'todo_tipos_isencao';

    protected $fillable = [
        'tipo_id',
        'user_id',
    ];
}
