<?php

namespace App\Http\Controllers;

use App\Models\Nacional;
use App\Models\PagSeguroPgto;
use App\Models\PagSeguroTipoPagto;
use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\SubmissaoExpocomRegionalCentrooeste;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Models\SubmissaoExpocomRegionalNorte;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\SubmissaoExpocomRegionalSul;
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalNorte;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\TodosTiposUsers;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function inscritos(Request $request){
        if($request->tipo == null || $request->tipo == "sul"){
            $inscritos_sul = RegionalSul::count();
            $inscricoes = $inscritos_sul;
            $descricao = collect(['descricao' => "Regional Sul"]);
        }
        if($request->tipo == null || $request->tipo == "norte"){
            $inscritos_norte = RegionalNorte::count();
            $inscricoes = $inscritos_norte;
            $descricao = collect(['descricao' => "Regional Norte"]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $inscritos_nordeste = RegionalNordeste::count();
            $inscricoes = $inscritos_nordeste;
            $descricao = collect(['descricao' => "Regional Nordeste"]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $inscritos_centro_oeste = RegionalCentrooeste::count();
            $inscricoes = $inscritos_centro_oeste;
            $descricao = collect(['descricao' => "Regional Centro Oeste"]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $inscritos_sudeste = RegionalSuldeste::count();
            $inscricoes = $inscritos_sudeste;
            $descricao = collect(['descricao' => "Regional Sudeste"]);
        }

        if($request->tipo == null || $request->tipo == "nacional"){
            $inscritos_nacional = Nacional::count();
            $inscricoes = $inscritos_nacional;
            $descricao = collect(['descricao' => "Nacional"]);
        }

        if($request->tipo == null){
            $count = collect(['contagem' => $inscritos_sul + $inscritos_norte + $inscritos_nordeste + $inscritos_centro_oeste + $inscritos_sudeste + $inscritos_nacional]);
            $descricao = collect(['descricao' => "Total de inscritos"]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }else{
            $count = collect(['contagem' => $inscricoes]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }


    }

    public function valor_total(Request $request){

        if($request->tipo == null || $request->tipo == "sul"){

            $valor_total_sul = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->with(
                    'vendas',
                    'vendas.vendas_item'
                    )
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [3,4,5,6]);
                    });
                    // $query->whereHas('pagamento', function ($query) {
                    //     $query->whereIn('status_id', [3,4]);
                    // });
                })
                ->whereIn('status_id', [3,4])
                ->sum('valor_total');
                
            $valor_total = $valor_total_sul;
            $descricao = collect(['descricao' => "Valor total pago Sul"]);
        }

        if($request->tipo == null || $request->tipo == "norte"){
            $valor_total_norte = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [23,24,25,26]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');

            $valor_total = $valor_total_norte;
            $descricao = collect(['descricao' => "Valor total pago Norte"]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $valor_total_nordeste = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [8,9,10,11]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
            ->sum('valor_total');

            $valor_total = $valor_total_nordeste;
            $descricao = collect(['descricao' => "Valor total pago Nordeste"]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $valor_total_centro_oeste = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [18,19,20,21]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');

            $valor_total = $valor_total_centro_oeste;
            $descricao = collect(['descricao' => "Valor total pago Centro Oeste"]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $valor_total_sudeste = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [13,14,15,16]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
            ->sum('valor_total');

            $valor_total = $valor_total_sudeste;
            $descricao = collect(['descricao' => "Valor total pago Sudeste"]);
        }

        if($request->tipo == null || $request->tipo == "nacional"){
            $valor_total_nacional = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [27,28,29,30]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
            ->sum('valor_total');

            $valor_total = $valor_total_nacional;
            $descricao = collect(['descricao' => "Valor total pago Nacional"]);
        }

        // if($request->tipo == null){
        //     $anuidade = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
        //         ->with(
        //             'vendas',
        //             'vendas.vendas_item'
        //             )
        //         ->whereHas('vendas', function ($query) {
        //             $query->whereHas('vendas_item', function ($query) {
        //                 $query->whereIn('produto_id', [1,2]);
        //             });
        //             // $query->whereHas('pagamento', function ($query) {
        //             //     $query->whereIn('status_id', [3,4]);
        //             // });
        //         })
        //         ->whereIn('status_id', [3,4])
        //         ->sum('valor_total');
                
        //     $valor_total = $anuidade;
        //     $descricao = collect(['descricao' => "Valor total pago Sul"]);
        // }

        if($request->tipo == null){
            $descricao = collect(['descricao' => "Total de inscritos pagos"]);
            $vlr_total_inscritos = collect(['vlr_total_inscritos' => $valor_total_sul + $valor_total_norte + $valor_total_nordeste + $valor_total_centro_oeste + $valor_total_sudeste + $valor_total_nacional]);
            // $vlr_total_inscritos = collect(['vlr_total_inscritos' => $anuidade]);

            $data['data'][0] = $descricao->merge($vlr_total_inscritos);
            return response()->json($data);
        }else{
            $data['data'][0] = $descricao->merge($valor_total);
            return response()->json($data);
        }
    }

    public function inscritos_pagos(Request $request){

        if($request->tipo == null || $request->tipo == "sul"){
            $inscritos_sul_pago = RegionalSul::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id,valor_total',
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [3,4,5,6]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });
                    });
                })
            ->count();

            $valor_total_sul = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [3,4,5,6]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');
                
            $inscricoes = $inscritos_sul_pago;
            $valor_total = $valor_total_sul;
            $descricao = collect(['descricao' => "Regional Sul Inscritos Pagos"]);
        }

        if($request->tipo == null || $request->tipo == "norte"){
            $inscritos_norte_pago = RegionalNorte::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [23,24,25,26]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });

                    });
                })
            ->count();

            $valor_total_norte = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [23,24,25,26]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');

            $inscricoes = $inscritos_norte_pago;
            $valor_total = $valor_total_norte;
            $descricao = collect(['descricao' => "Regional Norte Inscritos Pagos"]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $inscritos_nordeste_pago = RegionalNordeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [8,9,10,11]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });

                    });
                })
            ->count();

            $valor_total_nordeste = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [8,9,10,11]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');


            $inscricoes = $inscritos_nordeste_pago;
            $valor_total = $valor_total_nordeste;
            $descricao = collect(['descricao' => "Regional Nordeste Inscritos Pagos"]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $inscritos_centro_oeste_pago = RegionalCentrooeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [18,19,20,21]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });

                    });
                })
            ->count();

            $valor_total_centro_oeste = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [18,19,20,21]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');

            $inscricoes = $inscritos_centro_oeste_pago;
            $valor_total = $valor_total_centro_oeste;
            $descricao = collect(['descricao' => "Regional Centro Oeste Inscritos Pagos"]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $inscritos_sudeste_pago = RegionalSuldeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [13,14,15,16]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });

                    });
                })
            ->count();

            $valor_total_sudeste = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [13,14,15,16]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
                ->sum('valor_total');

            $inscricoes = $inscritos_sudeste_pago;
            $valor_total = $valor_total_sudeste;
            $descricao = collect(['descricao' => "Regional Sudeste Inscritos Pagos"]);
        }

        if($request->tipo == null || $request->tipo == "nacional"){
            $inscritos_nacional_pago = Nacional::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [27,28,29,30]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });

                    });
                })
            ->count();

            $valor_total_nacional = PagSeguroPgto::select('id','valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [27,28,29,30]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3,4]);
                    });
                })
            ->sum('valor_total');

            $inscricoes = $inscritos_nacional_pago;
            $valor_total = $valor_total_nacional;
            $descricao = collect(['descricao' => "Nacional Inscritos Pagos"]);
        }

        if($request->tipo == null){
            $count = collect(['contagem' => $inscritos_sul_pago + $inscritos_norte_pago + $inscritos_nordeste_pago + $inscritos_centro_oeste_pago + $inscritos_sudeste_pago + $inscritos_nacional_pago]);
            $descricao = collect(['descricao' => "Total de inscritos pagos"]);
            $vlr_total_inscritos = collect(['vlr_total_inscritos' => $valor_total_sul + $valor_total_norte + $valor_total_nordeste + $valor_total_centro_oeste + $valor_total_sudeste + $valor_total_nacional]);
            $data['data'][0] = $count->merge($descricao)->merge($vlr_total_inscritos);
            return response()->json($data);
        }else{
            $count = collect(['contagem' => $inscricoes]);
            $data['data'][0] = $count->merge($descricao)->merge($valor_total);
            return response()->json($data);
        }


    }

    public function submissao_expocom(Request $request){
        if($request->tipo == null || $request->tipo == "sul"){
            $submissao_sul = SubmissaoExpocomRegionalSul::select('id')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => "Submissao Sul "]);
        }

        if($request->tipo == null || $request->tipo == "norte"){
            $submissao_norte = SubmissaoExpocomRegionalNorte::select('id')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => "Submissao Norte "]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $submissao_nordeste = SubmissaoExpocomRegionalNordeste::select('id')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => "Submissao Nordeste "]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $submissao_centro_oeste = SubmissaoExpocomRegionalCentrooeste::select('id')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => "Submissao Centro Oeste "]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $submissao_sudeste = SubmissaoExpocomRegionalSudeste::select('id')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => "Submissao Sudeste"]);
        }

        if($request->tipo == null){
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => "Total de Submissões"]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }else{
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }
    }

    public function submissao_dt(Request $request){

        if($request->tipo == null || $request->tipo == "sul"){
            $submissao_sul = SubmissaoRegionalSul::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => "Submissao Sul"]);
        }

        if($request->tipo == null || $request->tipo == "norte"){
            $submissao_norte = SubmissaoRegionalNorte::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => "Submissao Norte"]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $submissao_nordeste = SubmissaoRegionalNordestes::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => "Submissao Nordeste"]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $submissao_centro_oeste = SubmissaoRegionalCentrooeste::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => "Submissao Centro Oeste"]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $submissao_sudeste = SubmissaoRegionalSudeste::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => "Submissao Sudeste"]);
        }

        if($request->tipo == null){
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => "Total de Submissões"]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }else{
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }
    }

    public function submissao_ij(Request $request){

        if($request->tipo == null || $request->tipo == "sul"){
            $submissao_sul = SubmissaoRegionalSul::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => "Submissao Sul"]);
        }

        if($request->tipo == null || $request->tipo == "norte"){
            $submissao_norte = SubmissaoRegionalNorte::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => "Submissao Norte"]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $submissao_nordeste = SubmissaoRegionalNordestes::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => "Submissao Nordeste"]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $submissao_centro_oeste = SubmissaoRegionalCentrooeste::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => "Submissao Centro Oeste"]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $submissao_sudeste = SubmissaoRegionalSudeste::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => "Submissao Sudeste"]);
        }

        if($request->tipo == null){
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => "Total de Submissões"]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }else{
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }
    }

    public function submissao_mesa(Request $request){
            
        if($request->tipo == null || $request->tipo == "sul"){
            $submissao_sul = SubmissaoRegionalSul::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => "Submissao Sul"]);
        }

        if($request->tipo == null || $request->tipo == "norte"){
            $submissao_norte = SubmissaoRegionalNorte::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => "Submissao Norte"]);
        }

        if($request->tipo == null || $request->tipo == "nordeste"){
            $submissao_nordeste = SubmissaoRegionalNordestes::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => "Submissao Nordeste"]);
        }

        if($request->tipo == null || $request->tipo == "centro_oeste"){
            $submissao_centro_oeste = SubmissaoRegionalCentrooeste::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => "Submissao Centro Oeste"]);
        }

        if($request->tipo == null || $request->tipo == "sudeste"){
            $submissao_sudeste = SubmissaoRegionalSudeste::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => "Submissao Sudeste"]);
        }

        if($request->tipo == null){
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => "Total de Submissões"]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }else{
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }
    
    }

    public function inscritos_isentos(Request $request){
        if($request->tipo == "sul"){
            $inscritos_sul_pago = RegionalSul::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [3,4,5,6]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });
                    });
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 6);
                    });
                })
            ->count();

            $todos_tipos_sul = TodosTiposUsers::where('tipo_id', 6)->count();
            $isentos = $todos_tipos_sul - $inscritos_sul_pago;
            $descricao = collect(['descricao' => "Regional Sul Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "norte"){
            $inscritos_norte_pago = RegionalNorte::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [23,24,25,26]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });
                    });
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 10);
                    });
                })
            ->count();

            $todos_tipos_norte = TodosTiposUsers::where('tipo_id', 10)->count();
            $isentos = $todos_tipos_norte - $inscritos_norte_pago;
            $descricao = collect(['descricao' => "Regional Norte Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "nordeste"){
            $inscritos_nordeste_pago = RegionalNordeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [8,9,10,11]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });
                    });
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 7);
                    });
                })
            ->count();

            $todos_tipos_nordeste = TodosTiposUsers::where('tipo_id', 7)->count();
            $isentos = $todos_tipos_nordeste - $inscritos_nordeste_pago;
            $descricao = collect(['descricao' => "Regional Nordeste Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "centro_oeste"){
            $inscritos_centro_oeste_pago = RegionalCentroOeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [18,19,20,21]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });
                    });
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 9);
                    });
                })
            ->count();

            $todos_tipos_centro_oeste = TodosTiposUsers::where('tipo_id', 9)->count();
            $isentos = $todos_tipos_centro_oeste - $inscritos_centro_oeste_pago;
            $descricao = collect(['descricao' => "Regional Centro-Oeste Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "sudeste"){
            $inscritos_sudeste_pago = RegionalSuldeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.vendas:user_id,id',
                    'user.vendas.vendas_item:id,venda_id,produto_id',
                    'user.vendas.pagamento:id,user_id,venda_id,status_id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('vendas', function ($query) {
                        $query->whereHas('vendas_item', function ($query) {
                            $query->whereIn('produto_id', [13,14,15,19]);
                        });
                        $query->whereHas('pagamento', function ($query) {
                            $query->whereIn('status_id', [3,4]);
                        });
                    });
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 8);
                    });
                })
            ->count();

            $todos_tipos_sudeste = TodosTiposUsers::where('tipo_id', 8)->count();
            $isentos = $todos_tipos_sudeste - $inscritos_sudeste_pago;
            $descricao = collect(['descricao' => "Regional Sudeste Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == null){
            $descricao = collect(['descricao' => "Selecione uma Região"]);
            $count = collect(['contagem' => 0]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);

        }
    }

    public function associados_inscritos(Request $request){
        if($request->tipo == "sul"){
            $associados_isentos = RegionalSul::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 5);
                    });
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 6);
                    });
                })

            ->count();

            $isentos = $associados_isentos;
            $descricao = collect(['descricao' => "Associados Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "nordeste"){
            $associados_isentos = RegionalNordeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 5);
                    });
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 7);
                    });
                })
            ->count();

            $isentos = $associados_isentos;
            $descricao = collect(['descricao' => "Associados Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "centro_oeste"){
            $associados_isentos = RegionalCentroOeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 5);
                    });
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 9);
                    });
                })
                
            ->count();

            $isentos = $associados_isentos;
            $descricao = collect(['descricao' => "Associados Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }
        
        if($request->tipo == "norte"){
            $associados_isentos = RegionalNorte::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 5);
                    });
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 10);
                    });
                })
            ->count();

            $isentos = $associados_isentos;
            $descricao = collect(['descricao' => "Associados Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

        if($request->tipo == "sudeste"){
            $associados_isentos = RegionalSuldeste::select('id', 'user_id')
                ->with(
                    'user:id',
                    'user.todos_tipos'
                )
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 5);
                    });
                })
                ->whereHas('user', function ($query) {
                    $query->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 8);
                    });
                })
            ->count();

            $isentos = $associados_isentos;
            $descricao = collect(['descricao' => "Associados Inscritos Isentos"]);
            $count = collect(['contagem' => $isentos]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }


        if($request->tipo == null){
            $descricao = collect(['descricao' => "Selecione uma Região"]);
            $count = collect(['contagem' => 0]);
            $data['data'][0] = $count->merge($descricao);
            return response()->json($data);
        }

    }
}
