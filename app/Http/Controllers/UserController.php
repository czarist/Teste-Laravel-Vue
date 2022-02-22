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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function usuarios()
    {
        return User::select('id', 'name', 'email','ativo')
                        ->with('acessos:id,pagina,link',
                            'todos_tipos:id,descricao',
                            // 'empresa:id,razao_social',
                            // 'departamento:id,descricao',
                            // 'enderecos:id,cep,rua,numero,complemento,bairro,municipio_id,latitude,longitude,user_id',
                            // 'enderecos.municipio:id,estado_id,codigo,name','acessos:id,pagina,link',
                            // 'enderecos.municipio.estado:id,codigo,name,sigla,regiao',
                            );
    }

    public function index()
    {
        $registros = $this->usuarios()->get();
        return view('admin.usuarios.index', compact('registros'));
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
            if (count($post['enderecos'])) {
                 foreach ($post['enderecos'] as $endereco) {
                    if (!empty($endereco['cep'])) {
                        Endereco::updateOrcreate(
                            ['id' => $endereco['id'] ?? null],
                            [
                                'user_id' => $user->id,
                                'municipio_id' => $endereco['municipio']['id'],
                                'cep' => $endereco['cep'],
                                'complemento' => $endereco['complemento'],
                                'numero' => $endereco['numero'],
                                'bairro' => $endereco['bairro'],
                                'rua' => $endereco['rua'],
                                'latitude' => $endereco['latitude'],
                                'longitude' => $endereco['longitude']
                            ]
                        );
                    }
                }
            }
            $user->load('todos_tipos:id,descricao',
                    'empresa:id,name',
                    'departamento:id,descricao',
                    'enderecos:id,cep,rua,complemento,numero,bairro,municipio_id,latitude,longitude,user_id',
                    'enderecos.municipio:id,estado_id,codigo,name','acessos:id,pagina,link',
                    'enderecos.municipio.estado:id,codigo,name,sigla,regiao');
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
        try { 
            $user = User::findOrFail($request->id);
            if($request->filled('password')) {
                $post = $request->all();
                $post['password'] = Hash::make($request->input('password'));
            } else {
                $post = $request->except('password');
            }
            $user->update($post);
            if (count($post['enderecos'])) {
                foreach ($post['enderecos'] as $endereco) {
                    if (!empty($endereco['cep'])) {
                    
                        if (($endereco['deleted'])) {
                            Endereco::findOrFail($endereco['id'])->delete();
                        } else {
                            Endereco::updateOrcreate(
                                ['id' => $endereco['id'] ?? null],
                                [
                                    'user_id' => $user->id,
                                    'municipio_id' => $endereco['municipio']['id'],
                                    'complemento' => $endereco['complemento'],
                                    'cep' => $endereco['cep'],
                                    'numero' => $endereco['numero'],
                                    'bairro' => $endereco['bairro'],
                                    'rua' => $endereco['rua'],
                                    'latitude' => $endereco['latitude'],
                                    'longitude' => $endereco['longitude']
                                ]
                            );
                        }
                    }
                }
            }
            $user->acessos()->sync($post['acessos']);
            
            $user->load('todos_tipos:id,descricao',
                        'empresa:id,name',
                        'departamento:id,descricao',
                        'enderecos:id,cep,rua,complemento,numero,bairro,municipio_id,latitude,longitude,user_id',
                        'enderecos.municipio:id,estado_id,codigo,name','acessos:id,pagina,link',
                        'enderecos.municipio.estado:id,codigo,name,sigla,regiao');
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
