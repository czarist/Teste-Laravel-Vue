<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coordenador;
use App\Models\DistribuicaoTipo123;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\SubmissaoRegionalNorte;
use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class ValidarDtController extends Controller
{
    public function index(){
        return view('admin.validar-presenca.index');
    }

    public function submissoes_sul()
    {
        return SubmissaoRegionalSul::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'avaliacao.avaliador_1_obj',
            'avaliacao.avaliador_2_obj',
            'avaliacao.avaliador_3_obj'
        );
    }

    public function submissoes_sudeste()
    {
        return SubmissaoRegionalSudeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'avaliacao.avaliador_1_obj',
            'avaliacao.avaliador_2_obj',
            'avaliacao.avaliador_3_obj'
        );
    }

    public function submissoes_norte()
    {
        return SubmissaoRegionalNorte::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'avaliacao.avaliador_1_obj',
            'avaliacao.avaliador_2_obj',
            'avaliacao.avaliador_3_obj'
        );
    }

    public function submissoes_nordeste()
    {
        return SubmissaoRegionalNordestes::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'avaliacao.avaliador_1_obj',
            'avaliacao.avaliador_2_obj',
            'avaliacao.avaliador_3_obj'
        );
    }

    public function submissoes_centrooeste()
    {
        return SubmissaoRegionalCentrooeste::select('id', 'inscricao_id', 'avaliacao', 'regiao', 'dt', 'titulo', 'link_trabalho', 'tipo')
        ->with(
            'avaliacao',
            'avaliacao.avaliador_1_obj',
            'avaliacao.avaliador_2_obj',
            'avaliacao.avaliador_3_obj'
        );
    }

    public function get(Request $request)
    {
        if(isset($request->regiao) && $request->regiao == "Sudeste"){
            return $this->submissoes_sudeste()
                ->when($request->sort == 'id', function ($query) use ($request) {
                    $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->sort == 'dt', function ($query) use ($request) {
                    $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->when($request->type == 'titulo', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        });
                    });
                })
                ->when($request->modalidade, function ($query) use ($request){
                    $query->where('dt', '=', $request->modalidade);
                })
                ->whereHas('avaliacao', function($q) {
                    $q->where('status_coordenador', '=', "Aceito");
                })
            ->paginate(20);
        }

        if(isset($request->regiao) && $request->regiao == "Sul"){
            return $this->submissoes_sul()
            ->when($request->sort == 'id', function ($query) use ($request) {
                $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->sort == 'dt', function ($query) use ($request) {
                $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->when($request->type == 'titulo', function ($query) use ($request) {
                        $query->where('titulo', 'like', '%' . $request->search . '%');
                    });
                });
            })
            ->when($request->modalidade, function ($query) use ($request){
                $query->where('dt', '=', $request->modalidade);
            })
            ->whereHas('avaliacao', function($q) {
                $q->where('status_coordenador', '=', "Aceito");
            })
        ->paginate(20);
        }

        if(isset($request->regiao) && $request->regiao == "Norte"){
            return $this->submissoes_norte()
                ->when($request->sort == 'id', function ($query) use ($request) {
                    $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->sort == 'dt', function ($query) use ($request) {
                    $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->when($request->type == 'titulo', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        });
                    });
                })
                ->when($request->modalidade, function ($query) use ($request){
                    $query->where('dt', '=', $request->modalidade);
                })
                ->whereHas('avaliacao', function($q) {
                    $q->where('status_coordenador', '=', "Aceito");
                })
            ->paginate(20);
        }

        if(isset($request->regiao) && $request->regiao == "Nordeste"){
            return $this->submissoes_nordeste()
                ->when($request->sort == 'id', function ($query) use ($request) {
                    $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->sort == 'dt', function ($query) use ($request) {
                    $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->when($request->type == 'titulo', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        });
                    });
                })
                ->when($request->modalidade, function ($query) use ($request){
                    $query->where('dt', '=', $request->modalidade);
                })
                ->whereHas('avaliacao', function($q) {
                    $q->where('status_coordenador', '=', "Aceito");
                })
            ->paginate(20);
        }

        if(isset($request->regiao) && $request->regiao == "Centro-Oeste"){
            return $this->submissoes_centrooeste()
                ->when($request->sort == 'id', function ($query) use ($request) {
                    $query->orderBy('id', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->sort == 'dt', function ($query) use ($request) {
                    $query->orderBy('dt', $request->asc == 'true' ? 'ASC' : 'DESC');
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->when($request->type == 'titulo', function ($query) use ($request) {
                            $query->where('titulo', 'like', '%' . $request->search . '%');
                        });
                    });
                })
                ->when($request->modalidade, function ($query) use ($request){
                    $query->where('dt', '=', $request->modalidade);
                })
                ->whereHas('avaliacao', function($q) {
                    $q->where('status_coordenador', '=', "Aceito");
                })
            ->paginate(20);
        }
    }

}
