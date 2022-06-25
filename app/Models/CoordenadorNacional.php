<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoordenadorNacional extends Model
{
    use SoftDeletes;

    protected $table = 'coordenador_nacional';

    protected $fillable = [
        'user_id',
        'geral',
        'tipo',
        'gps',
        'ij',
        'dt',
        'ano',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
