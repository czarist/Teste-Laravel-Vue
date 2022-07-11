<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PerfilController extends Controller
{
    public function perfil()
    {
        $user = User::select('id', 'name', 'password', 'email', 'ativo', 'sexo_id', 'estrangeiro', 'passaporte', 'cpf', 'rg', 'orgao_expedidor', 'telefone', 'celular', 'data_nascimento')
                    ->with(
                        'acessos:id,pagina,link',
                        'todos_tipos:id,descricao',
                        'enderecos',
                        'enderecos.municipio',
                        'enderecos.municipio.estado',
                        'associado'
                    )
                                ->find(Auth::user()->id);

        return view('perfil.index', compact('user'));
    }

    public function filiese()
    {
        $user = User::select('id', 'name', 'email', 'ativo', 'sexo_id', 'estrangeiro', 'passaporte', 'cpf', 'rg', 'orgao_expedidor', 'telefone', 'celular', 'data_nascimento')
                    ->with(
                        'acessos:id,pagina,link',
                        'todos_tipos:id,descricao',
                        'enderecos',
                        'enderecos.municipio',
                        'enderecos.municipio.estado',
                        'associado'
                    )
                                ->find(Auth::user()->id);

        return view('cadastro.filiese', compact('user'));
    }

    public function anuidade()
    {
        $user = User::select('id', 'name', 'email', 'ativo', 'sexo_id', 'estrangeiro', 'passaporte', 'cpf', 'rg', 'orgao_expedidor', 'telefone', 'celular', 'data_nascimento')
                    ->with(
                        'acessos:id,pagina,link',
                        'todos_tipos:id,descricao',
                        'enderecos',
                        'enderecos.municipio',
                        'enderecos.municipio.estado',
                        'associado'
                    )
                                ->find(Auth::user()->id);

        return view('associado.anuidadeForm', compact('user'));
    }

    public function senhaUpdate(Request $request)
    {
        try {

            return response()->json(['message' => 'success', 'usuario' => '$usuario'], 200);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());
            if ($exception instanceof ModelNotFoundException) {
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
            return response()->json(false);

        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());
            if ($exception instanceof ModelNotFoundException) {
                return abort(404, 'Registro não encontrado');
            }

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function senhaCheck(Request $request)
    {
        if (Hash::check($request->get('senha_atual'), Auth::user()->password)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function store(Request $request)
    {
        try {

            return response()->json(['message' => 'success', 'response' => '$user'], 201);
            
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
