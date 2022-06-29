<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcessoUser extends Model
{
    use SoftDeletes;

    protected $table = 'acesso_user';

    protected $fillable = [
        'acesso_id',
        'user_id',
    ];
}
