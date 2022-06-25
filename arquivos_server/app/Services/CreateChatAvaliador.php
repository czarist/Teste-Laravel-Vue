<?php

namespace App\Services;

use App\Models\ChatAvaliacao;
use App\Models\ChatAvaliador;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class CreateChatAvaliador
{
    public static function create($avaliacao_id, $avaliador_id, $coordenador_id, $mensagem, $send_avaliador)
    {
        return ChatAvaliador::create([
            'avaliacao_id' => $avaliacao_id,
            'avaliador_id' => $avaliador_id ?? null,
            'coordenador_id' => $coordenador_id ?? null,
            'mensagem' => $mensagem,
            'send_avaliador' => $send_avaliador
        ]);

        if(Auth::user()->id){
            Log::info('User: '.Auth::user(). ' | Create conversa, avaliaçao ID: '. $avaliacao_id . ' | Avaliador: '. $avaliador_id ?? null
            . ' | Coordenador: '. $coordenador_id ?? null . ' | Mensagem: '. $mensagem. ' | Send_avaliador: '. $send_avaliador ?? null);
        }
    }

    public function __clone()
    {
        throw new Exception('Error: classe não instanciável');
    }
}
