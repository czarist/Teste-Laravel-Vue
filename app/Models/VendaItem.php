<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
