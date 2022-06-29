<?php

namespace App\Http\Controllers;

use App\Models\PagSeguroPgto;
use App\Models\Venda;
use Illuminate\Http\Request;

class PagamentosAdminController extends Controller
{
    public function index()
    {
        return view('admin.pagamentos.index');
    }

    public function get(Request $request)
    {
        return Venda::select('id', 'user_id', 'created_at')
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
            ->when($request->sort == 'id', function ($query) {
                $query->orderBy('id', 'DESC');
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->when($request->type == 'name', function ($query) use ($request) {
                        $query->whereHas('user', function ($q) use ($request) {
                            $q->where('name', 'like', '%'.$request->search.'%');
                        });
                    });
                    $query->when($request->type == 'cpf', function ($query) use ($request) {
                        $query->whereHas('user', function ($q) use ($request) {
                            $q->where('cpf', 'like', '%'.$request->search.'%');
                        });
                    });
                    $query->when($request->type == 'email', function ($query) use ($request) {
                        $query->whereHas('user', function ($q) use ($request) {
                            $q->where('email', 'like', '%'.$request->search.'%');
                        });
                    });
                });
            })
            ->when($request->produto, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereHas('vendas_item', function ($query) use ($request) {
                        $query->when($request->produto == 1, function ($query) {
                            $query->whereIn('produto_id', [1, 2]);
                        });
                        $query->when($request->produto == 2, function ($query) {
                            $query->whereIn('produto_id', [1, 2]);
                        });
                        $query->when($request->produto == 3, function ($query) {
                            $query->whereIn('produto_id', [3, 4, 5, 6]);
                        });
                        $query->when($request->produto == 4, function ($query) {
                            $query->whereIn('produto_id', [8, 9, 10, 11]);
                        });
                        $query->when($request->produto == 5, function ($query) {
                            $query->whereIn('produto_id', [13, 14, 15, 16]);
                        });
                        $query->when($request->produto == 6, function ($query) {
                            $query->whereIn('produto_id', [18, 19, 20, 21]);
                        });
                        $query->when($request->produto == 7, function ($query) {
                            $query->whereIn('produto_id', [23, 24, 25, 26]);
                        });
                        $query->when($request->produto == 8, function ($query) {
                            $query->whereIn('produto_id', [27, 28, 29, 30]);
                        });
                    });
                });
            })
            ->when($request->status != null && $request->status != 0, function ($query) use ($request) {
                $query->whereHas('pagamento', function ($query) use ($request) {
                    $query->where('status_id', $request->status);
                });
            })
        ->paginate(20);
    }

    public function pago($id)
    {
        if ($id) {
            $pagamento = PagSeguroPgto::findOrFail($id);
        }
        if (! empty($pagamento)) {
            $pagamento->update(['status_id' => 3]);

            return response()->json(['success' => true, 201]);
        }

        return response()->json(['success' => false, 201]);
    }
}
