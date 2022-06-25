<?php

namespace App\Http\Controllers;

use App\Models\ChatAvaliacao;
use App\Models\CoautorOrientadorSubNorte;
use App\Models\Coordenador;
use App\Models\DistribuicaoTipo123;
use App\Models\SubmissaoRegionalNorte;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

            //verificar submissão
            $user_sub = User::with(
                'regional_norte',
                'regional_norte.submissaoMesa',
                'regional_norte.submissaoDt',
                'regional_norte.submissaoJunior',
            )
            ->findOrFail($user->id);

            if($post->id == null && $user_sub && $user_sub->regional_norte && $user_sub->regional_norte->submissaoMesa){
                $post->id = $user_sub->regional_norte->submissaoMesa->id;
            } 
            if($post->id == null && $user_sub && $user_sub->regional_norte && $user_sub->regional_norte->submissaoDt){
                $post->id = $user_sub->regional_norte->submissaoDt->id;
            } 
            if($post->id == null && $user_sub && $user_sub->regional_norte && $user_sub->regional_norte->submissaoJunior){
                $post->id = $user_sub->regional_norte->submissaoJunior->id;
            } 


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

            $now = Carbon::now()->format('Y-m-d H:i:s');

            if($now <= '2022-04-25 00:00:00'){

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

            Log::info('User: '. Auth::user()->id . ' | Regional Norte 2022 | Submeteu seu trabalho: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $user], 201);

        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

}