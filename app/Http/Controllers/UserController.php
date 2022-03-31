<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function usuarios()
    {
        return User::select('id', 'name', 'email','ativo', 'sexo_id', 'estrangeiro','passaporte','cpf','rg','orgao_expedidor','telefone','celular','data_nascimento')
                        ->with('acessos:id,pagina,link',
                                'todos_tipos:id,descricao',
                                'enderecos',
                                'enderecos.municipio',
                                'enderecos.municipio.estado',
                                'associado',                
                                );
    }

    public function index()
    {
        return view('admin.usuarios.index');
    }

    public function get(Request $request)
    {
        return $this->usuarios()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {    
                            $query->when($request->type == 'name', function ($query) use ($request) {
                                $query->where('name', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%' . $request->search . '%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%');
                            });
                        });
                    })
                    ->when($request->sort == 'id', function ($query) {
                        $query->orderBy('id', 'DESC');
                    })
                    ->when($request->sort == 'name', function ($query) use ($request) {
                        $query->orderBy('name', $request->asc == 'true' ? 'ASC' : 'DESC');
                    })

                    ->paginate(20);
    }

    public function store(Request $request)
    {
        try { 
            $post = $request->all();
            $post['password'] = Hash::make($post['password']);
            
            $user = User::create($post);
            $$todos_tipos = [0 => 4];  
            $user->todos_tipos()->sync($todos_tipos);
            $user->acessos()->sync($post['acessos']);

            Log::info('User criado: ' . json_encode($post));

            return response()->json(['message' => 'success', 'response' => $user], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);

        }
    }

    public function update(Request $request)
    {
        try { 
            $post = $request->all();
            $user = User::findOrFail($request->id);
            $endereco = Endereco::whereUserId($user->id)->first();
            $associado = Associado::whereUserId($user->id)->first();   

            if(isset($post['password']) && !empty($post['password'])) {
                $post['password'] = Hash::make($post['password']);
            }
            
            if(!isset($post['password']) || empty($post['password'])) {
                $post['password'] = $user->password;
            }

            if(!empty($user))
            {
                if($user->rg == $post['rg']) {
                    $user->update([
                        'name' => $post['name'] ?? null,
                        'email' => $post['email'] ?? null,
                        'password' => $post['password'] ?? null,
                        'telefone' => $post['telefone'] ?? null,
                        'celular' => $post['celular'] ?? null,
                        'data_nascimento' => $post['data_nascimento'] ?? null,
                        'sexo_id' => $post['sexo_id'] ?? null,
                        'rg' => $post['rg'] ?? null,
                        'orgao_expedidor' => $post['orgao_expedidor'] ?? null,

                        'updated_at' => Carbon::now()
                    ]);
                }else{

                    $user->update([
                        'name' => $post['name'] ?? null,
                        'email' => $post['email'] ?? null,
                        'password' => $post['password'] ?? null,
                        'telefone' => $post['telefone'] ?? null,
                        'celular' => $post['celular'] ?? null,
                        'data_nascimento' => $post['data_nascimento'] ?? null,
                        'rg' => $post['rg'] ?? null,
                        'orgao_expedidor' => $post['orgao_expedidor'] ?? null,
                        'sexo_id' => $post['sexo_id'] ?? null,
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            unset($post['password']);
    
            if(empty($endereco))
            {
                $endereco = Endereco::create(
                    [
                        'user_id' => $user->id,
                        'logradouro' => $request->enderecos['logradouro'] ?? null,
                        'numero' => $request->enderecos['numero'] ?? null,
                        'complemento' => $request->enderecos['complemento'] ?? null,
                        'bairro' => $request->enderecos['bairro'] ?? null,
                        'municipio_id' => $request->enderecos['municipio']['id'] ?? null,
                        'cep' => $request->enderecos['cep'] ?? null,
                        'pais_id' => $request['pais'] ?? null,
                        'updated_at' => Carbon::now()
                    ]
                );
        
            }else {
                $endereco->update(
                    [
                        'user_id' => $user->id,
                        'logradouro' => $request->enderecos['logradouro'] ?? null,
                        'numero' => $request->enderecos['numero'] ?? null,
                        'complemento' => $request->enderecos['complemento'] ?? null,
                        'bairro' => $request->enderecos['bairro'] ?? null,
                        'municipio_id' => $request->enderecos['municipio']['id'] ?? null,
                        'cep' => $request->enderecos['cep'] ?? null,
                        'pais_id' => $request['pais'] ?? null,
                        'updated_at' => Carbon::now()
                    ]
                );
            }

            if(empty($associado))
            {
                $associado = Associado::create(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $request->instituicao_id ?? null,
                        'titulacao_id' => $request->titulacao_id ?? null,
                    ]
                );

            }else
            {
                $associado->update(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $request->instituicao_id ?? null,
                        'titulacao_id' => $request->titulacao_id ?? null,
                    ]
                );    
            }

            $user->todos_tipos()->sync($post['todos_tipos_id']);
            $user->acessos()->sync($post['acessos']);

            Log::info('User UPDATE: ' . json_encode($post));
            return response()->json(['message' => 'success', 'response' => $user], 200);
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try { 
            $user = User::select('id')->findOrFail($id);
            $user->acessos()->sync([]);
            $user->todos_tipos()->sync([]);
            $user->delete();
            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode(['id' => $id]));
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
