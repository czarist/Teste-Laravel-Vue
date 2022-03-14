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



        return view('home');
    }
}
