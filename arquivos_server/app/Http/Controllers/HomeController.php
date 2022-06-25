<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\PagSeguroPgto;
use App\Models\RegionalNordeste;
use App\Models\RegionalSuldeste;
use App\Models\TodosTiposUsers;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // DB::enableQueryLog();

        // $data = User::select('id', 'name', 'email', 'cpf', 'sexo_id', 'telefone', 'celular', 'deleted_at')
        // ->with(
        //     'sexo:id,tipo_sexo',
        //     'associado:id,instituicao_id,titulacao_id,anuidade', 
        //     'associado.instituicao:id,instituicao,sigla_instituicao',
        //     'associado.titulacao:id,titulacao',
        //     'vendas:id,user_id',
        //     'vendas.vendas_item:id,venda_id,produto_id',
        //     'vendas.vendas_item.produto:id,categoria,nome,valor',
        //     'vendas.pagamento:id,venda_id,status_id,user_id',
        //     'todos_tipos', 
        //     'regional_nordeste:id,user_id,regiao,guardador_sabado,port_nece_espe,port_nece_espe_qual,port_nece_espe_outra'
        //     )
        //     ->whereHas('todos_tipos', function ($query) {
        //         $query->where('tipo_id', 7);
        //     })
            
        // ->get()->toArray();

        // // dd($data[0]);

        // dd(DB::getQueryLog());

        // $handle = fopen(public_path()."/excel/export.csv", 'w');

        // foreach ($data as $row) {
        //     fputcsv($handle, $row);
        // }

        // fclose($handle);


        // $count_pagamentos_aprovados = [];

        // //Todas as inscricoes nordeste
        // $inscricao_nordeste = RegionalSuldeste::select('id', 'user_id')->get();
        // foreach ($inscricao_nordeste as $inscricao) {
        //     $vendas_nordeste = Venda::where('user_id', $inscricao->user_id)->get();
        //     foreach ($vendas_nordeste as $venda) {
        //         $vendas_items = VendaItem::where('venda_id', $venda->id)
        //                             ->whereIn('produto_id', [13,14,15,16])
        //                             ->get();
        //         if(count($vendas_items) > 0) {
        //             foreach ($vendas_items as $venda_item) {
        //                 $transacao = PagSeguroPgto::where('venda_id', $venda_item->id)
        //                                                 ->whereIn('status_id', [3,4])
        //                                                     ->get()->toArray();

        //                 if(count($transacao) > 0) {
        //                         foreach ($transacao as $trans) {
        //                             $todos = TodosTiposUsers::where('user_id', '=', $trans['user_id'])
        //                                                         ->where('tipo_id', '=', 8)
        //                                                             ->get()->toArray();

        //                             if(count($todos) > 0) {
        //                                     array_push($count_pagamentos_aprovados, $todos);
        //                             }   

        //                         }
        //                     // array_push($count_pagamentos_aprovados, $transacao);
        //                 }
        //             }
        //         }
        //     }
        // }

        // dd($count_pagamentos_aprovados);

        // // $todos = TodosTiposUsers::where('tipo_id', '=', 8)->get();
        // // dd($todos);


        //VERIFICAR FILIACAO PAGA
        if(!Auth::user()->is_associado){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $tipo_venda = $venda->vendas_item->produto->nome;

                        if($tipo_venda == "Associado")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 3, 1 => 5];
                                $user->todos_tipos()->attach($todos_tipos);

                                $associado = Associado::whereUserId($user->id)->first();   

                                if(!empty($associado)){
                                    $associado->update(
                                        [
                                            'anuidade' => date('Y'),
                                        ]
                                    );
                                }

                                if(empty($associado)){
                                    $associado = Associado::create(
                                        [
                                            'user_id' => $user->id,
                                            'anuidade' => date('Y'),
                                        ]
                                    );
                                }
                            
                                Log::info("Verificação de pagamento associado | Usuário: " . Auth::user()->name . " foi alterado para associado e anuidade 2022 quitada.");
                            }
                        }
                    }
                }
            }
        }

        //VERIFICAR ANUIDADE PAGA
        if(!Auth::user()->anuidade_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        if($categoria_venda == "Anuidade")
                        {
                            $tipo_venda = $venda->vendas_item->produto->nome;

                            if($tipo_venda == "Anuidade 2022")
                            {
                                if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                                {
                                    $user = User::findOrFail(Auth::user()->id);
    
                                    if(Auth::user()->is_associado){
                                        $associado = Associado::whereUserId($user->id)->first();   
    
                                        if(!empty($associado)){
                                            $associado->update(
                                                [
                                                    'anuidade' => date('Y'),
                                                ]
                                            );
                                        }
                                    }                        
                                    $todos_tipos = [0 => 5];
                                    $user->todos_tipos()->attach($todos_tipos);
                                    Log::info("Verificação de pagamento Anuidade 2022 | Usuário: " . Auth::user()->name . " foi alterado tipo para anuidade 2022.");
                                }
                            }
    
                        }
                    }
                }
            }
        }

        //VERIFICAR REGIONAL SUL 2022 PAGO
        if(!Auth::user()->pago_regional_sul_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        if($categoria_venda == "Regional-Sul")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 6];
                                $user->todos_tipos()->attach($todos_tipos);
                                Log::info("Verificação de pagamento Regional 2022 | Usuário: " . Auth::user()->name . " foi adicionado tipo para pago Regional 2022 .");
                            }
                        }
                    }
                }
            }
        }

        //VERIFICAR REGIONAL NORDESTE 2022 PAGO
        if(!Auth::user()->pago_regional_nordeste_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        if($categoria_venda == "Regional-Nordeste")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 7];
                                $user->todos_tipos()->attach($todos_tipos);
                                Log::info("Verificação de pagamento Regional Nordeste 2022 | Usuário: " . Auth::user()->name . " foi adicionado tipo para pago Regional 2022 .");
                            }
                        }
                    }
                }
            }
        }
        
        //VERIFICAR REGIONAL SULDESTE 2022 PAGO
        if(!Auth::user()->pago_regional_suldeste_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        
                        if($categoria_venda == "Regional-Suldeste")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 8];
                                $user->todos_tipos()->attach($todos_tipos);
                                Log::info("Verificação de pagamento Regional-Sudeste 2022 | Usuário: " . Auth::user()->name . " foi adicionado tipo para pago Regional 2022 .");
                            }
                        }
                    }
                }
            }
        }

        //VERIFICAR REGIONAL CENTRO OESTE 2022 PAGO
        if(!Auth::user()->pago_regional_centrooeste_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        if($categoria_venda == "Regional-Centro-Oeste")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 9];
                                $user->todos_tipos()->attach($todos_tipos);
                                Log::info("Verificação de pagamento Regional-Centro-Oeste 2022 | Usuário: " . Auth::user()->name . " foi adicionado tipo para pago Regional 2022 .");
                            }
                        }
                    }
                }
            }
        }

        //VERIFICAR REGIONAL NORTE 2022 PAGO
        if(!Auth::user()->pago_regional_norte_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        if($categoria_venda == "Regional-Norte")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 10];
                                $user->todos_tipos()->attach($todos_tipos);
                                Log::info("Verificação de pagamento Regional-Norte 2022 | Usuário: " . Auth::user()->name . " foi adicionado tipo para pago Regional 2022 .");
                            }
                        }
                    }
                }
            }
        }

        //VERIFICAR NACIONAL 2022 PAGO
        if(!Auth::user()->pago_nacional_2022){
            $vendas = Venda::select()
            ->with(
                    'pagamento',
                    'pagamento.tipo_pgto_detalhe',
                    'pagamento.status',
                    'pagamento.tipo_pgto',
                    'vendas_item', 
                    'vendas_item.produto',
                    'user:id,name'
                    )
            ->when(Auth::user()->is_user, function ($q) {
                $q->whereUserId(Auth::user()->id);
            })->get();

            if(!empty($vendas) && count($vendas))
            {
                foreach($vendas as $venda)
                {
                    if(!empty($venda) && !empty($venda->vendas_item) && !empty($venda->vendas_item->produto))
                    {
                        $categoria_venda = $venda->vendas_item->produto->categoria;

                        if($categoria_venda == "Nacional")
                        {
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3 || !empty($venda->pagamento) && $venda->pagamento->status_id == 4)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 11];
                                $user->todos_tipos()->attach($todos_tipos);
                                Log::info("Verificação de pagamento Nacional 2022 | Usuário: " . Auth::user()->name . " foi adicionado tipo para pago Nacional 2022 .");
                            }
                        }
                    }
                }
            }
        }
        
        return view('home');
    }
}
