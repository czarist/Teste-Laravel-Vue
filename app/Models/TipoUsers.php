<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoUsers extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_users';
    protected $fillable = [
        'descricao'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
