<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RelatoriosController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'cpf', 'email')
            ->with(
                'associado',
                'vendas',
                'vendas.vendas_item',
                'vendas.pagamento',
                'todos_tipos',
                'todos_tipos_pagamentos'
            )
            ->wherehas('todos_tipos', function ($query) {
                $query->whereIn('tipo_id', [1]);
            })

        ->get();

        $tipo =1;

        return view('financeiro.relatorios.index', compact('users', 'tipo'));
    }

    public function get(Request $request)
    {
        $users = User::select('id', 'name', 'cpf', 'email')
            ->with(
                'associado',
                'vendas',
                'vendas.vendas_item',
                'vendas.pagamento',
                'todos_tipos',
                'todos_tipos_pagamentos'
            )
            ->when($request->tipo, function ($query) use ($request) {
                if ($request->tipo == 0) {
                    $query->orWherehas('todos_tipos', function ($query) {
                        $query->whereIn('tipo_id', [1]);
                    });
                }
                if ($request->tipo == 1) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', '=', 1);
                    });
                }
            })
            ->get();

        $tipo = $request->tipo;

        return view('financeiro.relatorios.index', compact('users', 'tipo'));
    }


    public function excel(Request $request)
    {
        $users = User::select('id', 'name', 'cpf', 'email')
        ->with(
            'associado',
            'vendas',
            'vendas.vendas_item',
            'vendas.pagamento',
            'todos_tipos',
            'todos_tipos_pagamentos'
        )
        ->when($request->tipo, function ($query) use ($request) {
            if ($request->tipo == 0) {
                $query->orWherehas('todos_tipos', function ($query) {
                    $query->whereIn('tipo_id', [1]);
                });
            }
            if ($request->tipo == 6) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 1);
                });
            }
        })
        ->get();

        $tipo = $request->tipo;

        $html = view('financeiro.relatorios.excel', compact('users', 'tipo'))->render();
        $nome_arquivo = 'Relatorio-Inscritos.xls';

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D,d M YH:i:s').' GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('Content-type: application/x-msexcel');
        header("Content-Disposition: attachment; filename=\"{$nome_arquivo}\"");
        header('Content-Description: PHP Generated Data');

        Log::info('User: "'.Auth::id().'" Fez o download Excel');

        return $html;
    }
}
