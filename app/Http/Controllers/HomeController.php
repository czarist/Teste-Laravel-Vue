<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
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
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
                            {
                                $user = User::findOrFail(Auth::user()->id);
                                $todos_tipos = [0 => 3];
                                $user->todos_tipos()->attach($todos_tipos);

                                Log::info("Verificação de pagamento associado | Usuário: " . Auth::user()->name . " foi alterado para associado.");
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
                                if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
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
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
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
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
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
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
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
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
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
                            if(!empty($venda->pagamento) && $venda->pagamento->status_id == 3)
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

        return view('home');
    }
}
