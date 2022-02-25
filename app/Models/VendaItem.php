<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'qtd',
        'valor',
        'valor_total',
        'venda_id',
        'produto_id',
    ];
}
