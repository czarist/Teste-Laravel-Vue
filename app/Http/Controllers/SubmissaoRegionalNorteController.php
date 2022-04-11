<?php

namespace App\Http\Controllers;

use App\Models\CoautorOrientadorSubNorte;
use App\Models\DistribuicaoTipo123;
use App\Models\SubmissaoRegionalNorte;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoRegionalNorteController extends Controller
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
                'regional_norte',
                'regional_norte.submissaoMesa.avaliacao',
                'regional_norte.submissaoDt.avaliacao',
                'regional_norte.submissaoJunior.avaliacao',
                'regional_norte.submissaoExpocom.avaliacao',
                'regional_norte.submissaoDt.coautorOrientadorSubNortes',
                'regional_norte.submissaoJunior.coautorOrientadorSubNortes',
                'regional_norte.submissaoMesa.coautorOrientadorSubNortes',
                'regional_norte.submissaoExpocom.coautorOrientadorSubNortes'
                )
                ->find(Auth::user()->id);
    }

    public function submissaoJuniorRegionalNorte(){
        $user = $this->usuario();
        $regiao = 5;
        $tipo = 1;

        return view('regionais.norte.submissaoJunior', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoRegionalNorte(){
        $user = $this->usuario();
        $regiao = 5;
        $tipo = 2;

        return view('regionais.norte.submissao', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoMesaRegionalNorte(){
        $user = $this->usuario();
        $regiao = 5;
        $tipo = 3;

        return view('regionais.norte.submissaoMesa', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoExpocomRegionalNorte(){
        $user = $this->usuario();
        $regiao = 5;
        $tipo = 4;

        return view('regionais.norte.submissaoExpocom', compact('user', 'regiao', 'tipo'));
    }

    public function store(Request $request){
        try{
            $post = json_decode($request->post);
            $user = User::findOrFail(Auth::user()->id);
            $submissao = SubmissaoRegionalNorte::where('id', $post->id ?? null)->first();

            //IDS DOS COAUTORES QUE FORAM ENVIADOS PELO FORMULÁRIO
            $coautor_ids = array_map(function ($res) {
                return $res->id ?? null;
            }, $post->coautoresOrientadores);
    
            if(!empty($submissao) && $submissao->tipo == $post->tipo->name)
            {

                $coautores = CoautorOrientadorSubNorte::where('submissao_id', $submissao->id)->get();
                foreach($coautores as $coautor){
                    if(!in_array($coautor->id, $coautor_ids)){
                        $coautor->delete();
                    }
                }
            }

            if(empty($submissao) || $submissao->tipo != $post->tipo->name){
                $submissao_save = SubmissaoRegionalNorte::create([
                    'inscricao_id' => $user->regional_norte->id,
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
                    'autorizacao' => $post->autorizacao,
                    'regiao' => 5
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_regional_norte_2022/" , $name);
                    $submissao_save->link_trabalho = $name;
                    $submissao_save->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoautorOrientadorSubNorte::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao_save->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoautorOrientadorSubNorte::create([
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
                    'autorizacao' => $post->autorizacao,
                    'regiao' => 5
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_regional_norte_2022/" , $name);
                    $submissao->link_trabalho = $name;
                    $submissao->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoautorOrientadorSubNorte::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoautorOrientadorSubNorte::create([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }
                }

                if($submissao && $submissao->id){
                    $sub = SubmissaoRegionalNorte::select('id', 'avaliacao')
                    ->with('avaliacao')
                    ->whereId($submissao->id)->first();
    
                    $avaliacao = DistribuicaoTipo123::where('id', $sub->avaliacao)->first();
                    if(!empty($avaliacao)){
                        $avaliacao->update([
                            'edit' => 1,
                        ]);
                    }                    
                }                                                            
            }

            Log::info('User: '. Auth::user()->id . ' | Regional Norte 2022 | Submeteu seu trabalho: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $user], 201);

        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

}
