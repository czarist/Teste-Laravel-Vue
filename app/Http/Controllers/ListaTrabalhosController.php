<?php

namespace App\Http\Controllers;

use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalSudeste;
use Illuminate\Http\Request;

class ListaTrabalhosController extends Controller
{

    public function index(){
        return view('lista_trabalhos_aceitos.index');
    }

    public function view($regiao){
        $regiao = $regiao;

        return view('lista_trabalhos_aceitos.index', compact('regiao'));
    }


    public function submissao_nordeste(){
        return SubmissaoRegionalNordestes::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'inscricao',
            'inscricao.user',
            'coautorOrientadorSubNordeste'
        );
    }

    public function submissao_sudeste(){
        return SubmissaoRegionalSudeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'inscricao',
            'inscricao.user',
            'coautorOrientadorSubSudeste'
        );
    }


    public function get(Request $request){

        if($request && $request->regiao && $request->regiao == 2){

            return $this->submissao_nordeste()
            ->when($request->sort == 'id', function ($query) use ($request) {
                $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'titulo', function ($query) use ($request) {
                $query->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
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
            ->whereHas('avaliacao', function ($q){
                $q->where('status_coordenador', '=', 'Aceito');
            })
        ->paginate(20);
        }

        if($request && $request->regiao && $request->regiao == 3){

            return $this->submissao_sudeste()
            ->when($request->sort == 'id', function ($query) use ($request) {
                $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'titulo', function ($query) use ($request) {
                $query->orderBy('titulo', $request->asc == 'true' ? 'ASC' : 'DESC');
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
            ->whereHas('avaliacao', function ($q){
                $q->where('status_coordenador', '=', 'Aceito');
            })
        ->paginate(20);
        }

    }

}
