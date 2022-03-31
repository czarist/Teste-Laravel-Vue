<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\AvaliadorExpocom;
use App\Models\Endereco;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AvaliadorExpocomController extends Controller
{
    public function usuario(){
        return User::select('id', 'name', 'email', 'estrangeiro','passaporte','cpf','telefone','celular')
            ->with('acessos:id,pagina,link',
                'todos_tipos:id,descricao',
                'todos_divisoes_tematicas:id,descricao',
                'todos_divisoes_tematicas_jr:id,descricao',
                'todos_cinema_audiovisual:id,descricao',
                'todos_jornalismo:id,descricao',
                'todos_publicidade_propaganda:id,descricao',
                'todos_relacoes_publicas:id,descricao',
                'todos_producao_editorial:id,descricao',
                'todos_radio_internet:id,descricao',
                'enderecos',
                'enderecos.municipio',
                'enderecos.municipio.estado',
                'associado',
                'avaliador_expocom'
                )
                ->find(Auth::user()->id);
    
    }

    public function formavaliadorexpocom()
    {
        $user = $this->usuario();
        $form_jr = 0;

        return view('ficha.avaliador.form_expocom', compact('user', 'form_jr'));
    }

    public function formavaliadorjr()
    {
        $user = $this->usuario();
        $form_jr = 1;

        return view('ficha.avaliador.form_jr', compact('user', 'form_jr'));
    }

    public function store(Request $request)
    {
        $post = $request->all();
        $user = User::findOrFail($post['id']);
        if($post['junior'] == 1){

            $user->todos_divisoes_tematicas()->sync($request->divisoes_tematicas);
            $user->todos_divisoes_tematicas_jr()->sync($request->divisoes_tematicas_jr);
        }         
        
        if($post['avaliador'] == 1){

            $user->todos_cinema_audiovisual()->sync($request->cinema_audiovisual);
            $user->todos_jornalismo()->sync($request->jornalismo);
            $user->todos_publicidade_propaganda()->sync($request->publicidade_propaganda);
            $user->todos_relacoes_publicas()->sync($request->relacoes_publicas);
            $user->todos_producao_editorial()->sync($request->producao_editorial);
            $user->todos_radio_internet()->sync($request->radio_internet);

        }

        $avaliador_expocom = AvaliadorExpocom::whereUserId($user->id)->first();   

        if(empty($avaliador_expocom)){
            $avaliador_expocom = AvaliadorExpocom::create([
                'user_id' => $user->id,
                'avaliador' => $post['avaliador'],
                'avaliador_junior' => $post['junior'],
            ]);
        }else{
            $avaliador_expocom->update([
                'avaliador' => $post['avaliador'],
                'avaliador_junior' => $post['junior'],
            ]);
        }

        if(!empty($user))
        {
            $user->update([
                'telefone' => $post['telefone'],
                'celular' => $post['celular'],
                'updated_at' => Carbon::now()
            ]);
        }

        $associado = Associado::whereUserId($user->id)->first();   
        
        if(empty($associado))
        {
            $associado = Associado::create(
                [
                    'user_id' => $user->id,
                    'instituicao_id' => $request->instituicao_id,
                    'titulacao_id' => $request->titulacao_id,
                ]
            );

        }else{
            $associado->update(
                [
                    'user_id' => $user->id,
                    'instituicao_id' => $request->instituicao_id,
                    'titulacao_id' => $request->titulacao_id,
                ]
            );    
        }

        $endereco = Endereco::whereUserId($user->id)->first();   

        if(empty($endereco))
        {
            $endereco = Endereco::create(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->enderecos['logradouro'] ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->enderecos['numero'] ?? '0',
                    'complemento' => $request->enderecos['complemento'] ?? '',
                    'bairro' => $request->enderecos['bairro'] ?? 'Centro',
                    'municipio_id' => $request->enderecos['municipio']['id'] ?? 1,
                    'cep' => $request->enderecos['cep'] ?? '01153000',
                    'pais_id' => $request->enderecos['pais'] ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
    
        }else {
            $endereco->update(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->enderecos['logradouro'] ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->enderecos['numero'] ?? '0',
                    'complemento' => $request->enderecos['complemento'] ?? '',
                    'bairro' => $request->enderecos['bairro'] ?? 'Centro',
                    'municipio_id' => $request->enderecos['municipio']['id'] ?? 1,
                    'cep' => $request->enderecos['cep'] ?? '01153000',
                    'pais_id' => $request->enderecos['pais'] ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
        }

        Log::info('Ficha Avaliador Expocom Criada ou Atualizada: ' . json_encode($request->all()));

        return response()->json(['message' => 'success', 'response' => $user], 201);

    }

}