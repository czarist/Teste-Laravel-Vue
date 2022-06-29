<?php

namespace App\Http\Controllers;

use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidarPresencaController extends Controller
{
    public function index()
    {
        return view('admin.validar-presenca.index');
    }

    public function inscrito_nordeste()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_nordeste',
            'nacional'
        );
    }

    public function inscrito_norte()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_norte',
            'nacional'
        );
    }

    public function inscrito_sul()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_sul',
            'nacional'
        );
    }

    public function inscrito_sudeste()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_suldeste',
            'nacional'
        );
    }

    public function inscrito_centrooeste()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_centrooeste',
            'nacional'
        );
    }

    public function inscrito_nacional()
    {
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'nacional'
        );
    }

    public function get(Request $request)
    {
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

                ->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', 7);
                })
                ->orderBy('id', 'DESC')
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
                ->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', 10);
                })
                ->orderBy('id', 'DESC')
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
                ->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', 6);
                })
                ->orderBy('id', 'DESC')

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
                ->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', 8);
                })
                ->orderBy('id', 'DESC')

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
                ->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', 9);
                })
                ->orderBy('id', 'DESC')

            ->paginate(20);
        }

        if (isset($request->regiao) && $request->regiao == 'Nacional') {
            return $this->inscrito_nacional()
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
                ->whereHas('todos_tipos', function ($query) {
                    $query->where('tipo_id', 11);
                })
                ->orderBy('id', 'DESC')

            ->paginate(20);
        }
    }

    public function confirmar(Request $request)
    {
        try {
            if (isset($request->regiao) && $request->regiao == 'Nordeste') {
                $regional = RegionalNordeste::where('id', $request->inscricao)->update(['presenca' => 1]);
                Log::info('Regional Nordeste: '.$request->inscricao.' confirmado presença');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_nordeste',
                    'nacional'
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Norte') {
                $regional = RegionalNorte::where('id', $request->inscricao)->update(['presenca' => 1]);
                Log::info('Regional Norte: '.$request->inscricao.' confirmado presença');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_norte',
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Sul') {
                $regional = RegionalSul::where('id', $request->inscricao)->update(['presenca' => 1]);
                Log::info('Regional Sul: '.$request->inscricao.' confirmado presença');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_sul',
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Sudeste') {
                $regional = RegionalSuldeste::where('id', $request->inscricao)->update(['presenca' => 1]);
                Log::info('Regional Sudeste: '.$request->inscricao.' confirmado presença');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_suldeste',
                )
                ->whereId($request->user_id)
                ->first();

                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if (isset($request->regiao) && $request->regiao == 'Centro-Oeste') {
                $regional = RegionalCentrooeste::where('id', $request->inscricao)->update(['presenca' => 1]);
                Log::info('Regional Centro-Oeste: '.$request->inscricao.' confirmado presença');

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_centrooeste',
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
}
