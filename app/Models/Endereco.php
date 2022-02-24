<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class Endereco extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'cep',
        'logradouro',
        'municipio_id',
        'estado_id',
        'pais_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }



}
