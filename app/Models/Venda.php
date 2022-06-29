<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
    ];

    public function vendas_item()
    {
        return $this->hasOne(VendaItem::class);
    }

    public function pagamento()
    {
        return $this->hasOne(PagSeguroPgto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
