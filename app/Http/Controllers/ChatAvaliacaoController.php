<?php

namespace App\Http\Controllers;

use App\Models\ChatAvaliacao;
use App\Models\ChatAvaliacaoExpocom;
use App\Models\ChatAvaliador;
use App\Models\Coordenador;
use App\Services\CreateChatAvaliacao;
use App\Services\CreateChatAvaliacaoExpocom;
use App\Services\CreateChatAvaliador;
use Illuminate\Http\Request;

class ChatAvaliacaoController extends Controller
{

    public function getChat($avaliacao_id){

        return ChatAvaliacao::select('id','avaliacao_id','avaliado_id','avaliador_id','coordenador_id','mensagem', 'created_at')
            ->with('avaliador', 'avaliado', 'coordenador:id,user_id', 'coordenador.user:id,name')
            ->where('avaliacao_id', $avaliacao_id)
            ->get();
    }

    public function sendMensagem(Request $request){
        if($request->avaliacao_id){
            $avaliacao = CreateChatAvaliacao::create($request->avaliacao_id, $request->avaliado_id, $request->avaliador_id, $request->coordenador_id, $request->mensagem);
            $avaliacao->load('avaliacao','avaliador','avaliado','coordenador.user:id,name');
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
        if($request->avaliacao_id){
            $avaliacao = CreateChatAvaliador::create($request->avaliacao_id,$request->avaliador_id, $request->coordenador_id, $request->mensagem, $request->send_avaliador);
            $avaliacao->load('avaliacao','avaliador', 'coordenador.user:id,name');
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

    public function sendMensagemExpocom(Request $request){
        if($request->avaliacao_id){
            $avaliacao = CreateChatAvaliacaoExpocom::create($request->avaliacao_id, $request->avaliador_id, $request->coordenador_id, $request->mensagem, $request->send_avaliador);
            $avaliacao->load('avaliacao','avaliador','coordenador.user:id,name');
            return response()->json($avaliacao, 201);
        } else {
            return response()->json(['error' => 'Mensagem não criada'], 404);
        }
    }

}
