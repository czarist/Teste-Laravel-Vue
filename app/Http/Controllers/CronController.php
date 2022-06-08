<?php

namespace App\Http\Controllers;

use App\Models\PagSeguroPgto;
use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CronController extends Controller
{
    public function atualizar_valores(){
        Carbon::setLocale('pt_BR');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        // //VALORES SUL
        // if($now >= "2022-05-03 00:00:00"){
        //     $produto_graduado = Produto::find(3);
        //     $produto_pos = Produto::find(5);
        //     $produto_professor = Produto::find(6);
        //     $produto_graduado->update(['valor' => '50.00']);
        //     $produto_pos->update(['valor' => '145.00']);
        //     $produto_professor->update(['valor' => '255.00']);

        //     Log::info('Atualizou valores Regional Sul - ' . $now);
        // }
        // if($now >= "2022-05-21 00:00:00"){
        //     $produto_graduado = Produto::find(3);
        //     $produto_pos = Produto::find(5);
        //     $produto_professor = Produto::find(6);
        //     $produto_graduado->update(['valor' => '65.00']);
        //     $produto_pos->update(['valor' => '165.00']);
        //     $produto_professor->update(['valor' => '275.00']);

        //     Log::info('Atualizou valores Regional Sul - '. $now );
        // }

        // //VALORES NORTE 
        // if($now >= "2022-05-07 00:00:00"){
        //     $produto_graduado = Produto::find(23);
        //     $produto_pos = Produto::find(25);
        //     $produto_professor = Produto::find(26);
        //     $produto_graduado->update(['valor' => '65.00']);
        //     $produto_pos->update(['valor' => '165.00']);
        //     $produto_professor->update(['valor' => '275.00']);

        //     Log::info('Atualizou valores Regional Norte - ' . $now);
        // }

        // //VALORES CENTRO OESTE
        // if($now >= "2022-05-14 00:00:00"){
        //     $produto_graduado = Produto::find(18);
        //     $produto_pos = Produto::find(20);
        //     $produto_professor = Produto::find(21);
        //     $produto_graduado->update(['valor' => '65.00']);
        //     $produto_pos->update(['valor' => '165.00']);
        //     $produto_professor->update(['valor' => '275.00']);

        //     Log::info('Atualizou valores Regional Centro Oeste - ' . $now);
        // }

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

    public function deletar_pag_recusado(){
        Carbon::setLocale('pt_BR');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $pgtos = PagSeguroPgto::select('id', 'venda_id', 'status_id', 'created_at', 'updated_at', 'deleted_at')
        ->with('vendas', 'vendas.vendas_item')
        ->where('status_id', 7)
        ->where('updated_at', '<', Carbon::now()->subDays(7))
        ->get()
        ->each(function ($pgtos) {
            if($pgtos && $pgtos->vendas && $pgtos->vendas->vendas_item){
                $pgtos->vendas->vendas_item->delete();
            }
            if($pgtos && $pgtos->vendas){
                $pgtos->vendas->delete();
            }
            if($pgtos){
                $pgtos->delete();
            }
        });

        Log::info('Cron Job PagSeguro | pagamentos +7 dias deletado: '.count($pgtos).' | Data:'.$now );

        return;

    }

    public function verificar_pagamentos(){
        $pgtos = PagSeguroPgto::select('id', 'venda_id', 'status_id', 'created_at', 'updated_at', 'deleted_at')
        ->with('vendas', 'vendas.vendas_item', 'vendas.user', 'vendas.user.todos_tipos')
        ->whereIn('status_id', [3,4])
        ->get()
        ->each(function ($pgtos) {
            if($pgtos && $pgtos->vendas && $pgtos->vendas->vendas_item && $pgtos->vendas->vendas_item->produto_id){

                if($pgtos->vendas->vendas_item->produto_id == 2){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(5, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 5];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 5');
                        }
                    }
                }

                if($pgtos->vendas->vendas_item->produto_id == 3 || $pgtos->vendas->vendas_item->produto_id == 4 
                || $pgtos->vendas->vendas_item->produto_id == 5 || $pgtos->vendas->vendas_item->produto_id == 6){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(6, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 6];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 6');
                        }
                    }
                }

                if($pgtos->vendas->vendas_item->produto_id == 8 || $pgtos->vendas->vendas_item->produto_id == 9
                || $pgtos->vendas->vendas_item->produto_id == 10 || $pgtos->vendas->vendas_item->produto_id == 11){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(7, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 7];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 7');
                        }
                    }
                }

                if($pgtos->vendas->vendas_item->produto_id == 13 || $pgtos->vendas->vendas_item->produto_id == 14
                || $pgtos->vendas->vendas_item->produto_id == 15 || $pgtos->vendas->vendas_item->produto_id == 16){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(8, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 8];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 8');
                        }
                    }
                }

                if($pgtos->vendas->vendas_item->produto_id == 18 || $pgtos->vendas->vendas_item->produto_id == 19
                || $pgtos->vendas->vendas_item->produto_id == 20 || $pgtos->vendas->vendas_item->produto_id == 21){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(9, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 9];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 9');
                        }
                    }
                }

                if($pgtos->vendas->vendas_item->produto_id == 23 || $pgtos->vendas->vendas_item->produto_id == 24
                || $pgtos->vendas->vendas_item->produto_id == 25 || $pgtos->vendas->vendas_item->produto_id == 26){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(10, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 10];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 10');
                        }
                    }
                }

                if($pgtos->vendas->vendas_item->produto_id == 27 || $pgtos->vendas->vendas_item->produto_id == 28
                || $pgtos->vendas->vendas_item->produto_id == 29 || $pgtos->vendas->vendas_item->produto_id == 30){
                    if($pgtos && $pgtos->vendas && $pgtos->vendas->user && $pgtos->vendas->user->todos_tipos){
                        $tipos = $pgtos->vendas->user->todos_tipos->toArray();
                        $verificar_tipo = array_search(11, array_column($tipos, 'id'));
                        if($verificar_tipo === false || $verificar_tipo == 0){
                            $todos_tipos = [0 => 11];
                            $pgtos->vendas->user->todos_tipos()->attach($todos_tipos);
                            Log::info('Cron Job Pagamento | Atualizou tipo de usuário: '.$pgtos->vendas->user->id.' | Tipo: 11');
                        }
                    }
                }
            }
        });
    }

    public function verificar_tipos_pagamentos_sul(){
        $users = User::select('id')
            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
            ->whereHas('todos_tipos', function($query){
                $query->where('tipo_id', '=', 6);
            })
            ->get()
            ->each(function ($user) {
                if($user && $user->todos_tipos){
                    foreach($user->todos_tipos as $tipo){
                        if($tipo->id == 6){
                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                foreach($user->todos_tipos_pagamentos as $tipo_pagamento){
                                    if($tipo_pagamento->id != 1 && $tipo_pagamento->id != 2 && $tipo_pagamento->id != 3){
                                        if($user->vendas && $user->vendas->count() > 0){
                                            foreach($user->vendas as $venda){

                                                $load_user_3 = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos_3 = $load_user_3->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo_3_0 = array_search("sul_pago_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_1 = array_search("sul_usuario_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_2 = array_search("sul_associado_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                if($verificar_tipo_3_0 === false ){
                                                    if($verificar_tipo_3_1 === false){
                                                        if($verificar_tipo_3_2 === false){
                                                            if(
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 3 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 3 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 4 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 4 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 5 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 5 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 6 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 6 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 1];
                                                                $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 1');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
        
                                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                                if($user->vendas && $user->vendas->count() > 0){
                                                    foreach($user->vendas as $venda){

                                                        $load_user = User::select('id')
                                                            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                            ->where('id', $user->id)
                                                            ->first();
                            
                                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                        $verificar_tipo = array_search("sul_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_1 = array_search("sul_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_2 = array_search("sul_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                    
                                                        if($verificar_tipo === false ){
                                                            if($verificar_tipo_1 === false){
                                                                if($verificar_tipo_2 === false){
        
                                                                    if (
                                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                    ){
                                                                        $todos_tipos_pagamentos = [0 => 3];
                                                                        $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 3');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }        
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2_0 = array_search("sul_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("sul_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("sul_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2_0 === false){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 2];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 2');
                                        }
                                    }
                                }

                            }else{
                                if($user->vendas && $user->vendas->count() > 0){
                                    foreach($user->vendas as $venda){
                                        $load_user = User::select('id')
                                        ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                        ->where('id', $user->id)
                                        ->first();
        
                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                        $verificar_tipo = array_search("sul_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_1 = array_search("sul_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_2 = array_search("sul_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));

                                        if($verificar_tipo === false ){
                                            if($verificar_tipo_1 === false){
                                                if($verificar_tipo_2 === false){
                                                    if(
                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 3 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 3 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 4 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 4 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 5 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 5 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 6 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 6 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ){
                                                        $todos_tipos_pagamentos = [0 => 1];
                                                        $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 1');
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if($load_user->todos_tipos_pagamentos){
                                        if($load_user->vendas && $load_user->vendas->count() > 0){
                                            foreach($load_user->vendas as $venda){

                                                $load_user = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo = array_search("sul_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_1 = array_search("sul_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_2 = array_search("sul_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
            
                                                if($verificar_tipo === false ){
                                                    if($verificar_tipo_1 === false){
                                                        if($verificar_tipo_2 === false){
        
                                                            if (
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 3];
                                                                $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 3');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2 = array_search("sul_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("sul_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("sul_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2 === false ){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 2];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 2');
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            });
    }

    public function verificar_tipos_pagamentos_nordeste(){
        $users = User::select('id')
            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
            ->get()
            ->each(function ($user) {
                if($user && $user->todos_tipos){
                    foreach($user->todos_tipos as $tipo){
                        if($tipo->id == 7){
                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                foreach($user->todos_tipos_pagamentos as $tipo_pagamento){
                                    if($tipo_pagamento->id != 4 && $tipo_pagamento->id != 5 && $tipo_pagamento->id != 6){
                                        if($user->vendas && $user->vendas->count() > 0){
                                            foreach($user->vendas as $venda){

                                                $load_user_3 = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos_3 = $load_user_3->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo_3_0 = array_search("nordeste_pago_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_1 = array_search("nordeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_2 = array_search("nordeste_associado_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                if($verificar_tipo_3_0 === false ){
                                                    if($verificar_tipo_3_1 === false){
                                                        if($verificar_tipo_3_2 === false){
                                                            if(
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 8 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 8 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 9 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 9 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 10 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 10 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 11 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 11 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 4];
                                                                $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 4');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
        
                                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0 && $user->todos_tipos_pagamentos){
                                                if($user->vendas && $user->vendas->count() > 0){
                                                    foreach($user->vendas as $venda){

                                                        $load_user = User::select('id')
                                                            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                            ->where('id', $user->id)
                                                            ->first();
                            
                                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                        $verificar_tipo = array_search("nordeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_1 = array_search("nordeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_2 = array_search("nordeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                    
                                                        if($verificar_tipo === false ){
                                                            if($verificar_tipo_1 === false){
                                                                if($verificar_tipo_2 === false){
        
                                                                    if (
                                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                    ){
                                                                        $todos_tipos_pagamentos = [0 => 6];
                                                                        $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 6');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }        
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2_0 = array_search("nordeste_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("nordeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("nordeste_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2_0 === false){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 5];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 5');
                                        }
                                    }
                                }

                            }else{
                                if($user->vendas && $user->vendas->count() > 0){
                                    foreach($user->vendas as $venda){
                                        $load_user = User::select('id')
                                        ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                        ->where('id', $user->id)
                                        ->first();
        
                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                        $verificar_tipo = array_search("nordeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_1 = array_search("nordeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_2 = array_search("nordeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));

                                        if($verificar_tipo === false ){
                                            if($verificar_tipo_1 === false){
                                                if($verificar_tipo_2 === false){
                                                    if(
                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 8 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 8 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 9 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 9 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 10 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 10 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 11 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 11 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ){
                                                        $todos_tipos_pagamentos = [0 => 4];
                                                        $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 4');
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if($load_user->todos_tipos_pagamentos){
                                        if($load_user->vendas && $load_user->vendas->count() > 0){
                                            foreach($load_user->vendas as $venda){

                                                $load_user = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo = array_search("nordeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_1 = array_search("nordeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_2 = array_search("nordeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
            
                                                if($verificar_tipo === false ){
                                                    if($verificar_tipo_1 === false){
                                                        if($verificar_tipo_2 === false){
        
                                                            if (
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 6];
                                                                $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 6');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2 = array_search("nordeste_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("nordeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("nordeste_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2 === false ){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 5];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 5');
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            });
    }

    public function verificar_tipos_pagamentos_sudeste(){
        $users = User::select('id')
            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
            ->get()
            ->each(function ($user) {
                if($user && $user->todos_tipos){
                    foreach($user->todos_tipos as $tipo){
                        if($tipo->id == 8){
                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                foreach($user->todos_tipos_pagamentos as $tipo_pagamento){
                                    if($tipo_pagamento->id != 7 && $tipo_pagamento->id != 8 && $tipo_pagamento->id != 9){
                                        if($user->vendas && $user->vendas->count() > 0){
                                            foreach($user->vendas as $venda){

                                                $load_user_3 = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos_3 = $load_user_3->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo_3_0 = array_search("sudeste_pago_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_1 = array_search("sudeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_2 = array_search("sudeste_associado_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                if($verificar_tipo_3_0 === false ){
                                                    if($verificar_tipo_3_1 === false){
                                                        if($verificar_tipo_3_2 === false){
                                                            if(
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 13 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 13 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 14 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 14 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 15 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 15 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 16 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 16 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 7];
                                                                $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 7');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
        
                                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0 && $user->todos_tipos_pagamentos){
                                                if($user->vendas && $user->vendas->count() > 0){
                                                    foreach($user->vendas as $venda){

                                                        $load_user = User::select('id')
                                                            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                            ->where('id', $user->id)
                                                            ->first();
                            
                                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                        $verificar_tipo = array_search("sudeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_1 = array_search("sudeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_2 = array_search("sudeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                    
                                                        if($verificar_tipo === false ){
                                                            if($verificar_tipo_1 === false){
                                                                if($verificar_tipo_2 === false){
        
                                                                    if (
                                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                    ){
                                                                        $todos_tipos_pagamentos = [0 => 9];
                                                                        $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 9');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }        
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2_0 = array_search("sudeste_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("sudeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("sudeste_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2_0 === false){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 8];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 8');
                                        }
                                    }
                                }

                            }else{
                                if($user->vendas && $user->vendas->count() > 0){
                                    foreach($user->vendas as $venda){
                                        $load_user = User::select('id')
                                        ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                        ->where('id', $user->id)
                                        ->first();
        
                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                        $verificar_tipo = array_search("sudeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_1 = array_search("sudeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_2 = array_search("sudeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));

                                        if($verificar_tipo === false ){
                                            if($verificar_tipo_1 === false){
                                                if($verificar_tipo_2 === false){
                                                    if(
                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 13 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 13 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 14 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 14 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 15 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 15 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 16 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 16 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ){
                                                        $todos_tipos_pagamentos = [0 => 7];
                                                        $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 7');
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if($load_user->todos_tipos_pagamentos){
                                        if($load_user->vendas && $load_user->vendas->count() > 0){
                                            foreach($load_user->vendas as $venda){

                                                $load_user = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo = array_search("sudeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_1 = array_search("sudeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_2 = array_search("sudeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
            
                                                if($verificar_tipo === false ){
                                                    if($verificar_tipo_1 === false){
                                                        if($verificar_tipo_2 === false){
        
                                                            if (
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 9];
                                                                $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 9');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2 = array_search("sudeste_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("sudeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("sudeste_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2 === false ){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 8];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 8');
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            });
    }

    public function verificar_tipos_pagamentos_centro_oeste(){
        $users = User::select('id')
            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
            ->get()
            ->each(function ($user) {
                if($user && $user->todos_tipos){
                    foreach($user->todos_tipos as $tipo){
                        if($tipo->id == 9){
                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                foreach($user->todos_tipos_pagamentos as $tipo_pagamento){
                                    if($tipo_pagamento->id != 10 && $tipo_pagamento->id != 11 && $tipo_pagamento->id != 12){
                                        if($user->vendas && $user->vendas->count() > 0){
                                            foreach($user->vendas as $venda){

                                                $load_user_3 = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos_3 = $load_user_3->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo_3_0 = array_search("centro_oeste_pago_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_1 = array_search("centro_oeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_2 = array_search("centro_oeste_associado_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                if($verificar_tipo_3_0 === false ){
                                                    if($verificar_tipo_3_1 === false){
                                                        if($verificar_tipo_3_2 === false){
                                                            if(
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 18 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 18 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 19 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 19 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 20 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 20 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 21 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 21 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 10];
                                                                $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 10');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
        
                                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0 && $user->todos_tipos_pagamentos){
                                                if($user->vendas && $user->vendas->count() > 0){
                                                    foreach($user->vendas as $venda){

                                                        $load_user = User::select('id')
                                                            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                            ->where('id', $user->id)
                                                            ->first();
                            
                                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                        $verificar_tipo = array_search("centro_oeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_1 = array_search("centro_oeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_2 = array_search("centro_oeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                    
                                                        if($verificar_tipo === false ){
                                                            if($verificar_tipo_1 === false){
                                                                if($verificar_tipo_2 === false){
        
                                                                    if (
                                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                    ){
                                                                        $todos_tipos_pagamentos = [0 => 12];
                                                                        $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 12');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }        
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2_0 = array_search("centro_oeste_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("centro_oeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("centro_oeste_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2_0 === false){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 11];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 11');
                                        }
                                    }
                                }

                            }else{
                                if($user->vendas && $user->vendas->count() > 0){
                                    foreach($user->vendas as $venda){
                                        $load_user = User::select('id')
                                        ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                        ->where('id', $user->id)
                                        ->first();
        
                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                        $verificar_tipo = array_search("centro_oeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_1 = array_search("centro_oeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_2 = array_search("centro_oeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));

                                        if($verificar_tipo === false ){
                                            if($verificar_tipo_1 === false){
                                                if($verificar_tipo_2 === false){
                                                    if(
                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 18 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 18 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 19 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 19 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 20 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 20 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 21 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 21 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ){
                                                        $todos_tipos_pagamentos = [0 => 10];
                                                        $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 10');
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if($load_user->todos_tipos_pagamentos){
                                        if($load_user->vendas && $load_user->vendas->count() > 0){
                                            foreach($load_user->vendas as $venda){

                                                $load_user = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo = array_search("centro_oeste_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_1 = array_search("centro_oeste_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_2 = array_search("centro_oeste_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
            
                                                if($verificar_tipo === false ){
                                                    if($verificar_tipo_1 === false){
                                                        if($verificar_tipo_2 === false){
        
                                                            if (
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 12];
                                                                $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 12');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2 = array_search("centro_oeste_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("centro_oeste_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("centro_oeste_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2 === false ){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 11];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 11');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
    }

    public function verificar_tipos_pagamentos_norte(){
        $users = User::select('id')
            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
            ->get()
            ->each(function ($user) {
                if($user && $user->todos_tipos){
                    foreach($user->todos_tipos as $tipo){
                        if($tipo->id == 10){
                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                foreach($user->todos_tipos_pagamentos as $tipo_pagamento){
                                    if($tipo_pagamento->id != 13 && $tipo_pagamento->id != 14 && $tipo_pagamento->id != 15){
                                        if($user->vendas && $user->vendas->count() > 0){
                                            foreach($user->vendas as $venda){

                                                $load_user_3 = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos_3 = $load_user_3->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo_3_0 = array_search("norte_pago_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_1 = array_search("norte_usuario_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_2 = array_search("norte_associado_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                if($verificar_tipo_3_0 === false ){
                                                    if($verificar_tipo_3_1 === false){
                                                        if($verificar_tipo_3_2 === false){
                                                            if(
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 23 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 23 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 24 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 24 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 25 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 25 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 26 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 26 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 13];
                                                                $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 13');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
        
                                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0 && $user->todos_tipos_pagamentos){
                                                if($user->vendas && $user->vendas->count() > 0){
                                                    foreach($user->vendas as $venda){

                                                        $load_user = User::select('id')
                                                            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                            ->where('id', $user->id)
                                                            ->first();
                            
                                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                        $verificar_tipo = array_search("norte_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_1 = array_search("norte_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_2 = array_search("norte_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                    
                                                        if($verificar_tipo === false ){
                                                            if($verificar_tipo_1 === false){
                                                                if($verificar_tipo_2 === false){
        
                                                                    if (
                                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                    ){
                                                                        $todos_tipos_pagamentos = [0 => 15];
                                                                        $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 15');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }        
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2_0 = array_search("norte_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("norte_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("norte_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2_0 === false){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 14];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 14');
                                        }
                                    }
                                }

                            }else{
                                if($user->vendas && $user->vendas->count() > 0){
                                    foreach($user->vendas as $venda){
                                        $load_user = User::select('id')
                                        ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                        ->where('id', $user->id)
                                        ->first();
        
                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                        $verificar_tipo = array_search("norte_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_1 = array_search("norte_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_2 = array_search("norte_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));

                                        if($verificar_tipo === false ){
                                            if($verificar_tipo_1 === false){
                                                if($verificar_tipo_2 === false){
                                                    if(
                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 23 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 23 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 24 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 24 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 25 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 25 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 26 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 26 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                    ){
                                                        $todos_tipos_pagamentos = [0 => 13];
                                                        $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 13');
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if($load_user->todos_tipos_pagamentos){
                                        if($load_user->vendas && $load_user->vendas->count() > 0){
                                            foreach($load_user->vendas as $venda){

                                                $load_user = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo = array_search("norte_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_1 = array_search("norte_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_2 = array_search("norte_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
            
                                                if($verificar_tipo === false ){
                                                    if($verificar_tipo_1 === false){
                                                        if($verificar_tipo_2 === false){
        
                                                            if (
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 2 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 15];
                                                                $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 15');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2 = array_search("norte_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("norte_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("norte_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2 === false ){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 14];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 14');
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            });
    }

    public function verificar_tipos_pagamentos_nacional(){
        $users = User::select('id')
            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
            ->get()
            ->each(function ($user) {
                if($user && $user->todos_tipos){
                    foreach($user->todos_tipos as $tipo){
                        if($tipo->id == 11){
                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0){
                                foreach($user->todos_tipos_pagamentos as $tipo_pagamento){
                                    if($tipo_pagamento->id != 16 && $tipo_pagamento->id != 17 && $tipo_pagamento->id != 18){
                                        if($user->vendas && $user->vendas->count() > 0){
                                            foreach($user->vendas as $venda){

                                                $load_user_3 = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos_3 = $load_user_3->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo_3_0 = array_search("nacional_pago_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_1 = array_search("nacional_usuario_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                $verificar_tipo_3_2 = array_search("nacional_associado_isento_2022", array_column($todos_tipos_pagamentos_3, 'nome'));
                                                if($verificar_tipo_3_0 === false ){
                                                    if($verificar_tipo_3_1 === false){
                                                        if($verificar_tipo_3_2 === false){
                                                            if(
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 27 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 27 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 29 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 29 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 30 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                            ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 30 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                            ){
                                                                $todos_tipos_pagamentos = [0 => 16];
                                                                $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 16');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
        
                                            if($user->todos_tipos_pagamentos && $user->todos_tipos_pagamentos->count() > 0 && $user->todos_tipos_pagamentos){
                                                if($user->vendas && $user->vendas->count() > 0){
                                                    foreach($user->vendas as $venda){

                                                        $load_user = User::select('id')
                                                            ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                            ->where('id', $user->id)
                                                            ->first();
                            
                                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                        $verificar_tipo = array_search("nacional_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_1 = array_search("nacional_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                        $verificar_tipo_2 = array_search("nacional_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                    
                                                        if($verificar_tipo === false ){
                                                            if($verificar_tipo_1 === false){
                                                                if($verificar_tipo_2 === false){
        
                                                                    if (
                                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 28 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                    ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 28 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                    ){
                                                                        $todos_tipos_pagamentos = [0 => 18];
                                                                        $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 18');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }        
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2_0 = array_search("nacional_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("nacional_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("nacional_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2_0 === false){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 17];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 17');
                                        }
                                    }
                                }

                            }else{
                                if($user->vendas && $user->vendas->count() > 0){
                                    foreach($user->vendas as $venda){
                                        $load_user = User::select('id')
                                        ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                        ->where('id', $user->id)
                                        ->first();
        
                                        $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                        $verificar_tipo = array_search("nacional_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_1 = array_search("nacional_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                        $verificar_tipo_2 = array_search("nacional_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));

                                        if($verificar_tipo === false ){
                                            if($verificar_tipo_1 === false){
                                                if($verificar_tipo_2 === false){
                                                    if(
                                                        $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 27 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 27 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 29 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 29 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 30 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 30 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                ){
                                                        $todos_tipos_pagamentos = [0 => 16];
                                                        $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                        Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$user->id.' | Tipo: 16');
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if($load_user->todos_tipos_pagamentos){
                                        if($load_user->vendas && $load_user->vendas->count() > 0){
                                            foreach($load_user->vendas as $venda){

                                                $load_user = User::select('id')
                                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                                ->where('id', $user->id)
                                                ->first();

                                                $todos_tipos_pagamentos = $load_user->todos_tipos_pagamentos->toArray();
                                                $verificar_tipo = array_search("nacional_pago_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_1 = array_search("nacional_usuario_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
                                                $verificar_tipo_2 = array_search("nacional_associado_isento_2022", array_column($todos_tipos_pagamentos, 'nome'));
            
                                                if($verificar_tipo === false ){
                                                    if($verificar_tipo_1 === false){
                                                        if($verificar_tipo_2 === false){
        
                                                            if (
                                                                $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 28 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 28 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                        ){
                                                                $todos_tipos_pagamentos = [0 => 18];
                                                                $load_user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                                                Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user->id.' | Tipo: 18');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $load_user_2 = User::select('id')
                                ->with('todos_tipos', 'todos_tipos_pagamentos', 'vendas', 'vendas.vendas_item', 'vendas.pagamento')
                                ->where('id', $user->id)
                                ->first();

                                $todos_tipos_pagamentos_2 = $load_user_2->todos_tipos_pagamentos->toArray();
                                $verificar_tipo_2 = array_search("nacional_pago_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_1 = array_search("nacional_usuario_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));
                                $verificar_tipo_2_2 = array_search("nacional_associado_isento_2022", array_column($todos_tipos_pagamentos_2, 'nome'));

                                if($verificar_tipo_2 === false ){
                                    if($verificar_tipo_2_1 === false){
                                        if($verificar_tipo_2_2 === false){
                                            $todos_tipos_pagamentos = [0 => 17];
                                            $load_user_2->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);
                                            Log::info('Cron Job Pagamento | Atualizou tipo de pagamento: '.$load_user_2->id.' | Tipo: 17');
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            });
    }

}
