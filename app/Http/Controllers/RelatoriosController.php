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
                $query->whereIn('tipo_id', [6]);
            })

        ->get();

        $tipo = 6;

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
                        $query->whereIn('tipo_id', [6]);
                    });
                }
                if ($request->tipo == 6) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', '=', 6);
                    });
                }

                if ($request->tipo == 7) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', '=', 7);
                    });
                }

                if ($request->tipo == 8) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', '=', 8);
                    });
                }

                if ($request->tipo == 9) {
                    $query->Wherehas('todos_tipos', function ($query) {
                        $query->where('tipo_id', '=', 9);
                    });
                }

                if ($request->tipo == 10) {
                    $query->Wherehas('todos_tipos', function ($query) {
                        $query->where('tipo_id', '=', 10);
                    });
                }
            })
            ->get();

        $tipo = $request->tipo;

        return view('financeiro.relatorios.index', compact('users', 'tipo'));
    }

    public function excel2(Request $request)
    {
        //     $users = User::select('id', 'name', 'cpf', 'email')
        //     ->with(
        //         'associado',
        //         'regional_sul',
        //         'regional_nordeste',
        //         'regional_norte',
        //         'regional_centrooeste',
        //         'regional_suldeste',
        //         'vendas',
        //         'vendas.vendas_item',
        //         'vendas.vendas_item.produto',
        //         'vendas.pagamento',
        //         'todos_tipos',
        //         'todos_tipos_pagamentos'
        //     )
        //     ->when($request->tipo, function ($query) use ($request){
        //         if($request->tipo == 0){
        //             $query->whereHas('vendas', function($query){
        //                 $query->whereHas('pagamento', function($query){
        //                     $query->whereIn('status_id', [3,4]);
        //                 });
        //             });
        //             $query->orWherehas('todos_tipos', function ($query) {
        //                 $query->whereIn('tipo_id', [5,6,7,8,9,10]);
        //             });
        //         }
        //         if($request->tipo == 6){
        //             $query->whereHas('vendas', function($query){
        //                 $query->whereHas('pagamento', function($query){
        //                     $query->whereIn('status_id', [3,4]);
        //                 });
        //                 $query->whereHas('vendas_item', function($query){
        //                     $query->whereIn('produto_id', [3,4,5,6]);
        //                 });

        //             });
        //             $query->orWherehas('todos_tipos', function ($query) {
        //                 $query->where('tipo_id', "=", 6);
        //             });
        //         }

        //         if($request->tipo == 7){
        //             $query->whereHas('vendas', function($query){
        //                 $query->whereHas('pagamento', function($query){
        //                     $query->whereIn('status_id', [3,4]);
        //                 });
        //                 $query->whereHas('vendas_item', function($query){
        //                     $query->whereIn('produto_id', [8,9,10,11]);
        //                 });

        //             });
        //             $query->orWherehas('todos_tipos', function ($query) {
        //                 $query->where('tipo_id', "=", 7);
        //             });
        //         }

        //         if($request->tipo == 8){
        //             $query->whereHas('vendas', function($query){
        //                 $query->whereHas('pagamento', function($query){
        //                     $query->whereIn('status_id', [3,4]);
        //                 });
        //                 $query->whereHas('vendas_item', function($query){
        //                     $query->whereIn('produto_id', [13,14,15,16]);
        //                 });

        //             });
        //             $query->orWherehas('todos_tipos', function ($query) {
        //                 $query->where('tipo_id', "=", 8);
        //             });
        //         }

        //         if($request->tipo == 9){
        //             $query->whereHas('vendas', function($query){
        //                 $query->whereHas('pagamento', function($query){
        //                     $query->whereIn('status_id', [3,4]);
        //                 });
        //                 $query->whereHas('vendas_item', function($query){
        //                     $query->whereIn('produto_id', [18,19,20,21]);
        //                 });

        //             });
        //             $query->orWherehas('todos_tipos', function ($query) {
        //                 $query->where('tipo_id', "=", 9);
        //             });
        //         }

        //         if($request->tipo == 10){
        //             $query->whereHas('vendas', function($query){
        //                 $query->whereHas('pagamento', function($query){
        //                     $query->whereIn('status_id', [3,4]);
        //                 });
        //                 $query->whereHas('vendas_item', function($query){
        //                     $query->whereIn('produto_id', [23,24,25,26]);
        //                 });

        //             });
        //             $query->orWherehas('todos_tipos', function ($query) {
        //                 $query->where('tipo_id', "=", 10);
        //             });
        //         }

        //     })
        //     ->get();

        //     $tipo = $request->tipo;

        //     $html = view('financeiro.relatorios.excel', compact('users', 'tipo'))->render();
        //     $nome_arquivo = 'Relatorio-Inscritos.xls';

        //     header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        //     header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        //     header("Cache-Control: no-cache, must-revalidate");
        //     header("Pragma: no-cache");
        //     header("Content-type: application/x-msexcel");
        //     header("Content-Disposition: attachment; filename=\"{$nome_arquivo}\"");
        //     header("Content-Description: PHP Generated Data");

        //     Log::info('User: "' . Auth::id() . '" Fez o download Excel');

        //     return $html;
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
                    $query->whereIn('tipo_id', [6]);
                });
            }
            if ($request->tipo == 6) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 6);
                });
            }

            if ($request->tipo == 7) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 7);
                });
            }

            if ($request->tipo == 8) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 8);
                });
            }

            if ($request->tipo == 9) {
                $query->Wherehas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 9);
                });
            }

            if ($request->tipo == 10) {
                $query->Wherehas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 10);
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
