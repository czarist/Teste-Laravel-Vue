<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodosDivisoesTematicas extends Model
{
    use SoftDeletes;

    protected $table = 'todos_divisoes_tematicas';

    protected $fillable = [
        'dt_id',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
