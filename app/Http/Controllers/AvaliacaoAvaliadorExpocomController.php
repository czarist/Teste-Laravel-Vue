<?php

namespace App\Http\Controllers;

use App\Models\DistribuicaoTipoExpocom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoAvaliadorExpocomController extends Controller
{
    public function index()
    {
        return view('regionais.avaliadorExpocom.index');
    }

    public function avaliacoes()
    {
        return DistribuicaoTipoExpocom::select(
            'id',
            'avaliador_1',
            'status_avaliador_1',
            'justificativa_avaliador_1',
            'expe_1',
            'qualidade_1',
            'coerencia_1',
            'media_1',
            'avaliador_2',
            'status_avaliador_2',
            'justificativa_avaliador_2',
            'expe_2',
            'qualidade_2',
            'coerencia_2',
            'media_2',
            'avaliador_3',
            'status_avaliador_3',
            'justificativa_avaliador_3',
            'expe_3',
            'qualidade_3',
            'coerencia_3',
            'media_3',
            'status_coordenador',
            'justificativa_coordenador',
            'media_final',
            'edit'            
            )
        ->with(
            'avaliador_1_obj', 
            'avaliador_2_obj', 
            'avaliador_3_obj',
            'submissaoNordeste:id,avaliacao,inscricao_id,link_trabalho,regiao,campus,desc_obj_estudo,desc_pesquisa,desc_producao,ano',
            'submissaoNordeste.coautorOrientadorSubNordeste',
            'submissaoNordeste.inscricao:id,categoria_inscricao,user_id',
            'submissaoNordeste.inscricao.user:id,cpf',
            'submissaoNordeste.inscricao.user.indicacao',

            'submissaoSul:id,avaliacao,inscricao_id,link_trabalho,regiao,campus,desc_obj_estudo,desc_pesquisa,desc_producao,ano',
            'submissaoSul.coautorOrientadorSubSuls',
            'submissaoSul.inscricao:id,categoria_inscricao,user_id',
            'submissaoSul.inscricao.user:id,cpf',
            'submissaoSul.inscricao.user.indicacao',

            'submissaoSudeste:id,avaliacao,inscricao_id,link_trabalho,regiao,campus,desc_obj_estudo,desc_pesquisa,desc_producao,ano',
            'submissaoSudeste.coautorOrientadorSubSudeste',
            'submissaoSudeste.inscricao:id,categoria_inscricao,user_id',
            'submissaoSudeste.inscricao.user:id,cpf',
            'submissaoSudeste.inscricao.user.indicacao',

            'submissaoCentroOeste:id,avaliacao,inscricao_id,link_trabalho,regiao,campus,desc_obj_estudo,desc_pesquisa,desc_producao,ano',
            'submissaoCentroOeste.coautorOrientadorSubCentroOeste',
            'submissaoCentroOeste.inscricao:id,categoria_inscricao,user_id',
            'submissaoCentroOeste.inscricao.user:id,cpf',
            'submissaoCentroOeste.inscricao.user.indicacao',

            'submissaoNorte:id,avaliacao,inscricao_id,link_trabalho,regiao,campus,desc_obj_estudo,desc_pesquisa,desc_producao,ano',
            'submissaoNorte.coautorOrientadorSubNortes',
            'submissaoNorte.inscricao:id,categoria_inscricao,user_id',
            'submissaoNorte.inscricao.user:id,cpf',
            'submissaoNorte.inscricao.user.indicacao'
        );
    }

    public function get(Request $request){
        return $this->avaliacoes()
            ->when($request->sort == 'id', function ($query) use ($request) {
                $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'status_avaliador', function ($query) use ($request) {
                $query->orderBy('status_avaliador_1', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'status_coordenador', function ($query) use ($request) {
                $query->orderBy('status_coordenador', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->modalidade, function ($query) use ($request){
                $query->where(function ($query) use ($request) {
                    $query->wherehas('submissaoNordeste', function ($query) use ($request) {
                        $query->wherehas('inscricao', function ($query) use ($request) {
                            $query->wherehas('user', function ($query) use ($request) {
                                $query->wherehas('indicacao', function ($query) use ($request) {
                                    $query->where('categoria', '=', $request->modalidade);
                                });
                            });
                        });
                    })
                    ->orWherehas('submissaoSul', function ($query) use ($request) {
                        $query->wherehas('inscricao', function ($query) use ($request) {
                            $query->wherehas('user', function ($query) use ($request) {
                                $query->wherehas('indicacao', function ($query) use ($request) {
                                    $query->where('categoria', '=', $request->modalidade);
                                });
                            });
                        });
                    })
                    ->orWherehas('submissaoSudeste', function ($query) use ($request) {
                        $query->wherehas('inscricao', function ($query) use ($request) {
                            $query->wherehas('user', function ($query) use ($request) {
                                $query->wherehas('indicacao', function ($query) use ($request) {
                                    $query->where('categoria', '=', $request->modalidade);
                                });
                            });
                        });
                    })
                    ->orWherehas('submissaoCentroOeste', function ($query) use ($request) {
                        $query->wherehas('inscricao', function ($query) use ($request) {
                            $query->wherehas('user', function ($query) use ($request) {
                                $query->wherehas('indicacao', function ($query) use ($request) {
                                    $query->where('categoria', '=', $request->modalidade);
                                });
                            });
                        });
                    })
                    ->orWherehas('submissaoNorte', function ($query) use ($request) {
                        $query->wherehas('inscricao', function ($query) use ($request) {
                            $query->wherehas('user', function ($query) use ($request) {
                                $query->wherehas('indicacao', function ($query) use ($request) {
                                    $query->where('categoria', '=', $request->modalidade);
                                });
                            });
                        });
                    });
                });

            })
            ->where(function ($query) {
                $query->where('avaliador_1', "=", Auth::user()->id)
                    ->orWhere('avaliador_2', "=", Auth::user()->id)
                    ->orWhere('avaliador_3', "=", Auth::user()->id);
            })
        ->paginate(20);
    }
}
