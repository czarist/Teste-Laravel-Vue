<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagSeguroPgto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipo_pgto_detalhe',
        'transacao',
        'parcelas',
        'valor_parcela',
        'valor_total',
        'valor_juros',
        'valor_receber',
        'venda_id',
        'tipo_pagto_id',
        'status_id',
        'user_id',
    ];

    public function status()
    {
        return $this->belongsTo(PagSeguroTipoStatus::class);
    }

    public function tipo_pgto()
    {
        return $this->belongsTo(PagSeguroTipoPagto::class, 'tipo_pagto_id', 'id');
    }

    public function tipo_pgto_detalhe()
    {
        return $this->belongsTo(PagSeguroTipoPagtoDetalhe::class, 'tipo_pgto_detalhe', 'id');
    }

    public function vendas()
    {
        return $this->belongsTo(Venda::class, 'venda_id', 'id');
    }
}
