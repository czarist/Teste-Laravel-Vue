<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AcessoUser extends Model
{
    use SoftDeletes;

    protected $table = 'acesso_user';
    protected $fillable = [   
        'acesso_id',
        'user_id',
    ];
}
