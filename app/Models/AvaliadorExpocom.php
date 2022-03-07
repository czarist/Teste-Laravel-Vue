<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AvaliadorExpocom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'avaliador',
        'avaliador_junior'
    ];
}
