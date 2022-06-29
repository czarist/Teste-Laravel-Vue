<?php

namespace App\Services;

use App\Models\ChatAvaliacaoExpocom;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateChatAvaliacaoExpocom
{
    public static function create($avaliacao_id, $avaliador_id, $coordenador_id, $mensagem, $send_avaliador)
    {
        return ChatAvaliacaoExpocom::create([
            'avaliacao_id' => $avaliacao_id,
            'avaliador_id' => $avaliador_id ?? null,
            'coordenador_id' => $coordenador_id ?? null,
            'mensagem' => $mensagem,
            'send_avaliador' => $send_avaliador,
        ]);

        if (Auth::user()->id) {
            Log::info('User: '.Auth::user().' | Create conversa, avaliaçao ID: '.$avaliacao_id.' | Avaliador: '.$avaliador_id ?? null
            .' | Coordenador: '.$coordenador_id ?? null.' | Mensagem: '.$mensagem ?? null.' | Send_avaliador: '.$send_avaliador ?? null);
        }
    }

    public function __clone()
    {
        throw new Exception('Error: classe não instanciável');
    }
}
