<?php

namespace App\Http\Controllers;

use App\Models\DistribuicaoTipo123;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user_id = Auth::user()->id;
        
        return  $this->avaliacoes()
            ->when($request->sort == 'id', function ($query) use ($request) {
                $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                $query->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->modalidade, function ($query) use ($request, $user_id) {
                $query->wherehas('submissaoNordeste', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('distribuicao_tipo123s.avaliador_1', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_2', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_3', $user_id);
                    });
    
                })
                ->orWherehas('submissaoSul', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('distribuicao_tipo123s.avaliador_1', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_2', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_3', $user_id);
                    });
    
                })
                ->orWherehas('submissaoSudeste', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('distribuicao_tipo123s.avaliador_1', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_2', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_3', $user_id);
                    });
    
                })
                ->orWherehas('submissaoCentroOeste', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('distribuicao_tipo123s.avaliador_1', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_2', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_3', $user_id);
                    });
                })
                ->orWherehas('submissaoNorte', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('distribuicao_tipo123s.avaliador_1', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_2', $user_id)
                            ->orWhere('distribuicao_tipo123s.avaliador_3', $user_id);
                    });
                });
            })
            ->where(function ($query) use ($user_id) {
                $query->where('distribuicao_tipo123s.avaliador_1', $user_id)
                    ->orWhere('distribuicao_tipo123s.avaliador_2', $user_id)
                    ->orWhere('distribuicao_tipo123s.avaliador_3', $user_id);
            })
        ->paginate(20);

    }
}
