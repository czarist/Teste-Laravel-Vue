<?php

namespace App\Http\Controllers;

use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalNorte;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ValidarApresentacaoController extends Controller
{
    public function index(){
        return view('validar-apresentacao.index');
    }

    public function inscrito_nordeste(){
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_nordeste:id,user_id,regiao,ano,presenca',
            'regional_nordeste.submissaoMesa',
            'regional_nordeste.submissaoDt',
            'regional_nordeste.submissaoJunior.divisao_tematica',
            'regional_nordeste.submissaoMesa.divisao_tematica',
            'regional_nordeste.submissaoDt.divisao_tematica',
            'regional_nordeste.submissaoJunior',
            'regional_nordeste.submissaoMesa.avaliacao',
            'regional_nordeste.submissaoDt.avaliacao',
            'regional_nordeste.submissaoJunior.avaliacao',
        );
    }

    public function inscrito_norte(){
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_norte:id,user_id,regiao,ano,presenca',
            'regional_norte.submissaoMesa',
            'regional_norte.submissaoDt',
            'regional_norte.submissaoJunior',
            'regional_norte.submissaoMesa.divisao_tematica',
            'regional_norte.submissaoDt.divisao_tematica',
            'regional_norte.submissaoJunior.divisao_tematica',
            'regional_norte.submissaoMesa.avaliacao',
            'regional_norte.submissaoDt.avaliacao',
            'regional_norte.submissaoJunior.avaliacao',
        );
    }

    public function inscrito_sul(){
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_sul:id,user_id,regiao,ano,presenca',
            'regional_sul.submissaoMesa',
            'regional_sul.submissaoDt',
            'regional_sul.submissaoJunior',
            'regional_sul.submissaoMesa.divisao_tematica',
            'regional_sul.submissaoDt.divisao_tematica',
            'regional_sul.submissaoJunior.divisao_tematica',
            'regional_sul.submissaoMesa.avaliacao',
            'regional_sul.submissaoDt.avaliacao',
            'regional_sul.submissaoJunior.avaliacao',
        );
    }

    public function inscrito_sudeste(){
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_suldeste:id,user_id,regiao,ano,presenca',
            'regional_suldeste.submissaoMesa',
            'regional_suldeste.submissaoDt',
            'regional_suldeste.submissaoJunior',
            'regional_suldeste.submissaoMesa.divisao_tematica',
            'regional_suldeste.submissaoDt.divisao_tematica',
            'regional_suldeste.submissaoJunior.divisao_tematica',
            'regional_suldeste.submissaoMesa.avaliacao',
            'regional_suldeste.submissaoDt.avaliacao',
            'regional_suldeste.submissaoJunior.avaliacao',
        );
    }

    public function inscrito_centrooeste(){
        return User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_centrooeste:id,user_id,regiao,ano,presenca',
            'regional_centrooeste.submissaoMesa',
            'regional_centrooeste.submissaoDt',
            'regional_centrooeste.submissaoJunior',
            'regional_centrooeste.submissaoMesa.divisao_tematica',
            'regional_centrooeste.submissaoDt.divisao_tematica',
            'regional_centrooeste.submissaoJunior.divisao_tematica',
            'regional_centrooeste.submissaoMesa.avaliacao',
            'regional_centrooeste.submissaoDt.avaliacao',
            'regional_centrooeste.submissaoJunior.avaliacao',
        );
    }

    public function get(Request $request){
        if(Auth::user() && Auth::user()->coordenador_regional && Auth::user()->coordenador_regional->tipo != "Expocom"){
            if(Auth::user()->coordenador_regional->regiao == "Nordeste"){
                return $this->inscrito_nordeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {    
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 7);
                    })
                    ->whereHas('regional_nordeste', function ($query){
                        $query->wherehas('submissaoMesa', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoDt', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoJunior', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->whereHas('regional_nordeste', function ($query) use ($request) {
                            $query->wherehas('submissaoMesa', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoDt', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoJunior', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                        });
                    })    
                ->paginate(20);
            }

            if(Auth::user()->coordenador_regional->regiao == "Sudeste"){
                return $this->inscrito_sudeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {    
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 8);
                    })
                    ->whereHas('regional_suldeste', function ($query) {
                        $query->wherehas('submissaoMesa', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoDt', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoJunior', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->whereHas('regional_suldeste', function ($query) use ($request) {
                            $query->wherehas('submissaoMesa', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoDt', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoJunior', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                        });
                    })    
                ->paginate(20);
            }

            if(Auth::user()->coordenador_regional->regiao == "Centrooeste"){
                return $this->inscrito_centrooeste()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {    
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 9);
                    })
                    ->whereHas('regional_centrooeste', function ($query) {
                        $query->wherehas('submissaoMesa', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoDt', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoJunior', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->whereHas('regional_centrooeste', function ($query) use ($request) {
                            $query->wherehas('submissaoMesa', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoDt', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoJunior', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                        });
                    })    
                ->paginate(20);
            }

            if(Auth::user()->coordenador_regional->regiao == "Sul"){
                return $this->inscrito_sul()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {    
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 6);
                    })
                    ->whereHas('regional_sul', function ($query) {
                        $query->wherehas('submissaoMesa', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoDt', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoJunior', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->whereHas('regional_sul', function ($query) use ($request) {
                            $query->wherehas('submissaoMesa', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoDt', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoJunior', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                        });
                    })                        
                ->paginate(20);
            }

            if(Auth::user()->coordenador_regional->regiao == "Norte"){
                return $this->inscrito_norte()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {    
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->whereHas('todos_tipos', function ($query) {
                        $query->where('tipo_id', 10);
                    })
                    ->whereHas('regional_norte', function ($query) {
                        $query->wherehas('submissaoMesa', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoDt', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                        $query->orWhereHas('submissaoJunior', function ($query){
                            $query->wherehas('avaliacao', function ($query){
                                $query->where('status_coordenador', "Aceito");
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request) {
                        $query->whereHas('regional_norte', function ($query) use ($request) {
                            $query->wherehas('submissaoMesa', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoDt', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                            $query->orWhereHas('submissaoJunior', function ($query) use ($request) {
                                $query->where('dt', '=', $request->modalidade);
                            });
                        });
                    })                        
                ->paginate(20);
            }
        }
    }

    public function confirmar_apresentacao(Request $request){
        try { 
            if(isset($request->regiao) && $request->regiao == "Nordeste"){
                $regional = RegionalNordeste::where('id', $request->inscricao)->first();
                if($regional && $regional->presenca == 0){
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Nordeste: '.$request->inscricao .' confirmado presença');
                }

                $submissao = SubmissaoRegionalNordestes::where('id', $request->submissao)->first();
                if($submissao && $submissao->apresentacao == 0){
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Submissao Nordeste: '.$request->submissao .' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_nordeste:id,user_id,regiao,ano,presenca',
                    'regional_nordeste.submissaoMesa',
                    'regional_nordeste.submissaoDt',
                    'regional_nordeste.submissaoJunior',
                    'regional_nordeste.submissaoMesa.avaliacao',
                    'regional_nordeste.submissaoDt.avaliacao',
                    'regional_nordeste.submissaoJunior.avaliacao',
                )
                ->whereId($request->user_id)
                ->first();
                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if(isset($request->regiao) && $request->regiao == "Norte"){
                $regional = RegionalNorte::where('id', $request->inscricao)->first();
                if($regional && $regional->presenca == 0){
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Norte: '.$request->inscricao .' confirmado presença');
                }

                $submissao = SubmissaoRegionalNorte::where('id', $request->submissao)->first();
                if($submissao && $submissao->apresentacao == 0){
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Submissao Norte: '.$request->submissao .' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_norte:id,user_id,regiao,ano,presenca',
                    'regional_norte.submissaoMesa',
                    'regional_norte.submissaoDt',
                    'regional_norte.submissaoJunior',
                    'regional_norte.submissaoMesa.avaliacao',
                    'regional_norte.submissaoDt.avaliacao',
                    'regional_norte.submissaoJunior.avaliacao',
                )
                ->whereId($request->user_id)
                ->first();
                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if(isset($request->regiao) && $request->regiao == "Centro-Oeste"){
                $regional = RegionalCentrooeste::where('id', $request->inscricao)->first();
                if($regional && $regional->presenca == 0){
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Centro-Oeste: '.$request->inscricao .' confirmado presença');
                }

                $submissao = SubmissaoRegionalCentroOeste::where('id', $request->submissao)->first();
                if($submissao && $submissao->apresentacao == 0){
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Submissao Centro-Oeste: '.$request->submissao .' confirmado apresentacao de trabalho');
                }
                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_centrooeste:id,user_id,regiao,ano,presenca',
                    'regional_centrooeste.submissaoMesa',
                    'regional_centrooeste.submissaoDt',
                    'regional_centrooeste.submissaoJunior',
                    'regional_centrooeste.submissaoMesa.avaliacao',
                    'regional_centrooeste.submissaoDt.avaliacao',
                    'regional_centrooeste.submissaoJunior.avaliacao',
                )
                ->whereId($request->user_id)
                ->first();
                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if(isset($request->regiao) && $request->regiao == "Sudeste"){
                $regional = RegionalSuldeste::where('id', $request->inscricao)->first();
                if($regional && $regional->presenca == 0){
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Sudeste: '.$request->inscricao .' confirmado presença');
                }
                $submissao = SubmissaoRegionalSudeste::where('id', $request->submissao)->first();
                if($submissao && $submissao->apresentacao == 0){
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Submissao Sudeste: '.$request->submissao .' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_suldeste:id,user_id,regiao,ano,presenca',
                    'regional_suldeste.submissaoMesa',
                    'regional_suldeste.submissaoDt',
                    'regional_suldeste.submissaoJunior',
                    'regional_suldeste.submissaoMesa.avaliacao',
                    'regional_suldeste.submissaoDt.avaliacao',
                    'regional_suldeste.submissaoJunior.avaliacao',
                )
                ->whereId($request->user_id)
                ->first();
                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            if(isset($request->regiao) && $request->regiao == "Sul"){
                $regional = RegionalSul::where('id', $request->inscricao)->first();
                if($regional && $regional->presenca == 0){
                    $regional->update(['presenca' => 1]);
                    Log::info('Regional Sul: '.$request->inscricao .' confirmado presença');
                }
                $submissao = SubmissaoRegionalSul::where('id', $request->submissao)->first();
                if($submissao && $submissao->apresentacao == 0){
                    $submissao->update(['apresentacao' => 1]);
                    Log::info('Submissao Sul: '.$request->submissao .' confirmado apresentacao de trabalho');
                }

                $user = User::select('id', 'name', 'email', 'cpf')
                ->with(
                    'todos_tipos:id,descricao',
                    'regional_sul:id,user_id,regiao,ano,presenca',
                    'regional_sul.submissaoMesa',
                    'regional_sul.submissaoDt',
                    'regional_sul.submissaoJunior',
                    'regional_sul.submissaoMesa.avaliacao',
                    'regional_sul.submissaoDt.avaliacao',
                    'regional_sul.submissaoJunior.avaliacao',
                )
                ->whereId($request->user_id)
                ->first();
                return response()->json(['message' => 'success', 'response' => $user], 200);
            }

            return response()->json(['error'=>'Nenhuma inscrição atualizada']);

        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

}
