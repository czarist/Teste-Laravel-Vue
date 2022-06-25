<?php

namespace App\Http\Controllers;

use App\Models\ChatAvaliacao;
use App\Models\CoauOriExpoSubSudeste;
use App\Models\CoautorOrientadorSubSudeste;
use App\Models\Coordenador;
use App\Models\DistribuicaoTipo123;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubmissaoRegionalSudesteController extends Controller
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
                'regional_suldeste',
                'regional_suldeste.submissaoMesa.avaliacao',
                'regional_suldeste.submissaoDt.avaliacao',
                'regional_suldeste.submissaoJunior.avaliacao',
                'regional_suldeste.submissaoExpocom.avaliacao',
                'regional_suldeste.submissaoDt.coautorOrientadorSubSudeste',
                'regional_suldeste.submissaoJunior.coautorOrientadorSubSudeste',
                'regional_suldeste.submissaoMesa.coautorOrientadorSubSudeste',
                'regional_suldeste.submissaoExpocom.coautorOrientadorSubSudeste'
                )
                ->find(Auth::user()->id);
    }

    public function submissaoJuniorRegionalSudeste(){
        $user = $this->usuario();
        $regiao = 3;
        $tipo = 1;

        return view('regionais.suldeste.submissaoJunior', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoRegionalSudeste(){
        $user = $this->usuario();
        $regiao = 3;
        $tipo = 2;

        return view('regionais.suldeste.submissao', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoMesaRegionalSudeste(){
        $user = $this->usuario();
        $regiao = 3;
        $tipo = 3;

        return view('regionais.suldeste.submissaoMesa', compact('user', 'regiao', 'tipo'));
    }

    public function submissaoExpocomRegionalSudeste(){
        $user = $this->usuario();
        $regiao = 3;
        $tipo = 4;

        return view('regionais.suldeste.submissaoExpocom', compact('user', 'regiao', 'tipo'));
    }

    public function store(Request $request){
        try{
            $post = json_decode($request->post);
            $user = User::findOrFail(Auth::user()->id);

            //verificar submissão
            $user_sub = User::with(
                'regional_suldeste',
                'regional_suldeste.submissaoMesa',
                'regional_suldeste.submissaoDt',
                'regional_suldeste.submissaoJunior',
            )
            ->findOrFail($user->id);

            if($post->id == null && $user_sub && $user_sub->regional_suldeste && $user_sub->regional_suldeste->submissaoMesa){
                $post->id = $user_sub->regional_suldeste->submissaoMesa->id;
            } 
            if($post->id == null && $user_sub && $user_sub->regional_suldeste && $user_sub->regional_suldeste->submissaoDt){
                $post->id = $user_sub->regional_suldeste->submissaoDt->id;
            } 
            if($post->id == null && $user_sub && $user_sub->regional_suldeste && $user_sub->regional_suldeste->submissaoJunior){
                $post->id = $user_sub->regional_suldeste->submissaoJunior->id;
            } 
                                    
            $submissao = SubmissaoRegionalSudeste::where('id', $post->id ?? null)->first();

            //IDS DOS COAUTORES QUE FORAM ENVIADOS PELO FORMULÁRIO
            $coautor_ids = array_map(function ($res) {
                return $res->id ?? null;
            }, $post->coautoresOrientadores);
    
            if(!empty($submissao) && $submissao->tipo == $post->tipo->name)
            {

                $coautores = CoautorOrientadorSubSudeste::where('submissao_id', $submissao->id)->get();
                foreach($coautores as $coautor){
                    if(!in_array($coautor->id, $coautor_ids)){
                        $coautor->delete();
                    }
                }
            }

            $now = Carbon::now()->format('Y-m-d H:i:s');

            if($now <= '2022-05-07 00:00:00'){

                if(empty($submissao) || $submissao->tipo != $post->tipo->name){
                    $submissao_save = SubmissaoRegionalSudeste::create([
                        'inscricao_id' => $user->regional_suldeste->id,
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
                        'regiao' => 3
                    ]);

                    if($request->hasFile('file')){
                        $file = $request->file('file');
                        $name = date('mdYHis') . uniqid();
                        $file->move(public_path()."/pdf/submissao_regional_suldeste_2022/" , $name);
                        $submissao_save->link_trabalho = $name;
                        $submissao_save->save();
                    }

                    foreach($post->coautoresOrientadores as $coautor){
                        if(!empty($coautor->id)){

                            $coautor_save = CoautorOrientadorSubSudeste::findOrFail($coautor->id);

                            $coautor_save->update([
                                'submissao_id' => $submissao_save->id,
                                'nome_completo' => $coautor->nome_completo,
                                'cpf' => $coautor->cpf,
                                'categoria' => $coautor->categoria
                            ]);
                        }

                        if(empty($coautor->id)){
                            $coautor_save = CoautorOrientadorSubSudeste::create([
                                'submissao_id' => $submissao_save->id,
                                'nome_completo' => $coautor->nome_completo,
                                'cpf' => $coautor->cpf,
                                'categoria' => $coautor->categoria
                            ]);
                        }
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
                    'regiao' => 3
                ]);

                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = date('mdYHis') . uniqid();
                    $file->move(public_path()."/pdf/submissao_regional_suldeste_2022/" , $name);
                    $submissao->link_trabalho = $name;
                    $submissao->save();
                }

                foreach($post->coautoresOrientadores as $coautor){
                    if(!empty($coautor->id)){

                        $coautor_save = CoautorOrientadorSubSudeste::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }

                    if(empty($coautor->id)){
                        $coautor_save = CoautorOrientadorSubSudeste::create([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria
                        ]);
                    }
                }

                if($submissao && $submissao->id){
                    $sub = SubmissaoRegionalSudeste::select('id', 'avaliacao')
                    ->with('avaliacao')
                    ->whereId($submissao->id)->first();
    
                    $avaliacao = DistribuicaoTipo123::where('id', $sub->avaliacao)->first();

                    if(!empty($avaliacao) && $avaliacao->edit == 1){
                        //Enviar Email para o coordenador que a submissao foi alterada
                        try{
                            if($sub->avaliacao){
                                $coordenador_id = ChatAvaliacao::select('id', 'coordenador_id')
                                ->whereAvaliacaoId($sub->avaliacao)
                                ->whereNotNull('coordenador_id')->first();
        
                                if($coordenador_id && $coordenador_id->coordenador_id){
                                    $coordenador = Coordenador::findOrFail($coordenador_id->coordenador_id);
                                }
            
                                $dados['user'] = User::findOrFail($coordenador->user_id);
                                $emails = $dados['user']->email;
    
                                if($submissao){
                                    $dados['titulo'] = $submissao->titulo;
                                }
                
                                if(!empty($emails)){
                                    Mail::send('email.submissao_alterada', $dados, function ($email) use ($emails, $dados) {
                                        if (App::environment('production')) {
                                            $email->to($emails);
                                        } else {
                                            $email->to('murilo@kirc.com.br');
                                        }
                                        $email->subject('Nova mensagem recebida | Intercom');
                
                                        Log::info('E-mail Enviado para o coordenador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                                    });    
                                }            
                            }
                        } catch (Exception $e) {
                            Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
                        }
                    }

                    if(!empty($avaliacao)){
                        $avaliacao->update([
                            'edit' => 0,
                        ]);
                    }                    
                }                                               
            }

            Log::info('User: '. Auth::user()->id . ' | Regional Sudeste 2022 | Submeteu seu trabalho: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $user], 201);
            
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
