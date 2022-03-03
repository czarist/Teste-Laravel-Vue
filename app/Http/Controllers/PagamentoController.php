<?php

namespace App\Http\Controllers;

use App\Models\PagSeguroPgto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PagamentoController extends Controller
{
    public function index()
    {
        return view('pagamento.index');
    }

    public function get(Request $request)
    {
        $vendas = Venda::select('id', 'user_id', 'created_at')
                        ->with(
                                'pagamento',
                                'pagamento.tipo_pgto_detalhe',
                                'pagamento.status',
                                'pagamento.tipo_pgto',
                                'vendas_item', 
                                'vendas_item.produto',
                                'user:id,name'
                                
                                )
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when(Auth::user()->is_user, function ($q) {
                            $q->whereUserId(Auth::user()->id);
                        })            
                        ->paginate(20);

        return response()->json($vendas, 201);
    }

}
