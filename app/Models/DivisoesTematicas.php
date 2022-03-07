<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DivisoesTematicas extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'dt',
        'descricao'
    ];
}
