<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\User;
use Carbon\Carbon;
use com_exception;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PerfilController extends Controller
{
    public function perfil()
    {
        $user = User::select('id', 'name', 'email','ativo', 'sexo_id', 'estrangeiro','passaporte','cpf','rg','orgao_expedidor','telefone','celular','data_nascimento')
                    ->with('acessos:id,pagina,link',
                            'todos_tipos:id,descricao',
                            'enderecos',
                            'enderecos.municipio',
                            'enderecos.municipio.estado',
                            'associado')
                                ->find(Auth::user()->id);
                                
        return view('perfil.index', compact('user'));
    }

    public function filiese()
    {
        $user = User::select('id', 'name', 'email','ativo', 'sexo_id', 'estrangeiro','passaporte','cpf','rg','orgao_expedidor','telefone','celular','data_nascimento')
                    ->with('acessos:id,pagina,link',
                            'todos_tipos:id,descricao',
                            'enderecos',
                            'enderecos.municipio',
                            'enderecos.municipio.estado',
                            'associado')
                                ->find(Auth::user()->id);
                                
        return view('cadastro.filiese', compact('user'));
    }

    public function anuidade()
    {
        $user = User::select('id', 'name', 'email','ativo', 'sexo_id', 'estrangeiro','passaporte','cpf','rg','orgao_expedidor','telefone','celular','data_nascimento')
                    ->with('acessos:id,pagina,link',
                            'todos_tipos:id,descricao',
                            'enderecos',
                            'enderecos.municipio',
                            'enderecos.municipio.estado',
                            'associado')
                                ->find(Auth::user()->id);
                                
        return view('associado.anuidadeForm', compact('user'));
    }



    public function senhaUpdate(Request $request)
    {
        try {
            $usuario = User::select('id','password')->findOrFail(Auth::user()->id);


            $usuario->password = Hash::make($request->password);
            $usuario->save();

            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode(['id' => Auth::user()->id]));
            return response()->json(['message' => 'success', 'usuario' => $usuario], 200);
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            if($exception instanceof ModelNotFoundException){
                return abort(404, 'Registro não encontrado');
            }
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }

    }

     public function passCheck(Request $request)
    {
        return response()->json(Hash::check($request->senha_atual, Auth::user()->password));
    }

     public function emailCheck(Request $request)
    {
        try {
            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()));
            $usuario = User::select('id', 'email')->whereEmail($request->email)->withTrashed();
            if($usuario->first()) {
                if($usuario->first()->id == $request->id[0]) {
                    return response()->json(true);
                } else {
                    return response()->json(false);
                }
            } else {
                return response()->json(true);
            }
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            if($exception instanceof ModelNotFoundException){
                return abort(404, 'Registro não encontrado');
            }
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500, $this->header, JSON_UNESCAPED_UNICODE);
        }
    }

    public function senhaCheck(Request $request)
    {
        if(Hash::check($request->get('senha_atual'), Auth::user()->password)) {
           echo "true";
        } else {
            echo "false";
        }
    }

    public function store(Request $request){

        try { 
            $post = $request->all();
            $post['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $post['data_nascimento'])->format('Y-m-d');
            $user = User::findOrFail($post['id']);

            if(!empty($user))
            {
                if($user->rg == $post['rg']) {
                    $user->update([
                        'name' => $post['name'],
                        'telefone' => $post['telefone'],
                        'celular' => $post['celular'],
                        'data_nascimento' => $post['data_nascimento'],
                        'sexo_id' => $post['sexo_id'],
                        'updated_at' => Carbon::now()
                    ]);
                }else{

                    $user->update([
                        'name' => $post['name'],
                        'telefone' => $post['telefone'],
                        'celular' => $post['celular'],
                        'data_nascimento' => $post['data_nascimento'],
                        'rg' => $post['rg'],
                        'sexo_id' => $post['sexo_id'],
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            unset($post['password']);

            if($user){
                $endereco = Endereco::whereUserId($user->id)->first();   
            }
    
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
                        'pais_id' => $request['pais'] ?? 'Brasil',
                        'updated_at' => Carbon::now()
                    ]
                );
        
            }else {
                $endereco->update(
                    [
                        'user_id' => $user->id,
                        'logradouro' => $request->enderecos['logradouro'],
                        'numero' => $request->enderecos['numero'] ,
                        'complemento' => $request->enderecos['complemento'] ,
                        'bairro' => $request->enderecos['bairro'] ,
                        'municipio_id' => $request->enderecos['municipio']['id'],
                        'cep' => $request->enderecos['cep'] ,
                        'pais_id' => $request['pais'] ,
                        'updated_at' => Carbon::now()
                    ]
                );
            }


            if(Auth::user()->is_associado){
                $associado = Associado::whereUserId($user->id)->first();   
            }
            
            if(empty($associado))
            {
                $associado = Associado::create(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $request->instituicao_id,
                        'titulacao_id' => $request->titulacao_id,
                    ]
                );

            }else
            {
                $associado->update(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $request->instituicao_id,
                        'titulacao_id' => $request->titulacao_id,
                    ]
                );    
            }

            Log::info('User: '. Auth::user()->id . ' | Atualizou Usuario: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $user], 201);
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }

    }
}
