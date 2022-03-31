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
use App\Services\CreateChatAvaliacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            return SubmissaoRegionalSul::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho')
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
            return SubmissaoRegionalSudeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho')
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
            return SubmissaoRegionalNorte::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho')
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
            return SubmissaoRegionalNordestes::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho')
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
            return SubmissaoRegionalCentrooeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho')
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
            if(Auth::user()->coordenador_regional->regiao == "Sudeste"){
                return $this->submissoes_sudeste()
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
                        $query->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
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
                ->when($request->sort == 'titulo', function ($query) use ($request) {
                    $query->whereHas('avaliacao', function($q) use ($request) {
                        $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                    });
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
                ->when($request->sort == 'titulo', function ($query) use ($request) {
                    $query->whereHas('avaliacao', function($q) use ($request) {
                        $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                    });
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
                ->when($request->sort == 'titulo', function ($query) use ($request) {
                    $query->whereHas('avaliacao', function($q) use ($request) {
                        $q->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
                    });
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
                ->paginate(20);
            }
        }
    }

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
                'status_coordenador' => "Em Espera"
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

                $chat = CreateChatAvaliacao::create(
                    $distribuicao->id,
                    null,
                    $distribuicao->avaliador_1,
                    null,
                    $post['justificativa_avaliador']);
            }

            if($distribuicao->avaliador_2 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_2' => $post['status_avaliador'],
                    'justificativa_avaliador_2' => $post['justificativa_avaliador'] ?? null,
                ]);

                $chat = CreateChatAvaliacao::create(
                    $distribuicao->id,
                    null,
                    $distribuicao->avaliador_2,
                    null,
                    $post['justificativa_avaliador']);

            }

            if($distribuicao->avaliador_3 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_3' => $post['status_avaliador'],
                    'justificativa_avaliador_3' => $post['justificativa_avaliador'] ?? null,
                ]);

                $chat = CreateChatAvaliacao::create(
                    $distribuicao->id,
                    null,
                    $distribuicao->avaliador_3,
                    null,
                    $post['justificativa_avaliador']);
            }
            Log::info('Distribuicao de trabalho status e justificativa avaliador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function coordenadorSave(Request $request)
    {
        $distribuicao = DistribuicaoTipo123::findOrFail($request->id);
        
        try{
            $post = $request->all();

            $distribuicao->update([
                'status_coordenador' => $post['status_coordenador'],
                "justificativa_coordenador" =>$post['justificativa_coordenador'] ?? null
            ]);

            Log::info('Distribuicao de trabalho status e justificativa coordenador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

}
