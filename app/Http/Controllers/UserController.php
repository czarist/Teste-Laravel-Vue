<?php

namespace App\Http\Controllers;

use App\Models\Associado;
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
        return User::select('id', 'name', 'email', 'ativo', 'sexo_id', 'estrangeiro', 'passaporte', 'cpf', 'rg', 'orgao_expedidor', 'telefone', 'celular', 'data_nascimento')
                        ->with(
                            'acessos:id,pagina,link',
                            'todos_tipos:id,descricao',
                            'todos_tipos_isencao:id,descricao',
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
                                $query->where('name', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'cpf', function ($query) use ($request) {
                                $query->where('cpf', 'like', '%'.$request->search.'%');
                            });
                            $query->when($request->type == 'email', function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->search.'%');
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
            $todos_tipos = [0 => 4];
            $user->todos_tipos()->sync($todos_tipos);
            $user->acessos()->sync($post['acessos']);

            Log::info('User criado: '.json_encode($post));

            return response()->json(['message' => 'success', 'response' => $user], 201);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        $post = $request->all();

        try {
            $user = User::with(
                'todos_tipos:id,descricao',
                'todos_tipos_isencao:id,descricao',
                'associado',
                'nacional',
                'regional_sul',
                'regional_centrooeste',
                'regional_nordeste',
                'regional_norte',
                'regional_suldeste'
            )
            ->findOrFail($post['id']);

            if ($user && $user->associado != null) {
                if ($user && $user->nacional && $user->nacional->categoria_inscricao && $user->nacional->categoria_inscricao != null) {
                    $user->nacional->categoria_inscricao = $post['titulacao_id'];
                    $user->nacional->save();
                }

                if ($user && $user->regional_sul && $user->regional_sul->categoria_inscricao && $user->regional_sul->categoria_inscricao != null) {
                    $user->regional_sul->categoria_inscricao = $post['titulacao_id'];
                    $user->regional_sul->save();
                }

                if ($user && $user->regional_centrooeste && $user->regional_centrooeste->categoria_inscricao && $user->regional_centrooeste->categoria_inscricao != null) {
                    $user->regional_centrooeste->categoria_inscricao = $post['titulacao_id'];
                    $user->regional_centrooeste->save();
                }

                if ($user && $user->regional_nordeste && $user->regional_nordeste->categoria_inscricao && $user->regional_nordeste->categoria_inscricao != null) {
                    $user->regional_nordeste->categoria_inscricao = $post['titulacao_id'];
                    $user->regional_nordeste->save();
                }

                if ($user && $user->regional_norte && $user->regional_norte->categoria_inscricao && $user->regional_norte->categoria_inscricao != null) {
                    $user->regional_norte->categoria_inscricao = $post['titulacao_id'];
                    $user->regional_norte->save();
                }

                if ($user && $user->regional_suldeste && $user->regional_suldeste->categoria_inscricao && $user->regional_suldeste->categoria_inscricao != null) {
                    $user->regional_suldeste->categoria_inscricao = $post['titulacao_id'];
                    $user->regional_suldeste->save();
                }
            }

            $endereco = Endereco::whereUserId($user->id)->first();

            $associado = Associado::whereUserId($user->id)->first();

            if (isset($post['password']) && ! empty($post['password'])) {
                $post['password'] = Hash::make($post['password']);
            }

            if (! isset($post['password']) || empty($post['password'])) {
                $post['password'] = $user->password;
            }

            if (! empty($user)) {
                $user->update([
                    'name' => $post['name'],
                    'email' => $post['email'],
                    'password' => $post['password'],
                    'estrangeiro' => $post['estrangeiro'],
                    // 'passaporte' => $post['passaporte'],
                    'telefone' => $post['telefone'],
                    'celular' => $post['celular'],
                    'data_nascimento' => $post['data_nascimento'],
                    'rg' => $post['rg'],
                    'orgao_expedidor' => $post['orgao_expedidor'],
                    'sexo_id' => $post['sexo_id'],
                    'ativo' => $post['ativo'],
                ]);
            }

            unset($post['password']);

            if (empty($endereco)) {
                $endereco = Endereco::create([
                    'user_id' => $user->id,
                    'logradouro' => $post['enderecos']['logradouro'] ?? null,
                    'numero' => $post['enderecos']['numero'] ?? null,
                    'complemento' => $post['enderecos']['complemento'] ?? null,
                    'bairro' => $post['enderecos']['bairro'] ?? null,
                    'municipio_id' => $post['enderecos']['municipio']['id'] ?? null,
                    'cep' => $post['enderecos']['cep'] ?? null,
                    'pais_id' => $post['enderecos']['pais'] ?? null,
                ]);
            } else {
                $endereco->update([
                    'logradouro' => $post['enderecos']['logradouro'] ?? null,
                    'numero' => $post['enderecos']['numero'] ?? null,
                    'complemento' => $post['enderecos']['complemento'] ?? null,
                    'bairro' => $post['enderecos']['bairro'] ?? null,
                    'municipio_id' => $post['enderecos']['municipio']['id'] ?? null,
                    'cep' => $post['enderecos']['cep'] ?? null,
                    'pais_id' => $post['enderecos']['pais'] ?? null,
                ]);
            }

            if (empty($associado)) {
                $associado = Associado::create([
                    'user_id' => $user->id,
                    'instituicao_id' => $post['instituicao_id'],
                    'titulacao_id' => $post['titulacao_id'],
                    'anuidade' => $post['anuidade'],
                    'numero_socio' => $post['numero_socio'],
                    'obs_isentamos' => $post['obs_isentamos'],
                ]);
            } else {
                $associado->update([
                    'user_id' => $user->id,
                    'instituicao_id' => $post['instituicao_id'],
                    'titulacao_id' => $post['titulacao_id'],
                    'anuidade' => $post['anuidade'],
                    'numero_socio' => $post['numero_socio'],
                    'obs_isentamos' => $post['obs_isentamos'],
                ]);
            }

            if ($post['todos_isencoes_id'] != null && $user && $user->todos_tipos && ! in_array(7, $user->todos_tipos->toArray())) {
                $post['todos_tipos_id'][] = 11;
            }

            $user->todos_tipos()->sync($post['todos_tipos_id']);
            $user->todos_tipos_isencao()->sync($post['todos_isencoes_id']);
            $user->acessos()->sync($post['acessos']);

            $user->load(
                'acessos:id,pagina,link',
                'todos_tipos:id,descricao',
                'todos_tipos_isencao:id,descricao',
                'enderecos',
                'enderecos.municipio',
                'enderecos.municipio.estado',
                'associado',
            );

            Log::info('User UPDATE: '.json_encode($post));

            return response()->json(['message' => 'success', 'response' => $user], 200);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

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
            Log::info('User: '.Auth::user()->id.' | '.__METHOD__.' | '.json_encode(['id' => $id]));

            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
