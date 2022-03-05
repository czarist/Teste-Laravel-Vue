<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

            // dd($vendas->toArray());

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
                                $todos_tipos = [0 => 3 , 1 => 4];
                                $user->todos_tipos()->sync($todos_tipos);
                    
                                Log::info("Verificação de pagamento associado | Usuário: " . Auth::user()->name . " foi alterado para associado.");
                            }

                        }
                    }
                }
            }
        }

        return view('home');
    }
}
