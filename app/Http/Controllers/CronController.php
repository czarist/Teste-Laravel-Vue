<?php

namespace App\Http\Controllers;

use App\Models\PagSeguroPgto;
use App\Models\Venda;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function verificar_pagos(){

        // $pagamentos = PagSeguroPgto::select('id', 'status_id', 'user_id', 'produto_id')
        //     ->whereIn('status_id', [3,4])
        //     ->get();
        
        $pagamentos = Venda::select('id', 'user_id', 'created_at')
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name,cpf,email'
                    
                    )
            ->wherehas('pagamento')
            ->wherehas('pagamento' , function ($query){
                $query->whereIn('status_id', [3,4]);
            })


            // ->whereIn('status_id', [3,4])
            ->get();

        dd($pagamentos[0]);
    }

}
