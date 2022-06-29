<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIsencao extends Model
{
    protected $table = 'tipo_isencao';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
