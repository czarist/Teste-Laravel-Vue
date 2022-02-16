<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class Endereco extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cep',
        'logadouro',
        'cidade_id',
        'estado_id',
        'pais_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
