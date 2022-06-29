<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodosTiposUsers extends Model
{
    use SoftDeletes;

    protected $table = 'todos_tipos_users';

    protected $fillable = [
        'tipo_id',
        'user_id',
    ];
}
