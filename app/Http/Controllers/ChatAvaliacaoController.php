<?php

namespace App\Http\Controllers;

use App\Models\ChatAvaliacao;
use App\Models\ChatAvaliacaoExpocom;
use App\Models\ChatAvaliador;
use App\Models\Coordenador;
use App\Models\DistribuicaoTipo123;
use App\Models\DistribuicaoTipoExpocom;
use App\Models\User;
use App\Services\CreateChatAvaliacao;
use App\Services\CreateChatAvaliacaoExpocom;
use App\Services\CreateChatAvaliador;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChatAvaliacaoController extends Controller
{

    public function getChat($avaliacao_id){

        return ChatAvaliacao::select('id','avaliacao_id','avaliado_id','avaliador_id','coordenador_id','mensagem', 'created_at')
            ->with('avaliador', 'avaliado', 'coordenador:id,user_id', 'coordenador.user:id,name')
            ->where('avaliacao_id', $avaliacao_id)
            ->get();
    }

    public function sendMensagem(Request $request){

        // dd($request->all());

        $distribuicao = DistribuicaoTipo123::select('id')
            ->with(
                'submissaoNordeste',
                'submissaoNordeste.inscricao',
                'submissaoNordeste.inscricao.user:id,name,email',
                'submissaoSul',
                'submissaoSul.inscricao',
                'submissaoSul.inscricao.user:id,name,email',
                'submissaoSudeste',
                'submissaoSudeste.inscricao',
                'submissaoSudeste.inscricao.user:id,name,email',
                'submissaoCentroOeste',
                'submissaoCentroOeste.inscricao',
                'submissaoCentroOeste.inscricao.user:id,name,email',
                'submissaoNorte',
                'submissaoNorte.inscricao',
                'submissaoNorte.inscricao.user:id,name,email',
            )
        ->find($request->avaliacao_id);

        if($distribuicao && $distribuicao->submissaoNordeste){
            $submissao = $distribuicao->submissaoNordeste;
        }

        if($distribuicao && $distribuicao->submissaoSul){
            $submissao = $distribuicao->submissaoSul;
        }

        if($distribuicao && $distribuicao->submissaoSudeste){
            $submissao = $distribuicao->submissaoSudeste;
        }

        if($distribuicao && $distribuicao->submissaoCentroOeste){
            $submissao = $distribuicao->submissaoCentroOeste;
        }

        if($distribuicao && $distribuicao->submissaoNorte){
            $submissao = $distribuicao->submissaoNorte;
        }

        if($request->avaliacao_id){
            $avaliacao = CreateChatAvaliacao::create($request->avaliacao_id, $request->avaliado_id, $request->avaliador_id, $request->coordenador_id, $request->mensagem);
            $avaliacao->load('avaliacao','avaliador','avaliado','coordenador.user:id,name');

            $dados['mensagem'] = $request->mensagem;

            if($request && $request->coordenador_id){
                // Enviar e-mail informando ao Avaliador que tem uma nova mensagem no chat
                try {
    
                    if($request->send_avaliador == null){
                        $dados['user'] = $submissao->inscricao->user;
                    }
        
                    $emails = $dados['user']['email'];
    
                    if($submissao){
                        $dados['titulo'] = $submissao->titulo;
                    }
    
                    Mail::send('email.chat_dt_avaliador', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Mensagem Avaliação | Intercom');
                            Log::info('E-mail Enviado para o avaliador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                    });
    
                } catch (Exception $e) {
                    Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
                }
            }
    
            if($request->coordenador_id == null){
                // Enviar e-mail informando ao avaliador que tem uma nova mensagem no chat
                try {
                           
                    if($request->avaliacao_id){
    
                        $coordenador = ChatAvaliacao::select('id', 'coordenador_id')
                        ->whereAvaliacaoId($request->avaliacao_id)
                        ->whereNotNull('coordenador_id')->first();
    
                        $dados['user'] = User::findOrFail($coordenador->coordenador_id);
                    }
    
                    $emails = $dados['user']->email;
    
                    if($submissao){
                        $dados['titulo'] = $submissao->titulo;
                    }
    
                    if(!empty($emails)){
                        Mail::send('email.chat', $dados, function ($email) use ($emails, $dados) {
                            if (App::environment('production')) {
                                $email->to($emails);
                            } else {
                                $email->to('murilo@kirc.com.br');
                            }
                                $email->subject('Nova mensagem recebida | Intercom');
    
                            Log::info('E-mail Enviado para o coordenador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                        });    
                    }
    
                } catch (Exception $e) {
                    Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
                }
            }    


            return response()->json($avaliacao, 201);
        } else {
            return response()->json(['error' => 'Mensagem não criada'], 404);
        }
    }

    public function getChatAvaliador($avaliacao_id){

        return ChatAvaliador::select('id','avaliacao_id','avaliador_id','coordenador_id', 'send_avaliador', 'mensagem', 'created_at')
            ->with('avaliador', 'coordenador:id,user_id', 'coordenador.user:id,name')
            ->where('avaliacao_id', $avaliacao_id)
            ->get();
    }

    public function sendMensagemAvaliador(Request $request){

        $distribuicao = DistribuicaoTipo123::select('id')
            ->with(
                'submissaoNordeste',

                'submissaoSul',

                'submissaoSudeste',

                'submissaoCentroOeste',

                'submissaoNorte',
            )
        ->find($request->avaliacao_id);
    
        if($distribuicao && $distribuicao->submissaoNordeste){
            $submissao = $distribuicao->submissaoNordeste;
        }

        if($distribuicao && $distribuicao->submissaoSul){
            $submissao = $distribuicao->submissaoSul;
        }

        if($distribuicao && $distribuicao->submissaoSudeste){
            $submissao = $distribuicao->submissaoSudeste;
        }

        if($distribuicao && $distribuicao->submissaoCentroOeste){
            $submissao = $distribuicao->submissaoCentroOeste;
        }

        if($distribuicao && $distribuicao->submissaoNorte){
            $submissao = $distribuicao->submissaoNorte;
        }

        if($request->avaliacao_id){
            $avaliacao = CreateChatAvaliador::create($request->avaliacao_id,$request->avaliador_id, $request->coordenador_id, $request->mensagem, $request->send_avaliador);
            $avaliacao->load('avaliacao','avaliador', 'coordenador.user:id,name');

            $dados['mensagem'] = $request->mensagem;

            if($request && $request->coordenador_id){
                // Enviar e-mail informando ao Avaliador que tem uma nova mensagem no chat
                try {
    
                    if($request->send_avaliador == 1){
                        $dados['user'] = $request->avaliacao['avaliador_1_obj'];
                    }
            
                    if($request->send_avaliador == 2){
                        $dados['user'] = $request->avaliacao['avaliador_2_obj'];
                    }
            
                    if($request->send_avaliador == 3){
                        $dados['user'] = $request->avaliacao['avaliador_3_obj'];
                    }
            
                    $emails = $dados['user']['email'];
    
                    if($submissao){
                        $dados['titulo'] = $submissao->titulo;
                    }
    
                    Mail::send('email.chat_dt_avaliador', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Mensagem Avaliação | Intercom');
                            Log::info('E-mail Enviado para o avaliador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                    });
    
                } catch (Exception $e) {
                    Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
                }
            }
    
            if($request->coordenador_id == null){
                // Enviar e-mail informando ao avaliador que tem uma nova mensagem no chat
                try {
                           
                    if($request->avaliacao_id){
    
                        $coordenador = ChatAvaliador::select('id', 'coordenador_id')
                        ->whereAvaliacaoId($request->avaliacao_id)
                        ->whereNotNull('coordenador_id')->first();
    
                        $dados['user'] = User::findOrFail($coordenador->coordenador_id);
                    }
    
                    $emails = $dados['user']->email;
    
                    if($submissao){
                        $dados['titulo'] = $submissao->titulo;
                    }
    
                    if(!empty($emails)){
                        Mail::send('email.chat', $dados, function ($email) use ($emails, $dados) {
                            if (App::environment('production')) {
                                $email->to($emails);
                            } else {
                                $email->to('murilo@kirc.com.br');
                            }
                                $email->subject('Nova mensagem recebida | Intercom');
    
                            Log::info('E-mail Enviado para o coordenador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                        });    
                    }
    
                } catch (Exception $e) {
                    Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
                }
            }    

            return response()->json($avaliacao, 201);
        } else {
            return response()->json(['error' => 'Mensagem não criada'], 404);
        }
    }

    public function getChatExpocom($avaliacao_id){

        return ChatAvaliacaoExpocom::select('id','avaliacao_id','avaliador_id','coordenador_id', 'send_avaliador','mensagem', 'created_at')
            ->with('avaliador','coordenador:id,user_id', 'coordenador.user:id,name')
            ->where('avaliacao_id', $avaliacao_id)
            ->get();
    }

    //Enviar mensagem entre coordenador e avaliador
    public function sendMensagemExpocom(Request $request){

        $distribuicao = DistribuicaoTipoExpocom::select('id', 'avaliador_1', 'avaliador_2', 'avaliador_3')
            ->with(
                'submissaoExpocomNordeste',
                'submissaoExpocomNordeste.inscricao',
                'submissaoExpocomNordeste.inscricao.user',
                'submissaoExpocomNordeste.inscricao.user.indicacao',

                'submissaoExpocomSul',
                'submissaoExpocomSul.inscricao',
                'submissaoExpocomSul.inscricao.user',
                'submissaoExpocomSul.inscricao.user.indicacao',

                'submissaoExpocomSudeste',
                'submissaoExpocomSudeste.inscricao',
                'submissaoExpocomSudeste.inscricao.user',
                'submissaoExpocomSudeste.inscricao.user.indicacao',

                'submissaoExpocomCentrooeste',
                'submissaoExpocomCentrooeste.inscricao',
                'submissaoExpocomCentrooeste.inscricao.user',
                'submissaoExpocomCentrooeste.inscricao.user.indicacao',

                'submissaoExpocomNorte',
                'submissaoExpocomNorte.inscricao',
                'submissaoExpocomNorte.inscricao.user',
                'submissaoExpocomNorte.inscricao.user.indicacao'
            )
        ->find($request->avaliacao_id);
    
        if($distribuicao && $distribuicao->submissaoExpocomNordeste){
            $submissao = $distribuicao->submissaoExpocomNordeste;
        }

        if($distribuicao && $distribuicao->submissaoExpocomSul){
            $submissao = $distribuicao->submissaoExpocomSul;
        }

        if($distribuicao && $distribuicao->submissaoExpocomSudeste){
            $submissao = $distribuicao->submissaoExpocomSudeste;
        }

        if($distribuicao && $distribuicao->submissaoExpocomCentrooeste){
            $submissao = $distribuicao->submissaoExpocomCentrooeste;
        }

        if($distribuicao && $distribuicao->submissaoExpocomNorte){
            $submissao = $distribuicao->submissaoExpocomNorte;
        }
            
        $dados['mensagem'] = $request->mensagem;

        if($request && $request->coordenador_id){
            // Enviar e-mail informando ao coordenador que tem uma nova mensagem no chat
            try {

                if($request->send_avaliador == 1){
                    $dados['user'] = User::select('id', 'name', 'email')->find($distribuicao->avaliador_1);
                }
        
                if($request->send_avaliador == 2){
                    $dados['user'] = User::select('id', 'name', 'email')->find($distribuicao->avaliador_2);
                }
        
                if($request->send_avaliador == 3){
                    $dados['user'] = User::select('id', 'name', 'email')->find($distribuicao->avaliador_3);
                }
        
                $emails = $dados['user']->email;

                if($submissao){
                    $dados['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                }

                Mail::send('email.chat', $dados, function ($email) use ($emails, $dados) {
                    if (App::environment('production')) {
                        $email->to($emails);
                    } else {
                        $email->to('murilo@kirc.com.br');
                    }
                        $email->subject('Status do trabalho | Intercom');
                        Log::info('E-mail Enviado para o avaliador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                });

            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            }
        }

        if($request->coordenador_id == null){
            // Enviar e-mail informando ao avaliador que tem uma nova mensagem no chat
            try {
                       
                if($request->avaliacao_id){

                    $coordenador = ChatAvaliacaoExpocom::select('id', 'coordenador_id')
                    ->whereAvaliacaoId($request->avaliacao_id)
                    ->whereNotNull('coordenador_id')->first();

                    $dados['user'] = User::findOrFail($coordenador->coordenador_id);
                }

                $emails = $dados['user']->email;

                if($submissao){
                    $dados['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                }

                if(!empty($emails)){
                    Mail::send('email.chat', $dados, function ($email) use ($emails, $dados) {
                        if (App::environment('production')) {
                            $email->to($emails);
                        } else {
                            $email->to('murilo@kirc.com.br');
                        }
                            $email->subject('Nova mensagem recebida | Intercom');

                        Log::info('E-mail Enviado para o coordenador informando que tem uma mensagem nova no chat | Dados: ' . json_encode($dados));
                    });    
                }

            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            }
        }

        if($request->avaliacao_id){
            $avaliacao = CreateChatAvaliacaoExpocom::create($request->avaliacao_id, $request->avaliador_id, $request->coordenador_id, $request->mensagem, $request->send_avaliador);
            $avaliacao->load('avaliacao','avaliador','coordenador.user:id,name');
            return response()->json($avaliacao, 201);
        } else {
            return response()->json(['error' => 'Mensagem não criada'], 404);
        }
    }
}
