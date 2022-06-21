<?php

namespace App\Http\Controllers;

use App\Models\Coordenador;
use App\Models\DistribuicaoTipo123;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\SubmissaoRegionalNorte;
use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\User;
use App\Services\CreateChatAvaliador;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DistribuicaoTipo123Controller extends Controller
{
    public function index()
    {
        return view('regionais.avaliacao.index');
    }

    public function submissoes_sul()
    {
        $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();

        if(!empty($coordenador) &&  $coordenador->tipo != "Expocom"){
            return SubmissaoRegionalSul::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
            ->with(
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj'
            );
        }
    }

    public function submissoes_sudeste()
    {
        $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();

        if(!empty($coordenador) &&  $coordenador->tipo != "Expocom"){
            return SubmissaoRegionalSudeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
            ->with(
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj'
            );
        }
    }

    public function submissoes_norte()
    {
        $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();

        if(!empty($coordenador) &&  $coordenador->tipo != "Expocom"){
            return SubmissaoRegionalNorte::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
            ->with(
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj'
            );
        }
    }

    public function submissoes_nordeste()
    {
        $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();

        if(!empty($coordenador) &&  $coordenador->tipo != "Expocom"){
            return SubmissaoRegionalNordestes::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
            ->with(
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj'
            );
        }
    }

    public function submissoes_centrooeste()
    {
        $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();

        if(!empty($coordenador) &&  $coordenador->tipo != "Expocom"){
            return SubmissaoRegionalCentrooeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
            ->with(
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj'
            );
        }
    }

    public function get(Request $request)
    {
        if(Auth::user() && Auth::user()->coordenador_regional){

            if(Auth::user()->coordenador_regional->geral == 0 || Auth::user()->coordenador_regional->geral == null){
   
                if(Auth::user()->coordenador_regional->regiao == "Sudeste"){
                    return $this->submissoes_sudeste()
                        ->when($request->statusAva, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_avaliador_1', '=', $request->statusAva)
                                ->orWhere('status_avaliador_2', "=", $request->statusAva)
                                ->orWhere('status_avaliador_3', "=", $request->statusAva);
                                });
                        })
                        ->when($request->statusCoo, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_coordenador', '=', $request->statusCoo);
                            });
                        })  
                        ->when($request->sort == 'id', function ($query) use ($request) {
                            $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'dt', function ($query) use ($request) {
                            $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->where('titulo', 'like', '%' . $request->search . '%');
                                });
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->where('dt', '=', $request->modalidade);
                        })
                    ->paginate(20);
                }

                if(Auth::user()->coordenador_regional->regiao == "Sul"){
                    return $this->submissoes_sul()
                        ->when($request->statusAva, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_avaliador_1', '=', $request->statusAva);
                            });
                        })
                        ->when($request->statusCoo, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_coordenador', '=', $request->statusCoo);
                            });
                        })  
                        ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                            $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'id', function ($query) use ($request) {
                            $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'dt', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->where('titulo', 'like', '%' . $request->search . '%');
                                });
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->where('dt', '=', $request->modalidade);
                        })
                    ->paginate(20);
                }

                if(Auth::user()->coordenador_regional->regiao == "Norte"){
                    return $this->submissoes_norte()
                        ->when($request->statusAva, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_avaliador_1', '=', $request->statusAva);
                            });
                        })
                        ->when($request->statusCoo, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_coordenador', '=', $request->statusCoo);
                            });
                        })  
                        ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                            $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'id', function ($query) use ($request) {
                            $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'dt', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->where('titulo', 'like', '%' . $request->search . '%');
                                });
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->where('dt', '=', $request->modalidade);
                        })
                    ->paginate(20);
                }

                if(Auth::user()->coordenador_regional->regiao == "Nordeste"){
                    return $this->submissoes_nordeste()
                        ->when($request->statusAva, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_avaliador_1', '=', $request->statusAva);
                            });
                        })
                        ->when($request->statusCoo, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_coordenador', '=', $request->statusCoo);
                            });
                        })  
                        ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                            $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'id', function ($query) use ($request) {
                            $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'dt', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->where('titulo', 'like', '%' . $request->search . '%');
                                });
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->where('dt', '=', $request->modalidade);
                        })
                    ->paginate(20);
                }

                if(Auth::user()->coordenador_regional->regiao == "Centro-Oeste"){
                    return $this->submissoes_centrooeste()
                        ->when($request->statusAva, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_avaliador_1', '=', $request->statusAva);
                            });
                        })
                        ->when($request->statusCoo, function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->where('status_coordenador', '=', $request->statusCoo);
                            });
                        })  
                        ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                            $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'id', function ($query) use ($request) {
                            $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->when($request->sort == 'dt', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->sort == 'titulo', function ($query) use ($request) {
                            $query->whereHas('avaliacao', function($q) use ($request) {
                                $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                            });
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->where('titulo', 'like', '%' . $request->search . '%');
                                });
                            });
                        })

                        ->when($request->modalidade, function ($query) use ($request){
                            $query->where('dt', '=', $request->modalidade);
                        })
                    ->paginate(20);
                }
            }

            if(Auth::user()->coordenador_regional->geral == 1){

                $submissoes_sudeste = $this->submissoes_sudeste()
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_avaliador_1', '=', $request->statusAva)
                            ->orWhere('status_avaliador_2', "=", $request->statusAva)
                            ->orWhere('status_avaliador_3', "=", $request->statusAva);
                            });
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });
                    })  
                    ->when($request->sort == 'id', function ($query) use ($request) {
                        $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'dt', function ($query) use ($request) {
                        $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('titulo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->where('dt', '=', $request->modalidade);
                    })
                ->get();


                $submissoes_sul = $this->submissoes_sul()
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_avaliador_1', '=', $request->statusAva);
                        });
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });
                    })  
                    ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                        $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'id', function ($query) use ($request) {
                        $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'dt', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'titulo', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('titulo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->where('dt', '=', $request->modalidade);
                    })
                ->get();

                $submissoes_norte = $this->submissoes_norte()
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_avaliador_1', '=', $request->statusAva);
                        });
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });
                    })  
                    ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                        $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'id', function ($query) use ($request) {
                        $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'dt', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'titulo', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->where('dt', '=', $request->modalidade);
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('titulo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                ->get();

                $submissoes_nordeste = $this->submissoes_nordeste()
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_avaliador_1', '=', $request->statusAva);
                        });
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });
                    })  
                    ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                        $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'id', function ($query) use ($request) {
                        $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'dt', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'titulo', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->where('dt', '=', $request->modalidade);
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('titulo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                ->get();

                $submissoes_centrooeste = $this->submissoes_centrooeste()
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_avaliador_1', '=', $request->statusAva);
                        });
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });
                    })  
                    ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                        $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'id', function ($query) use ($request) {
                        $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })
                    ->when($request->sort == 'dt', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->sort == 'titulo', function ($query) use ($request) {
                        $query->whereHas('avaliacao', function($q) use ($request) {
                            $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->where('dt', '=', $request->modalidade);
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('titulo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                ->get();
                
                $submissao = $submissoes_sudeste->merge($submissoes_sul)->merge($submissoes_norte)->merge($submissoes_nordeste)->merge($submissoes_centrooeste);

                $data['data'] = $submissao;

                return response()->json($data);
            }
        }
    }

    //INDICACÃO DE AVALIADORES PARA AVALIAR SUBMISSÃO
    public function store(Request $request)
    {
        try{
            $post = $request->all();

            $distribuicao = DistribuicaoTipo123::create([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'status_avaliador_1' => $post['status_avaliador_1'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'status_avaliador_2' => $post['status_avaliador_2'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
                'status_avaliador_3' => $post['status_avaliador_3'] ?? null,
                'status_coordenador' => "Em Análise"
            ]);

            if($post['regiao'] == 1){
                $submissao = SubmissaoRegionalSul::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 2){
                $submissao = SubmissaoRegionalNordestes::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 3){
                $submissao = SubmissaoRegionalSudeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 4){
                $submissao = SubmissaoRegionalCentrooeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 5){
                $submissao = SubmissaoRegionalNorte::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            //Enviar e-mail informando que foi selecionado como Avaliador
            try {

                if(!empty($post['avaliador_1']) && $post['avaliador_1']['id']){

                    $avaliador_1 = User::findOrFail($post['avaliador_1']['id']);
                }

                if(!empty($post['avaliador_2']) && $post['avaliador_2']['id']){

                    $avaliador_2 = User::findOrFail($post['avaliador_2']['id']);
                }

                if(!empty($post['avaliador_3']) && $post['avaliador_3']['id']){

                    $avaliador_3 = User::findOrFail($post['avaliador_3']['id']);
                }

                $dados['post'] = $post;
                $dados['submissao'] = $submissao;

                if(isset($avaliador_1) && $avaliador_1->email){

                    $dados['avaliador_1'] = $avaliador_1;

                    $emails = [
                        $dados['avaliador_1']->email,
                    ];
    
                    Mail::send('email.indicacao_avaliador', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Indicação de Avaliador | Intercom');
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails) . ' | Dados: ' . json_encode($dados));
                    });

                    unset($dados['avaliador_1']);
                }

                if(isset($avaliador_2) && $avaliador_2->email){

                    $dados['avaliador_2'] = $avaliador_2;

                    $emails = [
                        $dados['avaliador_2']->email,
                    ];
    
                    Mail::send('email.indicacao_avaliador', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Indicação de Avaliador | Intercom');
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails)  . ' | Dados: ' . json_encode($dados));
                    });

                    unset($dados['avaliador_2']);
                }

                if(isset($avaliador_3) && $avaliador_3->email){

                    $dados['avaliador_3'] = $avaliador_3;

                    $emails = [
                        $dados['avaliador_3']->email,
                    ];
    
                    Mail::send('email.indicacao_avaliador', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Indicação de Avaliador | Intercom');
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails). ' | Dados: ' . json_encode($dados));
                    });

                    unset($dados['avaliador_3']);
                }
    
            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            }

            Log::info('Distribuicao de trabalho  create: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);
    
        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        $distribuicao = DistribuicaoTipo123::findOrFail($request->id);
        
        try{
            $post = $request->all();

            $distribuicao->update([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'status_avaliador_1' => $post['status_avaliador_1'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'status_avaliador_2' => $post['status_avaliador_2'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
                'status_avaliador_3' => $post['status_avaliador_3'] ?? null,
            ]);

            Log::info('Distribuicao de trabalho updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
    
    public function avaliadorSave(Request $request)
    {
        
        $distribuicao = DistribuicaoTipo123::findOrFail($request->id);

        try{
            $post = $request->all();

            if($distribuicao->avaliador_1 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_1' => $post['status_avaliador'],
                    'justificativa_avaliador_1' => $post['justificativa_avaliador'] ?? null,
                ]);

                $chat = CreateChatAvaliador::create(
                    $distribuicao->id,
                    $distribuicao->avaliador_1,
                    null,
                    $post['justificativa_avaliador'] ?? null, 
                    1
                );

                $updated = 1;
            }

            if($distribuicao->avaliador_2 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_2' => $post['status_avaliador'],
                    'justificativa_avaliador_2' => $post['justificativa_avaliador'] ?? null,
                ]);

                $chat = CreateChatAvaliador::create(
                    $distribuicao->id,
                    $distribuicao->avaliador_2,
                    null,
                    $post['justificativa_avaliador'] ?? null, 
                    2
                );

                $updated = 2;

            }

            if($distribuicao->avaliador_3 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_3' => $post['status_avaliador'],
                    'justificativa_avaliador_3' => $post['justificativa_avaliador'] ?? null,
                ]);

                $chat = CreateChatAvaliador::create(
                    $distribuicao->id,
                    $distribuicao->avaliador_3,
                    null,
                    $post['justificativa_avaliador'] ?? null, 
                    3
                );

                $updated = 3;
            }

            Log::info('Distribuicao de trabalho status e justificativa avaliador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));


            //Enviar e-mail informando ao coordenador que o status foi alterado
            try {

                if($post['regiao'] == 1){
                    $regiao = 'Sul';

                    $submissao = SubmissaoRegionalSul::select('id', 'avaliacao', 'tipo', 'titulo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 2){
                    $regiao = 'Nordeste';

                    $submissao = SubmissaoRegionalNordestes::select('id', 'avaliacao', 'tipo', 'titulo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 3){
                    $regiao = 'Sudeste';

                    $submissao = SubmissaoRegionalSudeste::select('id', 'avaliacao', 'tipo', 'titulo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 4){
                    $regiao = 'Centro-Oeste';

                    $submissao = SubmissaoRegionalCentroOeste::select('id', 'avaliacao', 'tipo', 'titulo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 5){
                    $regiao = 'Norte';

                    $submissao = SubmissaoRegionalNorte::select('id', 'avaliacao', 'tipo', 'titulo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
         
                $coordenadores = Coordenador::where([
                    ['tipo', '<>', 'Expocom'],
                    ['regiao', '=', $regiao],
                    ])->get();

                $dados['status_avaliador'] = $post['status_avaliador'];
                $dados['justificativa_avaliador'] = $post['justificativa_avaliador'];

                if(!empty($updated) && $updated = 1){
                    $dados['avaliador'] = User::findOrFail($distribuicao->avaliador_1);
                }

                if(!empty($updated) && $updated = 2){
                    $dados['avaliador'] = User::findOrFail($distribuicao->avaliador_2);
                }

                if(!empty($updated) && $updated = 3){
                    $dados['avaliador'] = User::findOrFail($distribuicao->avaliador_3);
                }

                if(!empty($submissao)){
                    $dados['submissao'] = $submissao;
                }
                $emails = [];
                foreach ($coordenadores as $coordenador) {
                    $emails[] = User::findOrFail($coordenador->user_id)->email;
                }
    
                Mail::send('email.avaliacao_avaliador', $dados, function ($email) use ($emails, $dados) {
                    if (App::environment('production')) {
                        $email->to($emails);
                    } else {
                        $email->to('murilo@kirc.com.br');
                    }
                        $email->subject('Indicação de Avaliador | Intercom');
                    Log::info('E-mail Enviado para o usuario informando que o status foi alterado | E-mail:' . json_encode($emails) . ' | Dados: ' . json_encode($dados));
                });
    
            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            }

            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function coordenadorSave(Request $request)
    {
        $distribuicao = DistribuicaoTipo123::select('id', 'status_coordenador', 'justificativa_coordenador')
        ->with(
            'submissaoNordeste',
            'submissaoNordeste.inscricao',
            'submissaoNordeste.inscricao.user',
            'submissaoNordeste.inscricao.user',

            'submissaoSul',
            'submissaoSul.inscricao',
            'submissaoSul.inscricao.user',
            'submissaoSul.inscricao.user',

            'submissaoSudeste',
            'submissaoSudeste.inscricao',
            'submissaoSudeste.inscricao.user',
            'submissaoSudeste.inscricao.user',

            'submissaoCentroOeste',
            'submissaoCentroOeste.inscricao',
            'submissaoCentroOeste.inscricao.user',
            'submissaoCentroOeste.inscricao.user',

            'submissaoNorte',
            'submissaoNorte.inscricao',
            'submissaoNorte.inscricao.user',
            'submissaoNorte.inscricao.user'
        )        
        ->find($request->id);
        
        if($distribuicao && $distribuicao->submissaoNordeste){
            $submissao = $distribuicao->submissaoNordeste;

        }

        if($distribuicao && $distribuicao->submissaoSul){
            $submissao = $distribuicao->submissaoSul;
        }

        if($distribuicao && $distribuicao->submissaoSudeste){
            $submissao = $distribuicao->submissaoSudeste;
        }

        if($distribuicao && $distribuicao->submissaoCentroOeste){
            $submissao = $distribuicao->submissaoCentroOeste;
        }

        if($distribuicao && $distribuicao->submissaoNorte){
            $submissao = $distribuicao->submissaoNorte;
        }

        try{
            $post = $request->all();

            if($post['status_coordenador'] == "Alteração solicitada"){
                $distribuicao->update([
                    'status_coordenador' => $post['status_coordenador'],
                    "justificativa_coordenador" => $post['justificativa_coordenador'] ?? null,
                    "edit" => 1
                ]);    
            }else{
                $distribuicao->update([
                    'status_coordenador' => $post['status_coordenador'],
                    "justificativa_coordenador" => $post['justificativa_coordenador'] ?? null,
                ]);
            }


            Log::info('Avaliacao Tipo DT | Status e Sustificativa Coordenador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));

            //Enviar e-mail informando ao autor que o status do seu trabalho foi alterado
            try {

                $dados['status_coordenador'] = $post['status_coordenador'];

                $dados['justificativa_coordenador'] = $post['justificativa_coordenador'];

                if($submissao && $submissao->inscricao && $submissao->inscricao->user){
                    $dados['titulo'] = $submissao->titulo;
                    $dados['user'] = $submissao->inscricao->user;
                    $emails = $submissao->inscricao->user->email;
                }
    
                Mail::send('email.avaliacao_coordenador', $dados, function ($email) use ($emails) {
                    if (App::environment('production')) {
                        $email->to($emails);
                    } else {
                        $email->to('murilo@kirc.com.br');
                    }
                        $email->subject('Status do trabalho | Intercom');
                    Log::info('E-mail Enviado para o autor do trabalho com a informação do status | Email: ' . $emails);
                });
    
            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            }
            
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
