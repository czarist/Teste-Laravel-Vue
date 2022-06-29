<?php

namespace App\Http\Controllers;

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
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ValidarApresentacaoExpocomController extends Controller
{
    public function index()
    {
        return view('validar-apresentacao-expocom.index');
    }

    public function inscrito_nordeste()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_nordeste:id,user_id,regiao,ano,presenca',
            'regional_nordeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_nordeste.submissaoExpocom.avaliacao',
            'indicacao:id,cpf_autor,categoria,modalidade'
        );
    }

    public function inscrito_norte()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_norte:id,user_id,regiao,ano,presenca',
            'regional_norte.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_norte.submissaoExpocom.avaliacao',
            'indicacao:id,cpf_autor,categoria,modalidade'
        );
    }

    public function inscrito_sul()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_sul:id,user_id,regiao,ano,presenca',
            'regional_sul.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_sul.submissaoExpocom.avaliacao',
            'indicacao:id,cpf_autor,categoria,modalidade'
        );
    }

    public function inscrito_sudeste()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_suldeste:id,user_id,regiao,ano,presenca',
            'regional_suldeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_suldeste.submissaoExpocom.avaliacao',
            'indicacao:id,cpf_autor,categoria,modalidade'
        );
    }

    public function inscrito_centrooeste()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_centrooeste:id,user_id,regiao,ano,presenca',
            'regional_centrooeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_centrooeste.submissaoExpocom.avaliacao',
            'indicacao:id,cpf_autor,categoria,modalidade'
        );
    }

    public function get(Request $request)
    {
        if (Auth::user() && Auth::user()->coordenador_regional && Auth::user()->coordenador_regional->tipo == 'Expocom' && Auth::user()->coordenador_regional->dt) {
            $dt = Auth::user()->coordenador_regional->dt;

            if (isset($request->regiao) && $request->regiao == 'Nordeste') {
                return $this->inscrito_nordeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->search.'%');
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('categoria', '=', $request->categoria);
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('modalidade', '=', $request->modalidade);
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 7);
                    })
                    ->wherehas('regional_nordeste', function ($query) {
                        $query->wherehas('submissaoExpocom', function ($query) {
                            $query->wherehas('avaliacao', function ($query) {
                                $query->where('status_coordenador', 'Aceito');
                            });
                        });
                    })
                    ->wherehas('indicacao', function ($query) use ($dt) {
                        $query->where('categoria', $dt);
                    })
                ->paginate(20);
            }

            if (isset($request->regiao) && $request->regiao == 'Norte') {
                return $this->inscrito_norte()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->search.'%');
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('categoria', '=', $request->categoria);
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('modalidade', '=', $request->modalidade);
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 10);
                    })
                    ->wherehas('regional_norte', function ($query) {
                        $query->wherehas('submissaoExpocom', function ($query) {
                            $query->wherehas('avaliacao', function ($query) {
                                $query->where('status_coordenador', 'Aceito');
                            });
                        });
                    })
                    ->wherehas('indicacao', function ($query) use ($dt) {
                        $query->where('categoria', $dt);
                    })
                ->paginate(20);
            }

            if (isset($request->regiao) && $request->regiao == 'Sul') {
                return $this->inscrito_sul()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->search.'%');
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('categoria', '=', $request->categoria);
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('modalidade', '=', $request->modalidade);
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 6);
                    })
                    ->wherehas('regional_sul', function ($query) {
                        $query->wherehas('submissaoExpocom', function ($query) {
                            $query->wherehas('avaliacao', function ($query) {
                                $query->where('status_coordenador', 'Aceito');
                            });
                        });
                    })
                    ->wherehas('indicacao', function ($query) use ($dt) {
                        $query->where('categoria', $dt);
                    })
                ->paginate(20);
            }

            if (isset($request->regiao) && $request->regiao == 'Sudeste') {
                return $this->inscrito_sudeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->search.'%');
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('categoria', '=', $request->categoria);
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('modalidade', '=', $request->modalidade);
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 8);
                    })
                    ->wherehas('regional_suldeste', function ($query) {
                        $query->wherehas('submissaoExpocom', function ($query) {
                            $query->wherehas('avaliacao', function ($query) {
                                $query->where('status_coordenador', 'Aceito');
                            });
                        });
                    })
                    ->wherehas('indicacao', function ($query) use ($dt) {
                        $query->where('categoria', $dt);
                    })
                ->paginate(20);
            }

            if (isset($request->regiao) && $request->regiao == 'Centro-Oeste') {
                return $this->inscrito_centrooeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->search.'%');
                            });
                        });
                    })
                    ->when($request->categoria, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('categoria', '=', $request->categoria);
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->wherehas('indicacao', function ($query) use ($request) {
                            $query->where('modalidade', '=', $request->modalidade);
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 9);
                    })
                    ->wherehas('regional_centrooeste', function ($query) {
                        $query->wherehas('submissaoExpocom', function ($query) {
                            $query->wherehas('avaliacao', function ($query) {
                                $query->where('status_coordenador', 'Aceito');
                            });
                        });
                    })
                    ->wherehas('indicacao', function ($query) use ($dt) {
                        $query->where('categoria', $dt);
                    })
                ->paginate(20);
            }
        }
    }

    public function confirmar_apresentacao(Request $request)
    {
        try {
            if (isset($request->regiao) && $request->regiao == 'Nordeste') {
                $regional = RegionalNordeste::where('id', $request->inscricao)->first();
                if ($regional && $regional->presenca == 0) {
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Nordeste: '.$request->inscricao.' confirmado presença');
                }

                $submissao = SubmissaoExpocomRegionalNordeste::where('id', $request->submissao)->first();
                if ($submissao && $submissao->apresentacao == 0) {
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Submissao Expocom Nordeste: '.$request->submissao.' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_nordeste:id,user_id,regiao,ano,presenca',
                    'regional_nordeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_nordeste.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Norte') {
                $regional = RegionalNorte::where('id', $request->inscricao)->first();
                if ($regional && $regional->presenca == 0) {
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Norte: '.$request->inscricao.' confirmado presença');
                }

                $submissao = SubmissaoExpocomRegionalNorte::where('id', $request->submissao)->first();
                if ($submissao && $submissao->apresentacao == 0) {
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Regional Norte: '.$request->submissao.' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_norte:id,user_id,regiao,ano,presenca',
                    'regional_norte.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_norte.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Centro-Oeste') {
                $regional = RegionalCentrooeste::where('id', $request->inscricao)->first();
                if ($regional && $regional->presenca == 0) {
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Centro-Oeste: '.$request->inscricao.' confirmado presença');
                }

                $submissao = SubmissaoExpocomRegionalCentrooeste::where('id', $request->submissao)->first();
                if ($submissao && $submissao->apresentacao == 0) {
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Regional Centro-Oeste: '.$request->submissao.' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_centrooeste:id,user_id,regiao,ano,presenca',
                    'regional_centrooeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_centrooeste.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Sudeste') {
                $regional = RegionalSuldeste::where('id', $request->inscricao)->first();
                if ($regional && $regional->presenca == 0) {
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Sudeste: '.$request->inscricao.' confirmado presença');
                }

                $submissao = SubmissaoExpocomRegionalSudeste::where('id', $request->submissao)->first();
                if ($submissao && $submissao->apresentacao == 0) {
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Regional Sudeste: '.$request->submissao.' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_suldeste:id,user_id,regiao,ano,presenca',
                    'regional_suldeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_suldeste.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Sul') {
                $regional = RegionalSul::where('id', $request->inscricao)->first();
                if ($regional && $regional->presenca == 0) {
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Sudeste: '.$request->inscricao.' confirmado presença');
                }

                $submissao = SubmissaoExpocomRegionalSul::where('id', $request->submissao)->first();
                if ($submissao && $submissao->apresentacao == 0) {
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Regional Sul: '.$request->submissao.' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_sul:id,user_id,regiao,ano,presenca',
                    'regional_sul.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_sul.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            return response()->json(['error'=>'Nenhuma inscrição atualizada']);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function confirmar_vencedor(Request $request)
    {
        try {
            if (isset($request->regiao) && $request->regiao == 'Nordeste') {
                SubmissaoExpocomRegionalNordeste::where('id', $request->submissao)->update(['vencedor' => 1]);
                Log::info('Submissao Expocom Nordeste: '.$request->submissao.' confirmado vencedor de trabalho');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_nordeste:id,user_id,regiao,ano,presenca',
                    'regional_nordeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_nordeste.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Norte') {
                SubmissaoExpocomRegionalNorte::where('id', $request->submissao)->update(['vencedor' => 1]);
                Log::info('Submissao Expocom Norte: '.$request->submissao.' confirmado vencedor de trabalho');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_norte:id,user_id,regiao,ano,presenca',
                    'regional_norte.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_norte.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Centro-Oeste') {
                SubmissaoExpocomRegionalCentrooeste::where('id', $request->submissao)->update(['vencedor' => 1]);
                Log::info('Submissao Expocom Centro-Oeste: '.$request->submissao.' confirmado vencedor de trabalho');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_centrooeste:id,user_id,regiao,ano,presenca',
                    'regional_centrooeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_centrooeste.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Sudeste') {
                SubmissaoExpocomRegionalSudeste::where('id', $request->submissao)->update(['vencedor' => 1]);
                Log::info('Submissao Expocom Sudeste: '.$request->submissao.' confirmado vencedor de trabalho');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_suldeste:id,user_id,regiao,ano,presenca',
                    'regional_suldeste.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_suldeste.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Sul') {
                SubmissaoExpocomRegionalSul::where('id', $request->submissao)->update(['vencedor' => 1]);
                Log::info('Submissao Expocom Sul: '.$request->submissao.' confirmado vencedor de trabalho');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_sul:id,user_id,regiao,ano,presenca',
                    'regional_sul.submissaoExpocom:id,inscricao_id,avaliacao,regiao,ano,apresentacao,vencedor,regiao,ano',
                    'regional_sul.submissaoExpocom.avaliacao',
                    'indicacao:id,cpf_autor,categoria,modalidade'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
