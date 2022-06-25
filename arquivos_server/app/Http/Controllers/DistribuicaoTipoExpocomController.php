<?php

namespace App\Http\Controllers;

use App\Models\Coordenador;
use App\Models\DistribuicaoTipoExpocom;
use App\Models\DivisoesTematicas;
use App\Models\SubmissaoExpocomRegionalSul;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\SubmissaoExpocomRegionalNorte;
use App\Models\SubmissaoExpocomRegionalCentrooeste;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Models\User;
use App\Services\CreateChatAvaliacaoExpocom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DistribuicaoTipoExpocomController extends Controller
{
    public function index()
    {
        return view('regionais.avaliacaoExpocom.index');
    }

    public function view($regiao){
        $regiao = $regiao;

        return view('regionais.avaliacaoExpocom.index', compact('regiao'));
    }

    public function submissao_sul(){
        return SubmissaoExpocomRegionalSul::select(
            'id',
            'inscricao_id',
            'avaliacao',
            'regiao',
            'ciente',
            'ano',
            'campus',
            'desc_obj_estudo',
            'desc_pesquisa',
            'desc_producao',
            'termo_autoria',
            'autorizacao',
            'link_trabalho',
            )
            ->with(
               'inscricao',
               'inscricao.user:id,cpf',
               'inscricao.user.indicacao',
               'avaliacao',
               'avaliacao.avaliador_1_obj',
               'avaliacao.avaliador_2_obj',
               'avaliacao.avaliador_3_obj',
               'coautorOrientadorSubSuls'
            );
    }

    public function submissao_sudeste(){
        return SubmissaoExpocomRegionalSudeste::select(
            'id',
            'inscricao_id',
            'avaliacao',
            'regiao',
            'ciente',
            'ano',
            'campus',
            'desc_obj_estudo',
            'desc_pesquisa',
            'desc_producao',
            'termo_autoria',
            'autorizacao',
            'link_trabalho',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf',
                'inscricao.user.indicacao',
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj',
                'coautorOrientadorSubSudeste'
             );
    }

    public function submissao_norte(){
        return SubmissaoExpocomRegionalNorte::select(
            'id',
            'inscricao_id',
            'avaliacao',
            'regiao',
            'ciente',
            'ano',
            'campus',
            'desc_obj_estudo',
            'desc_pesquisa',
            'desc_producao',
            'termo_autoria',
            'autorizacao',
            'link_trabalho',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf',
                'inscricao.user.indicacao',
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj',
                'coautorOrientadorSubNortes'
             );
    }

    public function submissao_nordeste(){
        return SubmissaoExpocomRegionalNordeste::select(
            'id',
            'inscricao_id',
            'avaliacao',
            'regiao',
            'ciente',
            'ano',
            'campus',
            'desc_obj_estudo',
            'desc_pesquisa',
            'desc_producao',
            'termo_autoria',
            'autorizacao',
            'link_trabalho',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf',
                'inscricao.user.indicacao',
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj',
                'coautorOrientadorSubNordeste'
             );
    }

    public function submissao_centrooeste(){
        return SubmissaoExpocomRegionalCentrooeste::select(
            'id',
            'inscricao_id',
            'avaliacao',
            'regiao',
            'ciente',
            'ano',
            'campus',
            'desc_obj_estudo',
            'desc_pesquisa',
            'desc_producao',
            'termo_autoria',
            'autorizacao',
            'link_trabalho',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf',
                'inscricao.user.indicacao',
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj',
                'coautorOrientadorSubCentrooeste'
             );
    }

    public function get(Request $request)
    {
        if(Auth::user() && Auth::user()->coordenador_regional){

            if(Auth::user()->coordenador_regional->geral == 0 || Auth::user()->coordenador_regional->geral == null){

                $dt = Auth::user()->coordenador_regional->dt ?? 1;

                if($request && $request->regiao && $request->regiao == 1){
                                    
                    return $this->submissao_sul()
                        ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                            $query->where('categoria', $dt);
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 3){

                    return $this->submissao_sudeste()
                        ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                            $query->where('categoria', $dt);
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 5){

                    return $this->submissao_norte()
                        ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                            $query->where('categoria', $dt);
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 2){

                    return $this->submissao_nordeste()
                        ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                            $query->where('categoria', $dt);
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 4){

                    return $this->submissao_centrooeste()
                        ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                            $query->where('categoria', $dt);
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }
            }

            if(Auth::user()->coordenador_regional->geral == 1){
                   
                if($request && $request->regiao && $request->regiao == 1){
                                    
                    return $this->submissao_sul()
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 3){

                    return $this->submissao_sudeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                    $q->whereHas('user', function ($q) use ($request){
                                        $q->whereHas('indicacao', function ($q) use ($request){
                                            $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                        });
                                    });        
                                });
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 5){

                    return $this->submissao_norte()
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->where('desc_obj_estudo', 'like', '%' . $request->search . '%');
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 2){                  
                    return $this->submissao_nordeste()
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->when($request->type == 'titulo', function ($query) use ($request) {
                                    $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                        $q->whereHas('user', function ($q) use ($request){
                                            $q->whereHas('indicacao', function ($q) use ($request){
                                                $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                            });
                                        });        
                                    });
                                });
                            });
                        })
                        ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                    ->paginate(10);
                }

                if($request && $request->regiao && $request->regiao == 4){

                    return $this->submissao_centrooeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                    $q->whereHas('user', function ($q) use ($request){
                                        $q->whereHas('indicacao', function ($q) use ($request){
                                            $q->where('titulo_trabalho', 'like', '%' . $request->search . '%');
                                        });
                                    });        
                                });
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('categoria', '=', $request->categoria);
                            });
                        })
                        ->when($request->modalidade, function ($query) use ($request){
                            $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                                $q->where('modalidade', '=', $request->modalidade);
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'desc');
                        })
                    ->paginate(10);
                }
            }

        }
    }

    public function store(Request $request)
    {
        try{
            $post = $request->all();

            $distribuicao = DistribuicaoTipoExpocom::create([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'status_avaliador_1' => $post['status_avaliador_1'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'status_avaliador_2' => $post['status_avaliador_2'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
                'status_avaliador_3' => $post['status_avaliador_3'] ?? null,
                'status_coordenador' => "Em Análise"
            ]);

            if($post['regiao'] == 1){
                $submissao = SubmissaoExpocomRegionalSul::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 2){
                $submissao = SubmissaoExpocomRegionalNordeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 3){
                $submissao = SubmissaoExpocomRegionalSudeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 4){
                $submissao = SubmissaoExpocomRegionalCentrooeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 5){
                $submissao = SubmissaoExpocomRegionalNorte::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            Log::info('Distribuicao de trabalho  create: '.$distribuicao->id.' | Request: '.json_encode($request->all()));

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
                $dados['submissao']['titulo'] = substr($submissao->desc_obj_estudo, 0, 100);

                if(isset($avaliador_1) && $avaliador_1->email){

                    $dados['avaliador_1'] = $avaliador_1;

                    $emails = [
                        $dados['avaliador_1']->email,
                    ];
    
                    Mail::send('email.indicacao_avaliador_expocom', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Indicação de Avaliador | Intercom');
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails). ' | Dados: ' . json_encode($dados));
                    });

                }

                if(isset($avaliador_2) && $avaliador_2->email){

                    $dados['avaliador_2'] = $avaliador_2;

                    $emails = [
                        $dados['avaliador_2']->email,
                    ];
    
                    Mail::send('email.indicacao_avaliador_expocom', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Indicação de Avaliador | Intercom');
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails) . ' | Dados: ' . json_encode($dados));
                    });

                }

                if(isset($avaliador_3) && $avaliador_3->email){

                    $dados['avaliador_3'] = $avaliador_3;

                    $emails = [
                        $dados['avaliador_3']->email,
                    ];
    
                    Mail::send('email.indicacao_avaliador_expocom', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Indicação de Avaliador | Intercom');
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails). ' | Dados: ' . json_encode($dados));
                    });

                }
    
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

    public function update(Request $request)
    {
        $distribuicao = DistribuicaoTipoExpocom::findOrFail($request->id);
        
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
        $distribuicao = DistribuicaoTipoExpocom::findOrFail($request->id);

        try{
            $post = $request->all();

            if($distribuicao->avaliador_1 == Auth::user()->id){
                $distribuicao->update([
                    'justificativa_avaliador_1' => $post['justificativa_avaliador'] ?? null,
                    'expe_1' => $post['expe'] ?? null,
                    'qualidade_1' => $post['qualidade'] ?? null,
                    'coerencia_1' => $post['coerencia'] ?? null,
                    'media_1' => $post['media'] ?? null,
                    'status_avaliador_1' => "Avaliado"
                ]);

                if($post['justificativa_avaliador'] != null){
                    $chat = CreateChatAvaliacaoExpocom::create($distribuicao->id,$distribuicao->avaliador_1,null,$post['justificativa_avaliador'] ?? null, 1);
                }

                $updated = 1;
            }

            if($distribuicao->avaliador_2 == Auth::user()->id){
                $distribuicao->update([
                    'justificativa_avaliador_2' => $post['justificativa_avaliador'] ?? null,
                    'expe_2' => $post['expe'] ?? null,
                    'qualidade_2' => $post['qualidade'] ?? null,
                    'coerencia_2' => $post['coerencia'] ?? null,
                    'media_2' => $post['media'] ?? null,
                    'status_avaliador_2' => "Avaliado"
                ]);

                if($post['justificativa_avaliador'] != null){

                    $chat = CreateChatAvaliacaoExpocom::create(
                        $distribuicao->id,
                        $distribuicao->avaliador_2,
                        null,
                        $post['justificativa_avaliador'] ?? null, 2);
                }

                $updated = 2;
            }

            if($distribuicao->avaliador_3 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_3' => $post['status_avaliador'],
                    'justificativa_avaliador_3' => $post['justificativa_avaliador'] ?? null,
                    'expe_3' => $post['expe'] ?? null,
                    'qualidade_3' => $post['qualidade'] ?? null,
                    'coerencia_3' => $post['coerencia'] ?? null,
                    'media_3' => $post['media'] ?? null,
                    'status_avaliador_3' => "Avaliado"
                ]);

                if($post['justificativa_avaliador'] != null){

                    $chat = CreateChatAvaliacaoExpocom::create(
                        $distribuicao->id,
                        $distribuicao->avaliador_3,
                        null,
                        $post['justificativa_avaliador'] ?? null, 
                        3
                    );
                }

                $updated = 3;
            }

            if($distribuicao->media_1 != null && $distribuicao->media_2 != null && $distribuicao->media_3 != null){

                $soma_media = $distribuicao->media_1 + $distribuicao->media_2 + $distribuicao->media_3;

                $media_final = $soma_media / 3;

            } else if (
                $distribuicao->media_1 != null && $distribuicao->media_2 != null && $distribuicao->media_3 == null
            ){
                $soma_media = $distribuicao->media_1  + $distribuicao->media_2;

                $media_final = $soma_media / 2;
            } else if (
                $distribuicao->media_1 != null && $distribuicao->media_2 == null && $distribuicao->media_3 != null
            ){
                $soma_media = $distribuicao->media_1  + $distribuicao->media_3;

                $media_final = $soma_media / 2;
            } else if (
                $distribuicao->media_1 == null && $distribuicao->media_2 != null && $distribuicao->media_3 != null
            ){
                $soma_media = $distribuicao->media_2  + $distribuicao->media_3;

                $media_final = $soma_media / 2;
            }else if (
                $distribuicao->media_1 == null && $distribuicao->media_2 == null && $distribuicao->media_3 != null
            ){
                $media_final = $distribuicao->media_3;
            }else if (
                $distribuicao->media_1 == null && $distribuicao->media_2 != null && $distribuicao->media_3 == null
            ){
                $media_final = $distribuicao->media_2;
            }else if (
                $distribuicao->media_1 != null && $distribuicao->media_2 == null && $distribuicao->media_3 == null
            ){
                $media_final = $distribuicao->media_1;
            }

            if($media_final != null){
                $distribuicao->update([
                    'media_final' => $media_final,
                ]);
            }                

            Log::info('Distribuicao de trabalho Tipo Expocom status e justificativa avaliador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));


            //Enviar e-mail informando ao coordenador que o status foi alterado
            try {

                if($post['regiao'] == 1){
                    $regiao = 'Sul';

                    $submissao = SubmissaoExpocomRegionalSul::select('id', 'avaliacao','desc_obj_estudo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 2){
                    $regiao = 'Nordeste';

                    $submissao = SubmissaoExpocomRegionalNordeste::select('id', 'avaliacao','desc_obj_estudo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 3){
                    $regiao = 'Sudeste';

                    $submissao = SubmissaoExpocomRegionalSudeste::select('id', 'avaliacao','desc_obj_estudo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 4){
                    $regiao = 'Centro-Oeste';

                    $submissao = SubmissaoExpocomRegionalCentrooeste::select('id', 'avaliacao','desc_obj_estudo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
                if($post['regiao'] == 5){
                    $regiao = 'Norte';

                    $submissao = SubmissaoExpocomRegionalNorte::select('id', 'avaliacao','desc_obj_estudo')
                        ->where('avaliacao', '=', $distribuicao->id)
                        ->first();
                }
            
                $coordenadores = Coordenador::where([
                    ['tipo', '=', 'Expocom'],
                    ['dt', '=', $post['dt'] ?? null],
                    ])->get();

                $dados['status_avaliador'] = "Avaliado";
                $dados['justificativa_avaliador'] = $post['justificativa_avaliador'];

                if(!empty($updated) && $updated == 1){
                    $dados['avaliador'] = User::findOrFail($distribuicao->avaliador_1);
                }

                if(!empty($updated) && $updated == 2){
                    $dados['avaliador'] = User::findOrFail($distribuicao->avaliador_2);
                }

                if(!empty($updated) && $updated == 3){
                    $dados['avaliador'] = User::findOrFail($distribuicao->avaliador_3);
                }

                if(!empty($submissao)){
                    $dados['submissao']['titulo'] = substr($submissao->desc_obj_estudo, 0, 100);
                    $dados['submissao']['tipo'] = "Expocom";
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
                    Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao' . json_encode($emails). ' | Dados: ' . json_encode($dados));
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
        $distribuicao = DistribuicaoTipoExpocom::select('id', 'status_coordenador', 'justificativa_coordenador')
        ->with(
            'submissaoExpocomNordeste',
            'submissaoExpocomNordeste.inscricao',
            'submissaoExpocomNordeste.inscricao.user',
            'submissaoExpocomNordeste.inscricao.user.indicacao',

            'submissaoExpocomSul',
            'submissaoExpocomSul.inscricao',
            'submissaoExpocomSul.inscricao.user',
            'submissaoExpocomSul.inscricao.user.indicacao',

            'submissaoExpocomSudeste',
            'submissaoExpocomSudeste.inscricao',
            'submissaoExpocomSudeste.inscricao.user',
            'submissaoExpocomSudeste.inscricao.user.indicacao',

            'submissaoExpocomCentrooeste',
            'submissaoExpocomCentrooeste.inscricao',
            'submissaoExpocomCentrooeste.inscricao.user',
            'submissaoExpocomCentrooeste.inscricao.user.indicacao',

            'submissaoExpocomNorte',
            'submissaoExpocomNorte.inscricao',
            'submissaoExpocomNorte.inscricao.user',
            'submissaoExpocomNorte.inscricao.user.indicacao'
        )
        ->find($request->id);
        
        if($distribuicao && $distribuicao->submissaoExpocomNordeste){
            $submissao = $distribuicao->submissaoExpocomNordeste;

        }

        if($distribuicao && $distribuicao->submissaoExpocomSul){
            $submissao = $distribuicao->submissaoExpocomSul;
        }

        if($distribuicao && $distribuicao->submissaoExpocomSudeste){
            $submissao = $distribuicao->submissaoExpocomSudeste;
        }

        if($distribuicao && $distribuicao->submissaoExpocomCentrooeste){
            $submissao = $distribuicao->submissaoExpocomCentrooeste;
        }

        if($distribuicao && $distribuicao->submissaoExpocomNorte){
            $submissao = $distribuicao->submissaoExpocomNorte;
        }

        try{
            $post = $request->all();

            $distribuicao->update([
                'status_coordenador' => $post['status_coordenador'],
                "justificativa_coordenador" => $post['justificativa_coordenador'] ?? null
            ]);

            Log::info('Distribuicao de trabalho status e justificativa coordenador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));

            //Enviar e-mail informando ao autor que o status do seu trabalho foi alterado
            try {

                $dados['status_coordenador'] = $post['status_coordenador'];

                $dados['justificativa_coordenador'] = $post['justificativa_coordenador'];

                if($submissao && $submissao->inscricao && $submissao->inscricao->user){
                    $dados['user'] = $submissao->inscricao->user;
                    $emails = $submissao->inscricao->user->email;
                }
    
                Mail::send('email.avaliacao_coordenador_expocom', $dados, function ($email) use ($emails) {
                    if (App::environment('production')) {
                        $email->to($emails);
                    } else {
                        $email->to('murilo@kirc.com.br');
                    }
                    $email->subject('Status do trabalho | Intercom');

                    Log::info('E-mail Enviado para o autor do trabalho com a informação do status Expocom | Email: ' . $emails);
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
