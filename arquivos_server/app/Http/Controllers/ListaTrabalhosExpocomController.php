<?php

namespace App\Http\Controllers;

use App\Models\SubmissaoExpocomRegionalCentrooeste;
use Illuminate\Http\Request;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Models\SubmissaoExpocomRegionalNorte;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\SubmissaoExpocomRegionalSul;
use App\Models\SubmissaoRegionalNordestes;

class ListaTrabalhosExpocomController extends Controller
{
    public function index(){
        return view('admin.lista_trabalhos_aceitos_expocom.index');
    }

    public function view($regiao_id){
        $regiao_id = $regiao_id;

        return view('admin.lista_trabalhos_aceitos_expocom.index', compact('regiao_id'));
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
            'link_aceite',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf,name',
                'inscricao.user.indicacao',
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj',
                'coautorOrientadorSubNordeste'
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
            'link_aceite',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf,name',
                'inscricao.user.indicacao',
                'avaliacao',
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
            'link_aceite',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf,name',
                'inscricao.user.indicacao',
                'avaliacao',
        );
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
            'link_aceite',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf,name',
                'inscricao.user.indicacao',
                'avaliacao',
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
            'link_aceite',
            )
            ->with(
                'inscricao',
                'inscricao.user:id,cpf,name',
                'inscricao.user.indicacao',
                'avaliacao',
        );
    }

    public function get(Request $request){

        if($request && $request->regiao && $request->regiao == "Nordeste"){

            return $this->submissao_nordeste()
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
                ->whereHas('avaliacao', function ($q){
                    $q->where('status_coordenador', '=', 'Aceito');
                })
            ->paginate(20);
        }

        if($request && $request->regiao && $request->regiao == "Sudeste"){
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
                ->whereHas('avaliacao', function ($q){
                    $q->where('status_coordenador', '=', 'Aceito');
                })
            ->paginate(20);
        }

        if($request && $request->regiao && $request->regiao == "Centro-Oeste"){
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
                ->whereHas('avaliacao', function ($q){
                    $q->where('status_coordenador', '=', 'Aceito');
                })
            ->paginate(20);
        }

        if($request && $request->regiao && $request->regiao == "Norte"){
            return $this->submissao_norte()
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
                ->whereHas('avaliacao', function ($q){
                    $q->where('status_coordenador', '=', 'Aceito');
                })
            ->paginate(20);
        }

        if($request && $request->regiao && $request->regiao == "Sul"){
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
                ->whereHas('avaliacao', function ($q){
                    $q->where('status_coordenador', '=', 'Aceito');
                })
            ->paginate(20);
        }
    }
}
