<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Models\SubmissaoRegionalNordestes;

class ListaTrabalhosExpocomController extends Controller
{
    public function index(){
        return view('lista_trabalhos_aceitos_expocom.index');
    }

    public function view($regiao){
        $regiao = $regiao;

        return view('lista_trabalhos_aceitos_expocom.index', compact('regiao'));
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
                'inscricao.user:id,cpf,name',
                'inscricao.user.indicacao',
                'avaliacao',
                'avaliacao.avaliador_1_obj',
                'avaliacao.avaliador_2_obj',
                'avaliacao.avaliador_3_obj',
                'coautorOrientadorSubNordeste'
             );
    }

    public function get(Request $request){

        if($request && $request->regiao && $request->regiao == 2){

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
    }
}
