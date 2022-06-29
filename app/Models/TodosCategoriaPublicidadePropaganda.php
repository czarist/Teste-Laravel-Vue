<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodosCategoriaPublicidadePropaganda extends Model
{
    use SoftDeletes;

    protected $table = 'todos_categoria_publicidade_propagandas';

    protected $fillable = [
        'categoria_id',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
