<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodosCategoriaCinemaAudiovisual extends Model
{
    use SoftDeletes;

    protected $table = 'todos_categoria_cinema_audiovisuals';

    protected $fillable = [
        'categoria_id',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
