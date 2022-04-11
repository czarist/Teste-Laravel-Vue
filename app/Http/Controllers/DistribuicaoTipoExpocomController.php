<?php

namespace App\Http\Controllers;

use App\Models\DistribuicaoTipoExpocom;
use App\Models\DivisoesTematicas;
use App\Models\SubmissaoExpocomRegionalSul;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\SubmissaoExpocomRegionalNorte;
use App\Models\SubmissaoExpocomRegionalCentrooeste;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Services\CreateChatAvaliacaoExpocom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DistribuicaoTipoExpocomController extends Controller
{
    public function index()
    {
        return view('regionais.avaliacaoExpocom.index');
    }

    public function view($regiao){
        $regiao = $regiao;

        return view('regionais.avaliacaoExpocom.index', compact('regiao'));
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
            'link_trabalho',
            )
            ->with(
               'inscricao',
               'inscricao.user:id,cpf',
               'inscricao.user.indicacao',
               'avaliacao',
               'avaliacao.avaliador_1_obj',
               'avaliacao.avaliador_2_obj',
               'avaliacao.avaliador_3_obj',
               'coautorOrientadorSubSuls'
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
            'link_trabalho',
            )
            ->with(
               'inscricao',
               'inscricao.user:id,cpf',
               'inscricao.user.indicacao',
               'avaliacao',
               'avaliacao.avaliador_1_obj',
               'avaliacao.avaliador_2_obj',
               'avaliacao.avaliador_3_obj',
               'coautorOrientadorSubSudeste'
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
            'link_trabalho',
            )
            ->with(
               'inscricao',
               'inscricao.user:id,cpf',
               'inscricao.user.indicacao',
               'avaliacao',
               'avaliacao.avaliador_1_obj',
               'avaliacao.avaliador_2_obj',
               'avaliacao.avaliador_3_obj',
               'coautorOrientadorSubNortes'
            );
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
               'inscricao.user:id,cpf',
               'inscricao.user.indicacao',
               'avaliacao',
               'avaliacao.avaliador_1_obj',
               'avaliacao.avaliador_2_obj',
               'avaliacao.avaliador_3_obj',
               'coautorOrientadorSubNordeste'
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
            'link_trabalho',
            )
            ->with(
               'inscricao',
               'inscricao.user:id,cpf',
               'inscricao.user.indicacao',
               'avaliacao',
               'avaliacao.avaliador_1_obj',
               'avaliacao.avaliador_2_obj',
               'avaliacao.avaliador_3_obj',
               'coautorOrientadorSubCentrooeste'
            );
    }

    public function get(Request $request)
    {
        if(Auth::user() && Auth::user()->coordenador_regional){

            $dt = Auth::user()->coordenador_regional->dt ?? 1;

            if($request && $request->regiao && $request->regiao == 1){
                                
                return $this->submissao_sul()
                    ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                        $query->where('categoria', $dt);
                    })
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){

                            $q->where('status_avaliador_1', '=', $request->statusAva)
                            ->orWhere('status_avaliador_2', "=", $request->statusAva)
                            ->orWhere('status_avaliador_3', "=", $request->statusAva);
                        });    
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });      
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('desc_obj_estudo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                            $q->where('modalidade', '=', $request->modalidade);
                        });
                    })
                ->paginate(10);
            }

            if($request && $request->regiao && $request->regiao == 3){

                return $this->submissao_sudeste()
                    ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                        $query->where('categoria', $dt);
                    })
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){

                            $q->where('status_avaliador_1', '=', $request->statusAva)
                            ->orWhere('status_avaliador_2', "=", $request->statusAva)
                            ->orWhere('status_avaliador_3', "=", $request->statusAva);
                        });    
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });      
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('desc_obj_estudo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                            $q->where('modalidade', '=', $request->modalidade);
                        });
                    })
                ->paginate(10);
            }

            if($request && $request->regiao && $request->regiao == 5){

                return $this->submissao_norte()
                    ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                        $query->where('categoria', $dt);
                    })
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){

                            $q->where('status_avaliador_1', '=', $request->statusAva)
                            ->orWhere('status_avaliador_2', "=", $request->statusAva)
                            ->orWhere('status_avaliador_3', "=", $request->statusAva);
                        });    
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });      
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('desc_obj_estudo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                            $q->where('modalidade', '=', $request->modalidade);
                        });
                    })
                ->paginate(10);
            }

            if($request && $request->regiao && $request->regiao == 2){

                return $this->submissao_nordeste()
                    ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                        $query->where('categoria', $dt);
                    })
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){

                            $q->where('status_avaliador_1', '=', $request->statusAva)
                            ->orWhere('status_avaliador_2', "=", $request->statusAva)
                            ->orWhere('status_avaliador_3', "=", $request->statusAva);
                        });    
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });      
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('desc_obj_estudo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                            $q->where('modalidade', '=', $request->modalidade);
                        });
                    })
                ->paginate(10);
            }

            if($request && $request->regiao && $request->regiao == 4){

                return $this->submissao_centrooeste()
                    ->wherehas('inscricao.user.indicacao', function($query) use ($dt){
                        $query->where('categoria', $dt);
                    })
                    ->when($request->statusAva, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){

                            $q->where('status_avaliador_1', '=', $request->statusAva)
                            ->orWhere('status_avaliador_2', "=", $request->statusAva)
                            ->orWhere('status_avaliador_3', "=", $request->statusAva);
                        });    
                    })
                    ->when($request->statusCoo, function ($query) use ($request) {
                        $query->wherehas('avaliacao', function($q) use ($request){
                            $q->where('status_coordenador', '=', $request->statusCoo);
                        });      
                    })
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->when($request->type == 'titulo', function ($query) use ($request) {
                                $query->where('desc_obj_estudo', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->modalidade, function ($query) use ($request){
                        $query->whereHas('inscricao.user.indicacao', function ($q) use ($request){
                            $q->where('modalidade', '=', $request->modalidade);
                        });
                    })
                ->paginate(10);
            }
        }
    }

    public function store(Request $request)
    {
        try{
            $post = $request->all();

            $distribuicao = DistribuicaoTipoExpocom::create([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'status_avaliador_1' => $post['status_avaliador_1'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'status_avaliador_2' => $post['status_avaliador_2'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
                'status_avaliador_3' => $post['status_avaliador_3'] ?? null,
                'status_coordenador' => "Em Análise"
            ]);

            if($post['regiao'] == 1){
                $submissao = SubmissaoExpocomRegionalSul::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 2){
                $submissao = SubmissaoExpocomRegionalNordeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 3){
                $submissao = SubmissaoExpocomRegionalSudeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 4){
                $submissao = SubmissaoExpocomRegionalCentrooeste::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            if($post['regiao'] == 5){
                $submissao = SubmissaoExpocomRegionalNorte::find($post['submissao_id']);
                $submissao->update([
                    'avaliacao' => $distribuicao->id,
                ]);
            }

            Log::info('Distribuicao de trabalho  create: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);
    
        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        $distribuicao = DistribuicaoTipoExpocom::findOrFail($request->id);
        
        try{
            $post = $request->all();

            $distribuicao->update([
                'avaliador_1' => $post['avaliador_1']['id'] ?? null,
                'status_avaliador_1' => $post['status_avaliador_1'] ?? null,
                'avaliador_2' => $post['avaliador_2']['id'] ?? null,
                'status_avaliador_2' => $post['status_avaliador_2'] ?? null,
                'avaliador_3' => $post['avaliador_3']['id'] ?? null,
                'status_avaliador_3' => $post['status_avaliador_3'] ?? null,
            ]);

            Log::info('Distribuicao de trabalho updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
    
    public function avaliadorSave(Request $request)
    {
        $distribuicao = DistribuicaoTipoExpocom::findOrFail($request->id);

        try{
            $post = $request->all();

            if($distribuicao->avaliador_1 == Auth::user()->id){
                $distribuicao->update([
                    'justificativa_avaliador_1' => $post['justificativa_avaliador'] ?? null,
                    'expe_1' => $post['expe'] ?? null,
                    'qualidade_1' => $post['qualidade'] ?? null,
                    'coerencia_1' => $post['coerencia'] ?? null,
                    'media_1' => $post['media'] ?? null,
                    'status_avaliador_1' => "Avaliado"
                ]);

                if($post['justificativa_avaliador'] != null){
                    $chat = CreateChatAvaliacaoExpocom::create($distribuicao->id,$distribuicao->avaliador_1,null,$post['justificativa_avaliador'] ?? null, 1);
                }
            }

            if($distribuicao->avaliador_2 == Auth::user()->id){
                $distribuicao->update([
                    'justificativa_avaliador_2' => $post['justificativa_avaliador'] ?? null,
                    'expe_2' => $post['expe'] ?? null,
                    'qualidade_2' => $post['qualidade'] ?? null,
                    'coerencia_2' => $post['coerencia'] ?? null,
                    'media_2' => $post['media'] ?? null,
                    'status_avaliador_2' => "Avaliado"
                ]);

                if($post['justificativa_avaliador'] != null){

                    $chat = CreateChatAvaliacaoExpocom::create(
                        $distribuicao->id,
                        $distribuicao->avaliador_2,
                        null,
                        $post['justificativa_avaliador'] ?? null, 2);
                }
            }

            if($distribuicao->avaliador_3 == Auth::user()->id){
                $distribuicao->update([
                    'status_avaliador_3' => $post['status_avaliador'],
                    'justificativa_avaliador_3' => $post['justificativa_avaliador'] ?? null,
                    'expe_3' => $post['expe'] ?? null,
                    'qualidade_3' => $post['qualidade'] ?? null,
                    'coerencia_3' => $post['coerencia'] ?? null,
                    'media_3' => $post['media'] ?? null,
                    'status_avaliador_3' => "Avaliado"
                ]);

                if($post['justificativa_avaliador'] != null){

                    $chat = CreateChatAvaliacaoExpocom::create(
                        $distribuicao->id,
                        $distribuicao->avaliador_3,
                        null,
                        $post['justificativa_avaliador'] ?? null, 
                        3
                    );
                }
            }

            if($distribuicao->media_1 != null && $distribuicao->media_2 != null && $distribuicao->media_3 != null){

                $soma_media = $distribuicao->media_1 + $distribuicao->media_2 + $distribuicao->media_3;

                $media_final = $soma_media / 3;

            } else if (
                $distribuicao->media_1 != null && $distribuicao->media_2 != null && $distribuicao->media_3 == null
            ){
                $soma_media = $distribuicao->media_1  + $distribuicao->media_2;

                $media_final = $soma_media / 2;
            } else if (
                $distribuicao->media_1 != null && $distribuicao->media_2 == null && $distribuicao->media_3 != null
            ){
                $soma_media = $distribuicao->media_1  + $distribuicao->media_3;

                $media_final = $soma_media / 2;
            } else if (
                $distribuicao->media_1 == null && $distribuicao->media_2 != null && $distribuicao->media_3 != null
            ){
                $soma_media = $distribuicao->media_2  + $distribuicao->media_3;

                $media_final = $soma_media / 2;
            }else if (
                $distribuicao->media_1 == null && $distribuicao->media_2 == null && $distribuicao->media_3 != null
            ){
                $media_final = $distribuicao->media_3;
            }else if (
                $distribuicao->media_1 == null && $distribuicao->media_2 != null && $distribuicao->media_3 == null
            ){
                $media_final = $distribuicao->media_2;
            }else if (
                $distribuicao->media_1 != null && $distribuicao->media_2 == null && $distribuicao->media_3 == null
            ){
                $media_final = $distribuicao->media_1;
            }

            if($media_final != null){
                $distribuicao->update([
                    'media_final' => $media_final,
                ]);
            }                

            Log::info('Distribuicao de trabalho Tipo Expocom status e justificativa avaliador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function coordenadorSave(Request $request)
    {
        $distribuicao = DistribuicaoTipoExpocom::findOrFail($request->id);
        
        try{
            $post = $request->all();

            $distribuicao->update([
                'status_coordenador' => $post['status_coordenador'],
                "justificativa_coordenador" =>$post['justificativa_coordenador'] ?? null
            ]);

            Log::info('Distribuicao de trabalho status e justificativa coordenador updated: '.$distribuicao->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $distribuicao], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

}
