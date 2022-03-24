<?php

namespace App\Http\Controllers;

use App\Models\CoautorOrientadorSubCentrooeste;
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoRegionalCentrooesteController extends Controller
{
    public function usuario(){
        return User::select('id', 'name')
            ->with(
                'todos_tipos:id,descricao',
                'todos_divisoes_tematicas:id,descricao',
                'todos_divisoes_tematicas_jr:id,descricao',
                'todos_cinema_audiovisual:id,descricao',
                'todos_jornalismo:id,descricao',
                'todos_publicidade_propaganda:id,descricao',
                'todos_relacoes_publicas:id,descricao',
                'todos_producao_editorial:id,descricao',
                'todos_radio_internet:id,descricao',
                'associado',
                'enderecos',
                'regional_centrooeste',
                'regional_centrooeste.submissaoMesa',
                'regional_centrooeste.submissaoDt',
                'regional_centrooeste.submissaoJunior',
                'regional_centrooeste.submissaoExpocom',
                'regional_centrooeste.submissaoDt.coautorOrientadorSubCentrooeste',
                'regional_centrooeste.submissaoJunior.coautorOrientadorSubCentrooeste',
                'regional_centrooeste.submissaoMesa.coautorOrientadorSubCentrooeste',
                'regional_centrooeste.submissaoExpocom.coautorOrientadorSubCentrooeste'
                )
                ->find(Auth::user()->id);
    }

    public function submissaoJuniorRegionalCentrooeste(){
        $user = $this->usuario();
        $regiao = 4;
        $tipo = 1;

        return view('regionais.centrooeste.submissaoJunior', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoRegionalCentrooeste(){
        $user = $this->usuario();
        $regiao = 4;
        $tipo = 2;

        return view('regionais.centrooeste.submissao', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoMesaRegionalCentrooeste(){
        $user = $this->usuario();
        $regiao = 4;
        $tipo = 3;

        return view('regionais.centrooeste.submissaoMesa', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoExpocomRegionalCentrooeste(){
        $user = $this->usuario();
        $regiao = 4;
        $tipo = 4;

        return view('regionais.centrooeste.submissaoExpocom', compact('user', 'regiao', 'tipo'));
    }

    public function store(Request $request){
        try{
            $post = json_decode($request->post);
            $user = User::findOrFail(Auth::user()->id);
            $submissao = SubmissaoRegionalCentrooeste::where('id', $post->id ?? null)->first();

            //IDS DOS COAUTORES QUE FORAM ENVIADOS PELO FORMULÁRIO
            $coautor_ids = array_map(function ($res) {
                return $res->id ?? null;
            }, $post->coautoresOrientadores);
    
            if(!empty($submissao) && $submissao->tipo == $post->tipo->name)
            {

                $coautores = CoautorOrientadorSubCentrooeste::where('submissao_id', $submissao->id)->get();
                foreach($coautores as $coautor){
                    if(!in_array($coautor->id, $coautor_ids)){
                        $coautor->delete();
                    }
                }
            }
            if(empty($submissao) || $submissao->tipo != $post->tipo->name){
                $submissao_save = SubmissaoRegionalCentrooeste::create([
                    'inscricao_id' => $user->regional_centrooeste->id,
                    'dt' => $post->divisoes_tematicas[0],
                    'ciente' => $post->ciente,
                    'tipo' => $post->tipo->name,
                    'titulo' => $post->titulo,
                    'palavra_chave_1' => $post->palavra_chave_1,
                    'palavra_chave_2' => $post->palavra_chave_2,
                    'palavra_chave_3' => $post->palavra_chave_3,
                    'palavra_chave_4' => $post->palavra_chave_4,
                    'palavra_chave_5' => $post->palavra_chave_5,
                    'termo_autoria' => $post->termo_autoria,
                    'autorizacao' => $post->autorizacao
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_regional_centrooeste_2022/" , $name);
                    $submissao_save->link_trabalho = $name;
                    $submissao_save->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoautorOrientadorSubCentrooeste::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao_save->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoautorOrientadorSubCentrooeste::create([
                            'submissao_id' => $submissao_save->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }
                }
            }

            if(!empty($submissao) && $submissao->tipo == $post->tipo->name){
                $submissao->update([
                    'tipo' => $post->tipo->name,
                    'dt' => $post->divisoes_tematicas[0],
                    'ciente' => $post->ciente,
                    'titulo' => $post->titulo,
                    'palavra_chave_1' => $post->palavra_chave_1,
                    'palavra_chave_2' => $post->palavra_chave_2,
                    'palavra_chave_3' => $post->palavra_chave_3,
                    'palavra_chave_4' => $post->palavra_chave_4,
                    'palavra_chave_5' => $post->palavra_chave_5,
                    'termo_autoria' => $post->termo_autoria,
                    'autorizacao' => $post->autorizacao
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_regional_centrooeste_2022/" , $name);
                    $submissao->link_trabalho = $name;
                    $submissao->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoautorOrientadorSubCentrooeste::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoautorOrientadorSubCentrooeste::create([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }
                }
                
            }

            Log::info('User: '. Auth::user()->id . ' | Regional Centrooestes 2022 | Submeteu seu trabalho: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $user], 201);


        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}