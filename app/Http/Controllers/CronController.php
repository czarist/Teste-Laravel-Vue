<?php

namespace App\Http\Controllers;

use App\Models\PagSeguroPgto;
use App\Models\Produto;
use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CronController extends Controller
{
    public function atualizar_valores(){
        Carbon::setLocale('pt_BR');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        //VALORES SUL
        if($now >= "2022-05-03 00:00:00"){
            $produto_graduado = Produto::find(3);
            $produto_pos = Produto::find(5);
            $produto_professor = Produto::find(6);
            $produto_graduado->update(['valor' => '50.00']);
            $produto_pos->update(['valor' => '145.00']);
            $produto_professor->update(['valor' => '255.00']);

            Log::info('Atualizou valores Regional Sul - ' . $now);
        }
        if($now >= "2022-05-21 00:00:00"){
            $produto_graduado = Produto::find(3);
            $produto_pos = Produto::find(5);
            $produto_professor = Produto::find(6);
            $produto_graduado->update(['valor' => '65.00']);
            $produto_pos->update(['valor' => '165.00']);
            $produto_professor->update(['valor' => '275.00']);

            Log::info('Atualizou valores Regional Sul - '. $now );
        }

        //VALORES NORTE 
        if($now >= "2022-05-07 00:00:00"){
            $produto_graduado = Produto::find(23);
            $produto_pos = Produto::find(25);
            $produto_professor = Produto::find(26);
            $produto_graduado->update(['valor' => '65.00']);
            $produto_pos->update(['valor' => '165.00']);
            $produto_professor->update(['valor' => '275.00']);

            Log::info('Atualizou valores Regional Norte - ' . $now);
        }

        //VALORES CENTRO OESTE
        if($now >= "2022-05-14 00:00:00"){
            $produto_graduado = Produto::find(18);
            $produto_pos = Produto::find(20);
            $produto_professor = Produto::find(21);
            $produto_graduado->update(['valor' => '65.00']);
            $produto_pos->update(['valor' => '165.00']);
            $produto_professor->update(['valor' => '275.00']);

            Log::info('Atualizou valores Regional Centro Oeste - ' . $now);
        }

        //VALORES NACIONAL
        if($now >= "2022-06-06 00:00:00"){
            $produto_graduado = Produto::find(27);
            $produto_associado = Produto::find(28);
            $produto_pos = Produto::find(29);
            $produto_professor = Produto::find(30);

            $produto_graduado->update(['valor' => '160.00']);
            $produto_associado->update(['valor' => '170.00']);
            $produto_pos->update(['valor' => '320.00']);
            $produto_professor->update(['valor' => '430.00']);

            Log::info('Atualizou valores Regional Nacional - ' . $now);
        }
        if($now >= "2022-07-09 00:00:00"){
            $produto_graduado = Produto::find(27);
            $produto_associado = Produto::find(28);
            $produto_pos = Produto::find(29);
            $produto_professor = Produto::find(30);

            $produto_graduado->update(['valor' => '185.00']);
            $produto_associado->update(['valor' => '230.00']);
            $produto_pos->update(['valor' => '350.00']);
            $produto_professor->update(['valor' => '515.00']);

            Log::info('Atualizou valores Regional Nacional - ' . $now);
        }

        $now = Carbon::now()->format('Y-m-d H:i:s');

        Log::info('Cron Job Valores iniciada: '.$now );
    }


    // public function verificar_pagos(){

    //     // $pagamentos = PagSeguroPgto::select('id', 'status_id', 'user_id', 'produto_id')
    //     //     ->whereIn('status_id', [3,4])
    //     //     ->get();
        
    //     $pagamentos = Venda::select('id', 'user_id', 'created_at')
    //         ->with(
    //                 'pagamento',
    //                 'pagamento.tipo_pgto_detalhe',
    //                 'pagamento.status',
    //                 'pagamento.tipo_pgto',
    //                 'vendas_item', 
    //                 'vendas_item.produto',
    //                 'user:id,name,cpf,email'
                    
    //                 )
    //         ->wherehas('pagamento')
    //         ->wherehas('pagamento' , function ($query){
    //             $query->whereIn('status_id', [3,4]);
    //         })


    //         // ->whereIn('status_id', [3,4])
    //         ->get();

    //     dd($pagamentos[0]);
    // }
}
