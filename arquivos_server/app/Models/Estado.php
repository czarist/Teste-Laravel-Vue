<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $fillable = [
        'codigo', 'nome', 'sigla', 'regiao'
    ];

    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }
}
