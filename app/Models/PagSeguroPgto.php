<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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
        'user_id'
    ];
}
