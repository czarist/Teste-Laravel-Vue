<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CadastroController extends Controller
{
    public function index()
    {
        return view('cadastro.form');
    }

    public function store(Request $request)
    {
        try {

            return response()->json(['message' => 'success', 'response' => 'user'], 201);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    //VALIDAÇÕES DE FORM LIVRE DO AUTH

    public function emailCheck(Request $request)
    {
        try {
                return response()->json(true);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());
            if ($exception instanceof ModelNotFoundException) {
                return abort(404, 'Registro não encontrado');
            }

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function cpfCheck(Request $request)
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

    public function passaporteCheck(Request $request)
    {
        try {
            return response()->json(true);
            
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());
            if ($exception instanceof ModelNotFoundException) {
                return abort(404, 'Registro não encontrado');
            }

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
