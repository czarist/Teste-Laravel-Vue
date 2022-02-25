<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class CadastroController extends Controller
{
    public $header = ['Content-Type' => 'application/json; charset=UTF-8', 'charset' => 'utf-8'];

    public function index()
    {
        return view('cadastro.form');
    }

    public function store(Request $request)
    {
        try { 
            $post = $request->all();
            $senha = $post['password'];
            $post['password'] = Hash::make($post['password']);
            $post['acessos'] =[0 => 4];
            $post[ 'todos_tipos_id'] = [0 => 4];            
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
            $user;
            Log::info('Cadastro de usuario: ' . json_encode($post));

            $data = ['user' => $user, 'senha' => $senha];
            Mail::send('cadastro.email', $data, function ($email) use ($user) {
                $email->subject('Cadastro de Usuário - INTERCON');
                if (App::environment('production')) {
                    $email->to($user['email']);
                } else {
                    $email->to('murilocarvalho2204@gmail.com');
                }
                Log::info('E-mail enviado apos o cadastro para :'. $user['nome'] .' com o email: '. json_encode($user['email']));
            });

            return response()->json(['message' => 'success', 'response' => $user], 201);
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    //VALIDAÇÕES DE FORM LIVRE DO AUTH

    public function emailCheck(Request $request)
    {
        try {
            $usuario = User::select('id', 'email')->whereEmail($request->email)->withTrashed();
            if($usuario->first()) {
                if($usuario->first()->email === $request->email) {
                    return response()->json(false);
                } else {
                    return response()->json(true);
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

    public function cpfCheck(Request $request)
    {
        try {
            $usuario = User::select('id', 'cpf')->whereCpf($request->cpf)->withTrashed();

            if($usuario->first()) {
                if($usuario->first()->cpf == $request->cpf) {
                    return response()->json(false);
                } else {
                    return response()->json(true);
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

    public function passaporteCheck(Request $request)
    {
        try {
            $usuario = User::select('id', 'passaporte')->whereCpf($request->passaporte)->withTrashed();
            dd($usuario, $request->all());
            if($usuario->first()) {
                if($usuario->first()->passaporte == $request->passaporte) {
                    return response()->json(false);
                } else {
                    return response()->json(true);
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

}
