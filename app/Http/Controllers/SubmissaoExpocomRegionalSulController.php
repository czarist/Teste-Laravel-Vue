<?php

namespace App\Http\Controllers;

use App\Models\CoauOriExpoSubSul;
use App\Models\SubmissaoExpocomRegionalSul;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoExpocomRegionalSulController extends Controller
{
    public function store(Request $request){

        try{
            $post = json_decode($request->post);

            $user = User::findOrFail(Auth::user()->id);
            $submissao = $user->regional_sul->submissaoExpocom;

            //IDS DOS COAUTORES QUE FORAM ENVIADOS PELO FORMULÁRIO
            $coautor_ids = array_map(function ($res) {
                return $res->id ?? null;
            }, $post->coautoresOrientadores);
    
            if(!empty($submissao)){

                $coautores = CoauOriExpoSubSul::where('submissao_id', $submissao->id)->get();
                foreach($coautores as $coautor){
                    if(!in_array($coautor->id, $coautor_ids)){
                        $coautor->delete();
                    }
                }
            }

            if(empty($submissao)){
                $submissao_save = SubmissaoExpocomRegionalSul::create([
                    'inscricao_id' => $user->regional_sul->id,
                    'tipo' => $post->tipo->name,
                    'ano' => $post->ano,
                    'campus' => $post->campus,
                    'desc_obj_estudo' => $post->desc_obj_estudo,
                    'desc_pesquisa' => $post->desc_pesquisa,
                    'desc_producao' => $post->desc_producao,
                    'termo_autoria' => $post->termo_autoria,
                    'autorizacao' => $post->autorizacao,
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_expocom_regional_sul_2022/" , $name);
                    $submissao_save->link_trabalho = $name;
                    $submissao_save->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoauOriExpoSubSul::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao_save->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria,
                            'curso_coautor' => $coautor->curso_coautor
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoauOriExpoSubSul::create([
                            'submissao_id' => $submissao_save->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria,
                            'curso_coautor' => $coautor->curso_coautor
                        ]);
                    }
                }
            }

            if(!empty($submissao)){
                $submissao->update([
                    'tipo' => $post->tipo->name,
                    'ano' => $post->ano,
                    'campus' => $post->campus,
                    'desc_obj_estudo' => $post->desc_obj_estudo,
                    'desc_pesquisa' => $post->desc_pesquisa,
                    'desc_producao' => $post->desc_producao,
                    'termo_autoria' => $post->termo_autoria,
                    'autorizacao' => $post->autorizacao,
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_expocom_regional_sul_2022/" , $name);
                    $submissao->link_trabalho = $name;
                    $submissao->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoauOriExpoSubSul::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria,
                            'curso_coautor' => $coautor->curso_coautor,
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoauOriExpoSubSul::create([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria,
                            'curso_coautor' => $coautor->curso_coautor
                        ]);
                    }
                }
                
            }

            Log::info('User: '. Auth::user()->id . ' | Regional Sul 2022 | Submeteu seu trabalho: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $submissao], 201);


        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
