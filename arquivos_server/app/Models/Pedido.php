<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'marca',
        'perfil',
        'coruni',
        'cor01',
        'cor02',
        'atuacao',
        'logo',
        'user_id',
        'produto_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

}
