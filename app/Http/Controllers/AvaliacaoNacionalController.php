<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoNacional;
use App\Models\CoordenadorNacional;
use App\Models\SubmissaoNacional;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AvaliacaoNacionalController extends Controller
{
    public function index()
    {
        return view('nacional.avaliacao.index');
    }

    public function submissao()
    {
        $tipo_coordenador = Auth::user()->is_coordenador_nacional_2022;

        if($tipo_coordenador != false){
            return SubmissaoNacional::select('id', 'inscricao_id', 'avaliacao', 'dt', 'titulo', 'link_trabalho', 'tipo')
            ->with(
                'avaliacao',
                'avaliacao.avaliador_1',
                'avaliacao.avaliador_2',
                'avaliacao.avaliador_3'
            );
        }
    }

    public function get(Request $request)
    {
        $tipo_coordenador = Auth::user()->is_coordenador_nacional_2022;
        $coordenador = CoordenadorNacional::findOrFail(Auth::user()->id);

        if (Auth::user() && Auth::user()->is_coordenador_nacional_2022 != false && $coordenador && $coordenador != null) {
            return $this->submissao()
                ->when($request->sort == 'id', function ($query) use ($request) {
                    $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->sort == 'dt', function ($query) use ($request) {
                    $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->when($request->type == 'titulo', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%'.$request->search.'%');
                        });
                    });
                })
                ->when($request->modalidade, function ($query) use ($request) {
                    $query->where('dt', $request->modalidade);
                })
                ->when($tipo_coordenador == 'coordenador_gp', function ($query) use ($coordenador) {
                    $query->where('tipo', 'Grupo de Pesquisa');
                    $query->where('dt', $coordenador->gp);
                })
                ->when($tipo_coordenador == 'coordenador_ij', function ($query) use ($coordenador) {
                    $query->where('tipo', 'Intercom Júnior');
                    $query->where('dt', $coordenador->ij);
                })
                ->when($tipo_coordenador == 'coordenador_expocom', function ($query) use ($request) {
                    $query->where('tipo', 'Publicom');
                })
            ->paginate(20);
        }
    }

    //INDICACÃO DE AVALIADORES PARA AVALIAR SUBMISSÃO
    public function store(Request $request)
    {
        try {
            $post = $request->all();

            $avaliacao_create = AvaliacaoNacional::create([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
                'status_coordenador' => 'Em Análise',
            ]);

            if($avaliacao_create && $avaliacao_create != null){
                $submissao = SubmissaoNacional::findOrFail($post['submissao_id']);
                if($submissao && $submissao != null){
                    $submissao->update(['avaliacao' => $avaliacao_create->id,]);
                }else{
                    return response()->json(['message' => 'The given data was invalid', 'response' => $request->all(), 'status' => 422], 422);
                }
            }else{
                return response()->json(['message' => 'The given data was invalid', 'response' => $request->all(), 'status' => 422], 422);
            }

            try {
                if (! empty($post['avaliador_1']) && $post['avaliador_1']['id']) {
                    $avaliador_1 = User::findOrFail($post['avaliador_1']['id']);
                }

                if (! empty($post['avaliador_2']) && $post['avaliador_2']['id']) {
                    $avaliador_2 = User::findOrFail($post['avaliador_2']['id']);
                }

                if (! empty($post['avaliador_3']) && $post['avaliador_3']['id']) {
                    $avaliador_3 = User::findOrFail($post['avaliador_3']['id']);
                }

                $dados['post'] = $post;
                $dados['submissao'] = $submissao;

                if (isset($avaliador_1) && $avaliador_1->email) {
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
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao'.json_encode($emails).' | Dados: '.json_encode($dados));
                    });

                    unset($dados['avaliador_1']);
                }

                if (isset($avaliador_2) && $avaliador_2->email) {
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
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao'.json_encode($emails).' | Dados: '.json_encode($dados));
                    });

                    unset($dados['avaliador_2']);
                }

                if (isset($avaliador_3) && $avaliador_3->email) {
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
                        Log::info('E-mail Enviado para o usuario informando que ele foi selecionado como avaliador em uma submissao'.json_encode($emails).' | Dados: '.json_encode($dados));
                    });

                    unset($dados['avaliador_3']);
                }
            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: '.$e->getMessage().'  |  Linha: '.$e->getLine().' | Arquivo: '.$e->getFile());
            }
            Log::info('Avaliacao Nacional criada: '.$avaliacao_create->id.' | Request: '.json_encode($request->all()));

            return response()->json(['message' => 'success', 'response' => $avaliacao_create], 201);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        $avaliacao_create = AvaliacaoNacional::findOrFail($request->id);

        try {
            $post = $request->all();

            $avaliacao_create->update([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
            ]);

            Log::info('Avaliacao Nacional atualizada: '.$avaliacao_create->id.' | Request: '.json_encode($request->all()));

            return response()->json(['message' => 'success', 'response' => $avaliacao_create], 201);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function coordenadorSave(Request $request)
    {
        $avaliacao = AvaliacaoNacional::select('id', 'status_coordenador', 'justificativa_coordenador')
        ->with(
            'sub_gp',
            'sub_ij',
            'sub_publicom',
            'sub_gp.inscricao',
            'sub_ij.inscricao',
            'sub_publicom.inscricao',
            'sub_gp.inscricao.user',
            'sub_ij.inscricao.user',
            'sub_publicom.inscricao.user',
        )
        ->findOrFail($request->id);

        if ($avaliacao && $avaliacao->sub_gp) {
            $submissao = $avaliacao->sub_gp;
        }

        if ($avaliacao && $avaliacao->sub_ij) {
            $submissao = $avaliacao->sub_ij;
        }

        if ($avaliacao && $avaliacao->sub_publicom) {
            $submissao = $avaliacao->sub_publicom;
        }

        try {
            $post = $request->all();

            if ($post['status_coordenador'] == 'Alteração solicitada') {
                $avaliacao->update([
                    'status_coordenador' => $post['status_coordenador'],
                    'justificativa_coordenador' => $post['justificativa_coordenador'] ?? null,
                    'edit' => 1,
                ]);
            } else {
                $avaliacao->update([
                    'status_coordenador' => $post['status_coordenador'],
                    'justificativa_coordenador' => $post['justificativa_coordenador'] ?? null,
                ]);
            }

            Log::info('Avaliacao Nacional | Status e Sustificativa Coordenador updated: '.$avaliacao->id.' | Request: '.json_encode($request->all()));

            //Enviar e-mail informando ao autor que o status do seu trabalho foi alterado
            try {
                $dados['status_coordenador'] = $post['status_coordenador'];

                $dados['justificativa_coordenador'] = $post['justificativa_coordenador'];

                if ($submissao && $submissao->inscricao && $submissao->inscricao->user) {
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
                    Log::info('E-mail Enviado para o autor do trabalho com a informação do status | Email: '.$emails);
                });
            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: '.$e->getMessage().'  |  Linha: '.$e->getLine().' | Arquivo: '.$e->getFile());
            }

            return response()->json(['message' => 'success', 'response' => $avaliacao], 201);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
