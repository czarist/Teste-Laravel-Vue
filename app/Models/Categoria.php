<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero_socio',
        'categoria',
        'anuidade',
        'divisao_tematica',
        'obs_isentamos',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
