<?php

namespace App\Http\Controllers;

use App\Models\DistribuicaoTipo123;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoAvaliadorController extends Controller
{
    public function index()
    {
        return view('regionais.avaliador.index');
    }

    public function avaliacoes()
    {
        return DistribuicaoTipo123::select(
            'id',
            'avaliador_1',
            'status_avaliador_1',
            'justificativa_avaliador_1',
            'avaliador_2',
            'status_avaliador_2',
            'justificativa_avaliador_2',
            'avaliador_3',
            'status_avaliador_3',
            'justificativa_avaliador_3',
            'status_coordenador',
            'justificativa_coordenador')
        ->with(
            'avaliador_1_obj', 
            'avaliador_2_obj', 
            'avaliador_3_obj',
            'submissaoNordeste:id,avaliacao,dt,inscricao_id,link_trabalho,regiao,tipo,titulo',
            'submissaoSul:id,avaliacao,dt,inscricao_id,link_trabalho,regiao,tipo,titulo',
            'submissaoSudeste:id,avaliacao,dt,inscricao_id,link_trabalho,regiao,tipo,titulo',
            'submissaoCentroOeste:id,avaliacao,dt,inscricao_id,link_trabalho,regiao,tipo,titulo',
            'submissaoNorte:id,avaliacao,dt,inscricao_id,link_trabalho,regiao,tipo,titulo'
        );
    }

    public function get(Request $request){
        return $this->avaliacoes()
            ->where(function ($query) {
                $query->where('avaliador_1', "=", Auth::user()->id)
                    ->orWhere('avaliador_2', "=", Auth::user()->id)
                    ->orWhere('avaliador_3', "=", Auth::user()->id);
            })
            ->when($request->statusAva, function ($query) use ($request) {
                $query->where('status_avaliador_1', '=', $request->statusAva)
                ->orWhere('status_avaliador_2', "=", $request->statusAva)
                ->orWhere('status_avaliador_3', "=", $request->statusAva);

            })
            ->when($request->statusCoo, function ($query) use ($request) {
                $query->where('status_coordenador', '=', $request->statusCoo);
            })  
            ->when($request->sort == 'id', function ($query) use ($request) {
                $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                $query->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->when($request->type == 'titulo', function ($query) use ($request) {
                        $query->wherehas('submissaoNordeste', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        })
                        ->orWherehas('submissaoSul', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        })
                        ->orWherehas('submissaoSudeste', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        })
                        ->orWherehas('submissaoCentroOeste', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        })
                        ->orWherehas('submissaoNorte', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        });
                    });
                });
            })
            ->when($request->modalidade, function ($query) use ($request){
                $query->wherehas('submissaoNordeste', function ($query) use ($request) {
                    $query->where('dt', '=', $request->modalidade);
                })
                ->orWherehas('submissaoSul', function ($query) use ($request) {
                    $query->where('dt', '=', $request->modalidade);
                })
                ->orWherehas('submissaoSudeste', function ($query) use ($request) {
                    $query->where('dt', '=', $request->modalidade);
                })
                ->orWherehas('submissaoCentroOeste', function ($query) use ($request) {
                    $query->where('dt', '=', $request->modalidade);
                })
                ->orWherehas('submissaoNorte', function ($query) use ($request) {
                    $query->where('dt', '=', $request->modalidade);
                });
            })
        ->paginate(20);

    }
}
