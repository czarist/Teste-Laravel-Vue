<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoNacional;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AvaliadorNacionalController extends Controller
{
    public function index()
    {
        return view('nacional.avaliador.index');
    }

    public function avaliacoes()
    {
        return AvaliacaoNacional::select(
            'id',
            'avaliador_1',
            'status_avaliador_1',
            'justificativa_avaliador_1',
            'pergunta_1_1',
            'pergunta_1_2',
            'pergunta_1_3',
            'pergunta_1_4',
            'pergunta_1_5',
            'pergunta_1_6',
            'pergunta_1_7',
            'pergunta_1_8',
            'pergunta_1_9',
            'pergunta_1_10',
            'pergunta_1_11',
            'avaliador_2',
            'status_avaliador_2',
            'justificativa_avaliador_2',
            'pergunta_2_1',
            'pergunta_2_2',
            'pergunta_2_3',
            'pergunta_2_4',
            'pergunta_2_5',
            'pergunta_2_6',
            'pergunta_2_7',
            'pergunta_2_8',
            'pergunta_2_9',
            'pergunta_2_10',
            'pergunta_2_11',
            'avaliador_3',
            'status_avaliador_3',
            'justificativa_avaliador_3',
            'pergunta_3_1',
            'pergunta_3_2',
            'pergunta_3_3',
            'pergunta_3_4',
            'pergunta_3_5',
            'pergunta_3_6',
            'pergunta_3_7',
            'pergunta_3_8',
            'pergunta_3_9',
            'pergunta_3_10',
            'pergunta_3_11',
            'status_coordenador',
            'justificativa_coordenador',
            'edit',
            )
        ->with(
            'sub_gp:id,inscricao_id,avaliacao,dt,tipo,link_trabalho,titulo',
            'sub_ij:id,inscricao_id,avaliacao,dt,tipo,link_trabalho,titulo',
            'sub_publicom:id,inscricao_id,avaliacao,dt,tipo,link_trabalho,titulo',
            'sub_gp.inscricao',
            'sub_ij.inscricao',
            'sub_publicom.inscricao',
            'sub_gp.inscricao.user',
            'sub_ij.inscricao.user',
            'sub_publicom.inscricao.user',
        );
    }

    public function get(Request $request)
    {
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
                $query->wherehas('sub_gp', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('avaliacao_nacional.avaliador_1', $user_id)
                            ->orWhere('avaliacao_nacional.avaliador_2', $user_id)
                            ->orWhere('avaliacao_nacional.avaliador_3', $user_id);
                    });
                })
                ->orWherehas('sub_ij', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('avaliacao_nacional.avaliador_1', $user_id)
                            ->orWhere('avaliacao_nacional.avaliador_2', $user_id)
                            ->orWhere('avaliacao_nacional.avaliador_3', $user_id);
                    });
                })
                ->orWherehas('sub_publicom', function ($query) use ($request, $user_id) {
                    $query->where('dt', '=', $request->modalidade)
                    ->where(function ($query) use ($user_id) {
                        $query->where('avaliacao_nacional.avaliador_1', $user_id)
                            ->orWhere('avaliacao_nacional.avaliador_2', $user_id)
                            ->orWhere('avaliacao_nacional.avaliador_3', $user_id);
                    });
                });
            })
            ->where('avaliador_1', $user_id)
            ->orWhere('avaliador_2', $user_id)
            ->orWhere('avaliador_3', $user_id)
        ->paginate(20);
    }
}
