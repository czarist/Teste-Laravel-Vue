<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class TodosDivisoesTematicasJr extends Model
{
    use SoftDeletes;

    protected $table = 'todos_divisoes_tematicas_jrs';
    protected $fillable = [
        'dt_id',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
