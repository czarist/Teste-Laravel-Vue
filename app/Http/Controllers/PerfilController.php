<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public $header = ['Content-Type' => 'application/json; charset=UTF-8', 'charset' => 'utf-8'];

    public function senha()
    {
        return view('auth.login');
    }

    public function senhaUpdate(Request $request)
    {
        try {
            $usuario = User::select('id','password', 'password_changed_at')->findOrFail(Auth::user()->id);


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
}
