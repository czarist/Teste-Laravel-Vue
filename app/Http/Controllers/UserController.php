<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\User;
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
                                'enderecos.municipio.estado');
            }

    public function index()
    {
        return view('admin.usuarios.index');
    }

    public function get(Request $request)
    {
        return $this->usuarios()
                    ->when($request->search, function ($query) use ($request) {
                        $query->where(function($q) use ($request) {
                            $q->where('name', 'like', '%'. $request->search . '%');
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
            $user->acessos()->sync($post['acessos']);
            $user->todos_tipos()->sync($post['todos_tipos_id']);

            if (!empty($post['enderecos'])) {
                Endereco::updateOrcreate(
                    ['id' => $endereco['id'] ?? null],
                    [
                        'user_id' => $user->id,
                        'municipio_id' => $post['enderecos']['municipio']['id'] ?? 1,
                        'pais_id' => $post['enderecos']['pais']['id'] ?? 'Brasil',
                        'cep' => $post['enderecos']['cep'] ?? 1,
                        'logadouro' => $post['enderecos']['logradouro'],

                    ]
                );
            }
            $user->load('todos_tipos:id,descricao',
                        'todos_tipos:id,descricao',
                        'enderecos',
                        'enderecos.municipio',
                        'enderecos.municipio.estado');
            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode($post));
            return response()->json(['message' => 'success', 'response' => $user], 201);
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $endereco = Endereco::whereUserId($user->id)->first();
        try { 
            if($request->filled('password')) {
                $post = $request->all();
                $post['password'] = Hash::make($request->input('password'));
            } else {
                $post = $request->except('password');
            }
            $user->update($post);

            if (!empty($endereco)) {
                Endereco::updateOrcreate(
                    ['id' => $endereco['id']],
                    [
                        'user_id' => $user->id,
                        'municipio_id' => $request->enderecos['municipio']['id'] ?? 1,
                        'pais_id' => $request->enderecos['pais']['id'] ?? 'Brasil',
                        'cep' => $request->enderecos['cep'] ?? 1,
                        'logradouro' => $request->enderecos['logradouro'],
                    ]
                );
            }
            else {

                Endereco::create(
                    [
                        'user_id' => $user->id,
                        'municipio_id' => $request->enderecos['municipio']['id'] ?? 1,
                        'pais_id' => $request->enderecos['pais']['id'] ?? 'Brasil',
                        'cep' => $request->enderecos['cep'] ?? 1,
                        'logradouro' => $request->enderecos['logradouro'],
                    ]
                );
            }

            $user->acessos()->sync($post['acessos']);
            dd($user);
            $user->todos_tipos()->sync($post['todos_tipos_id']);
            
            $user->load('todos_tipos:id,descricao',
                    'empresa:id,name',
                    'enderecos',
                    'enderecos.municipio',
                    'enderecos.municipio.estado');
            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode($post));
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
