<?php

namespace App\Http\Controllers;

use App\Models\Nacional;
use App\Models\PagSeguroPgto;
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
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function inscritos(Request $request)
    {
        if ($request->tipo == null || $request->tipo == 'sul') {
            $inscritos_sul = RegionalSul::count();
            $inscricoes = $inscritos_sul;
            $descricao = collect(['descricao' => 'Regional Sul']);
        }
        if ($request->tipo == null || $request->tipo == 'norte') {
            $inscritos_norte = RegionalNorte::count();
            $inscricoes = $inscritos_norte;
            $descricao = collect(['descricao' => 'Regional Norte']);
        }

        if ($request->tipo == null || $request->tipo == 'nordeste') {
            $inscritos_nordeste = RegionalNordeste::count();
            $inscricoes = $inscritos_nordeste;
            $descricao = collect(['descricao' => 'Regional Nordeste']);
        }

        if ($request->tipo == null || $request->tipo == 'centro_oeste') {
            $inscritos_centro_oeste = RegionalCentrooeste::count();
            $inscricoes = $inscritos_centro_oeste;
            $descricao = collect(['descricao' => 'Regional Centro Oeste']);
        }

        if ($request->tipo == null || $request->tipo == 'sudeste') {
            $inscritos_sudeste = RegionalSuldeste::count();
            $inscricoes = $inscritos_sudeste;
            $descricao = collect(['descricao' => 'Regional Sudeste']);
        }

        if ($request->tipo == null || $request->tipo == 'nacional') {
            $inscritos_nacional = Nacional::count();
            $inscricoes = $inscritos_nacional;
            $descricao = collect(['descricao' => 'Nacional']);
        }

        if ($request->tipo == null) {
            $count = collect(['contagem' => $inscritos_sul + $inscritos_norte + $inscritos_nordeste + $inscritos_centro_oeste + $inscritos_sudeste + $inscritos_nacional]);
            $descricao = collect(['descricao' => 'Total de inscritos']);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        } else {
            $count = collect(['contagem' => $inscricoes]);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        }
    }

    public function valor_total(Request $request)
    {
        if ($request->tipo == null || $request->tipo == 'sul') {
            $valor_total_sul = PagSeguroPgto::select('id', 'valor_total', 'status_id', 'venda_id')
                ->with(
                    'vendas',
                    'vendas.vendas_item'
                )
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [3, 4, 5, 6]);
                    });
                })
                ->whereIn('status_id', [3, 4])
                ->sum('valor_total');

            $valor_total = $valor_total_sul;
            $descricao = collect(['descricao' => 'Valor total pago Sul']);
        }

        if ($request->tipo == null || $request->tipo == 'norte') {
            $valor_total_norte = PagSeguroPgto::select('id', 'valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [23, 24, 25, 26]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3, 4]);
                    });
                })
                ->sum('valor_total');

            $valor_total = $valor_total_norte;
            $descricao = collect(['descricao' => 'Valor total pago Norte']);
        }

        if ($request->tipo == null || $request->tipo == 'nordeste') {
            $valor_total_nordeste = PagSeguroPgto::select('id', 'valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [8, 9, 10, 11]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3, 4]);
                    });
                })
            ->sum('valor_total');

            $valor_total = $valor_total_nordeste;
            $descricao = collect(['descricao' => 'Valor total pago Nordeste']);
        }

        if ($request->tipo == null || $request->tipo == 'centro_oeste') {
            $valor_total_centro_oeste = PagSeguroPgto::select('id', 'valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [18, 19, 20, 21]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3, 4]);
                    });
                })
                ->sum('valor_total');

            $valor_total = $valor_total_centro_oeste;
            $descricao = collect(['descricao' => 'Valor total pago Centro Oeste']);
        }

        if ($request->tipo == null || $request->tipo == 'sudeste') {
            $valor_total_sudeste = PagSeguroPgto::select('id', 'valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [13, 14, 15, 16]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3, 4]);
                    });
                })
            ->sum('valor_total');

            $valor_total = $valor_total_sudeste;
            $descricao = collect(['descricao' => 'Valor total pago Sudeste']);
        }

        if ($request->tipo == null || $request->tipo == 'nacional') {
            $valor_total_nacional = PagSeguroPgto::select('id', 'valor_total', 'status_id', 'venda_id')
                ->whereHas('vendas', function ($query) {
                    $query->whereHas('vendas_item', function ($query) {
                        $query->whereIn('produto_id', [27, 28, 29, 30]);
                    });
                    $query->whereHas('pagamento', function ($query) {
                        $query->whereIn('status_id', [3, 4]);
                    });
                })
            ->sum('valor_total');

            $valor_total = $valor_total_nacional;
            $descricao = collect(['descricao' => 'Valor total pago Nacional']);
        }

        if ($request->tipo == null) {
            $descricao = collect(['descricao' => 'Total de inscritos pagos']);
            $vlr_total_inscritos = collect(['vlr_total_inscritos' => $valor_total_sul + $valor_total_norte + $valor_total_nordeste + $valor_total_centro_oeste + $valor_total_sudeste + $valor_total_nacional]);

            $data['data'][0] = $descricao->merge($vlr_total_inscritos);

            return response()->json($data);
        } else {
            $descricao = collect(['descricao' => 'Total de inscritos pagos']);
            $vlr_total_inscritos = collect(['vlr_total_inscritos' => $valor_total]);

            $data['data'][0] = $descricao->merge($vlr_total_inscritos);

            return response()->json($data);
        }
    }

    public function inscritos_pagos(Request $request)
    {
        $users = User::select('id', 'name', 'cpf', 'email')
        ->with(
            'todos_tipos',
            'todos_tipos_pagamentos'
        )
        ->when($request->tipo, function ($query) use ($request) {
            if ($request->tipo == 0 || $request->tipo == null) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->whereIn('tipo_id', [6, 7, 8, 9, 10, 11]);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->whereIn('tipo_pagamento_id', [1, 4, 7, 10, 13, 16]);
                });
            }
            if ($request->tipo == 'sul') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 6);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 1);
                });
            }

            if ($request->tipo == 'nordeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 7);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 4);
                });
            }

            if ($request->tipo == 'sudeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 8);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 7);
                });
            }

            if ($request->tipo == 'centro_oeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 9);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 10);
                });
            }

            if ($request->tipo == 'norte') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 10);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 13);
                });
            }

            if ($request->tipo == 'nacional') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 11);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 16);
                });
            }
        })
        ->count();

        $count = collect(['contagem' => $users]);

        if ($request->tipo == null) {
            $descricao = collect(['descricao' => 'Total de inscritos pagos']);
        }
        if ($request->tipo == 'sul') {
            $descricao = collect(['descricao' => 'Sul - inscritos pagos']);
        }
        if ($request->tipo == 'sudeste') {
            $descricao = collect(['descricao' => 'Sudeste - inscritos pagos']);
        }
        if ($request->tipo == 'nordeste') {
            $descricao = collect(['descricao' => 'Nordeste - inscritos pagos']);
        }
        if ($request->tipo == 'norte') {
            $descricao = collect(['descricao' => 'Norte - inscritos pagos']);
        }
        if ($request->tipo == 'centro_oeste') {
            $descricao = collect(['descricao' => 'Centro-Oeste - inscritos pagos']);
        }
        if ($request->tipo == 'nacional') {
            $descricao = collect(['descricao' => 'Nacional - inscritos pagos']);
        }

        $data['data'][0] = $count->merge($descricao);

        return response()->json($data);
    }

    public function submissao_expocom(Request $request)
    {
        if ($request->tipo == null || $request->tipo == 'sul') {
            $submissao_sul = SubmissaoExpocomRegionalSul::select('id')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => 'Submissao Sul ']);
        }

        if ($request->tipo == null || $request->tipo == 'norte') {
            $submissao_norte = SubmissaoExpocomRegionalNorte::select('id')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => 'Submissao Norte ']);
        }

        if ($request->tipo == null || $request->tipo == 'nordeste') {
            $submissao_nordeste = SubmissaoExpocomRegionalNordeste::select('id')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => 'Submissao Nordeste ']);
        }

        if ($request->tipo == null || $request->tipo == 'centro_oeste') {
            $submissao_centro_oeste = SubmissaoExpocomRegionalCentrooeste::select('id')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => 'Submissao Centro Oeste ']);
        }

        if ($request->tipo == null || $request->tipo == 'sudeste') {
            $submissao_sudeste = SubmissaoExpocomRegionalSudeste::select('id')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => 'Submissao Sudeste']);
        }

        if ($request->tipo == null) {
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => 'Total de Submissões']);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        } else {
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        }
    }

    public function submissao_dt(Request $request)
    {
        if ($request->tipo == null || $request->tipo == 'sul') {
            $submissao_sul = SubmissaoRegionalSul::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => 'Submissao Sul']);
        }

        if ($request->tipo == null || $request->tipo == 'norte') {
            $submissao_norte = SubmissaoRegionalNorte::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => 'Submissao Norte']);
        }

        if ($request->tipo == null || $request->tipo == 'nordeste') {
            $submissao_nordeste = SubmissaoRegionalNordestes::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => 'Submissao Nordeste']);
        }

        if ($request->tipo == null || $request->tipo == 'centro_oeste') {
            $submissao_centro_oeste = SubmissaoRegionalCentrooeste::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => 'Submissao Centro Oeste']);
        }

        if ($request->tipo == null || $request->tipo == 'sudeste') {
            $submissao_sudeste = SubmissaoRegionalSudeste::select('id', 'tipo')
            ->where('tipo', '=', 'Divisões Temáticas')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => 'Submissao Sudeste']);
        }

        if ($request->tipo == null) {
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => 'Total de Submissões']);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        } else {
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        }
    }

    public function submissao_ij(Request $request)
    {
        if ($request->tipo == null || $request->tipo == 'sul') {
            $submissao_sul = SubmissaoRegionalSul::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => 'Submissao Sul']);
        }

        if ($request->tipo == null || $request->tipo == 'norte') {
            $submissao_norte = SubmissaoRegionalNorte::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => 'Submissao Norte']);
        }

        if ($request->tipo == null || $request->tipo == 'nordeste') {
            $submissao_nordeste = SubmissaoRegionalNordestes::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => 'Submissao Nordeste']);
        }

        if ($request->tipo == null || $request->tipo == 'centro_oeste') {
            $submissao_centro_oeste = SubmissaoRegionalCentrooeste::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => 'Submissao Centro Oeste']);
        }

        if ($request->tipo == null || $request->tipo == 'sudeste') {
            $submissao_sudeste = SubmissaoRegionalSudeste::select('id', 'tipo')
            ->where('tipo', '=', 'Intercom Júnior')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => 'Submissao Sudeste']);
        }

        if ($request->tipo == null) {
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => 'Total de Submissões']);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        } else {
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        }
    }

    public function submissao_mesa(Request $request)
    {
        if ($request->tipo == null || $request->tipo == 'sul') {
            $submissao_sul = SubmissaoRegionalSul::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_sul;
            $descricao = collect(['descricao' => 'Submissao Sul']);
        }

        if ($request->tipo == null || $request->tipo == 'norte') {
            $submissao_norte = SubmissaoRegionalNorte::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_norte;
            $descricao = collect(['descricao' => 'Submissao Norte']);
        }

        if ($request->tipo == null || $request->tipo == 'nordeste') {
            $submissao_nordeste = SubmissaoRegionalNordestes::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_nordeste;
            $descricao = collect(['descricao' => 'Submissao Nordeste']);
        }

        if ($request->tipo == null || $request->tipo == 'centro_oeste') {
            $submissao_centro_oeste = SubmissaoRegionalCentrooeste::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_centro_oeste;
            $descricao = collect(['descricao' => 'Submissao Centro Oeste']);
        }

        if ($request->tipo == null || $request->tipo == 'sudeste') {
            $submissao_sudeste = SubmissaoRegionalSudeste::select('id', 'tipo')
            ->where('tipo', '=', 'Mesa')
            ->count();
            $submissoes = $submissao_sudeste;
            $descricao = collect(['descricao' => 'Submissao Sudeste']);
        }

        if ($request->tipo == null) {
            $count = collect(['contagem' => $submissao_sul + $submissao_norte + $submissao_nordeste + $submissao_centro_oeste + $submissao_sudeste]);
            $descricao = collect(['descricao' => 'Total de Submissões']);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        } else {
            $count = collect(['contagem' => $submissoes]);
            $data['data'][0] = $count->merge($descricao);

            return response()->json($data);
        }
    }

    public function inscritos_isentos(Request $request)
    {
        $users = User::select('id', 'name', 'cpf', 'email')
        ->with(
            'todos_tipos',
            'todos_tipos_pagamentos'
        )
        ->when($request->tipo, function ($query) use ($request) {
            if ($request->tipo == 0 || $request->tipo == null) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->whereIn('tipo_id', [6, 7, 8, 9, 10, 11]);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->whereIn('tipo_pagamento_id', [2, 5, 8, 11, 14, 17]);
                });
            }
            if ($request->tipo == 'sul') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 6);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 2);
                });
            }

            if ($request->tipo == 'nordeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 7);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 5);
                });
            }

            if ($request->tipo == 'sudeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 8);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 8);
                });
            }

            if ($request->tipo == 'centro_oeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 9);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 11);
                });
            }

            if ($request->tipo == 'norte') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 10);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 14);
                });
            }

            if ($request->tipo == 'nacional') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 11);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 17);
                });
            }
        })
        ->count();

        $count = collect(['contagem' => $users]);

        if ($request->tipo == null) {
            $descricao = collect(['descricao' => 'Total de inscritos isentos']);
        }
        if ($request->tipo == 'sul') {
            $descricao = collect(['descricao' => 'Sul - inscritos isentos']);
        }
        if ($request->tipo == 'sudeste') {
            $descricao = collect(['descricao' => 'Sudeste - inscritos isentos']);
        }
        if ($request->tipo == 'nordeste') {
            $descricao = collect(['descricao' => 'Nordeste - inscritos isentos']);
        }
        if ($request->tipo == 'norte') {
            $descricao = collect(['descricao' => 'Norte - inscritos isentos']);
        }
        if ($request->tipo == 'centro_oeste') {
            $descricao = collect(['descricao' => 'Centro-Oeste - inscritos isentos']);
        }
        if ($request->tipo == 'nacional') {
            $descricao = collect(['descricao' => 'Nacional - inscritos isentos']);
        }

        $data['data'][0] = $count->merge($descricao);

        return response()->json($data);
    }

    public function associados_inscritos(Request $request)
    {
        $users = User::select('id', 'name', 'cpf', 'email')
        ->with(
            'todos_tipos',
            'todos_tipos_pagamentos'
        )
        ->when($request->tipo, function ($query) use ($request) {
            if ($request->tipo == 0 || $request->tipo == null) {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->whereIn('tipo_id', [6, 7, 8, 9, 10, 11]);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->whereIn('tipo_pagamento_id', [3, 6, 9, 12, 15, 18]);
                });
            }
            if ($request->tipo == 'sul') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 6);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 3);
                });
            }

            if ($request->tipo == 'nordeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 7);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 6);
                });
            }

            if ($request->tipo == 'sudeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 8);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 9);
                });
            }

            if ($request->tipo == 'centro_oeste') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 9);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 12);
                });
            }

            if ($request->tipo == 'norte') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 10);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 15);
                });
            }

            if ($request->tipo == 'nacional') {
                $query->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', '=', 11);
                });
                $query->whereHas('todos_tipos_pagamentos', function ($query) {
                    $query->where('tipo_pagamento_id', '=', 18);
                });
            }
        })
        ->count();

        $count = collect(['contagem' => $users]);

        if ($request->tipo == null) {
            $descricao = collect(['descricao' => 'Total de associados isentos']);
        }
        if ($request->tipo == 'sul') {
            $descricao = collect(['descricao' => 'Sul - associados isentos']);
        }
        if ($request->tipo == 'sudeste') {
            $descricao = collect(['descricao' => 'Sudeste - associados isentos']);
        }
        if ($request->tipo == 'nordeste') {
            $descricao = collect(['descricao' => 'Nordeste - associados isentos']);
        }
        if ($request->tipo == 'norte') {
            $descricao = collect(['descricao' => 'Norte - associados isentos']);
        }
        if ($request->tipo == 'centro_oeste') {
            $descricao = collect(['descricao' => 'Centro-Oeste - associados isentos']);
        }
        if ($request->tipo == 'nacional') {
            $descricao = collect(['descricao' => 'Sem informação']);
        }

        $data['data'][0] = $count->merge($descricao);

        return response()->json($data);
    }
}
