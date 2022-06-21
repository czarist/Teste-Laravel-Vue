<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'numero_socio',
        'categoria',
        'anuidade',
        'divisao_tematica',
        'obs_isentamos',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
