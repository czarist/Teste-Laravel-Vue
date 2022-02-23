<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssociadoController extends Controller
{
     public function index()
    {
        return view('admin.associado.index');
    }

    public function get(Request $request)
    {
        $associados = Associado::select('id', 'numero_socio', 'anuidade','divisao_tematica','obs_isentamos', 'titulacao_id', 'instituicao_id')
                        ->with('titulacao', 'instituicao')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function($q) use ($request) {
                                $q->orWhere('numero_socio', 'like', '%'. $request->search . '%')
                                ->orWhere(DB::raw("(DATE_FORMAT(anuidade,'%d/%m/%Y'))"),'LIKE', '%'. $request->search . '%')
                                ->orWhere('divisao_tematica', 'like', '%'. $request->search . '%');
                              
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when($request->sort == 'numero_socio', function ($query) use ($request) {
                            $query->orderBy('numero_socio', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->paginate(20);
        return response()->json($associados,201);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $associado = Associado::create($data);
            $associado->load('titulacao', 'instituicao');
            Log::info('User: ' . Auth::user() . ' | Create associado | '  . __METHOD__ . ' | Request Send to: ' . json_encode($data));
            return  response()->json(['response' => $associado],201);
        }catch(Exception $exception) {
            Log::error($exception);
            Log::error('User: ' . Auth::user() . ' | Error Create associado | Request Send to: ' . json_encode($data));
            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $data = $request->all();
            $associado = Associado::findOrFail($id);
            $associado->update($data);
            $associado->load('titulacao', 'instituicao');
            Log::info('User: ' . Auth::user() . ' | Update associado | '  . __METHOD__ . ' | Request Send to: ' . json_encode($data));
            return  response()->json(['response' =>$associado],200);
        }catch(Exception $exception) {
            Log::error($exception);
            Log::error('User: ' . Auth::user() . ' | Error Update associado | Request Send to: ' . json_encode($data));
            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $associado = Associado::select('id')->findOrFail($id);
            $associado->delete();
            Log::info('Usuário ' .Auth::user() . ' Deletou a associado | '  . __METHOD__ . ' |' .json_encode($associado));
        }catch(Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    public function check(Request $request)
    {
        try {
            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()));
            $numero = Associado::select('id', 'numero_socio')->whereNumeroSocio($request->numero_socio)->withTrashed();
            if($numero->first()) {
                if($numero->first()->id == $request->id[0]) {
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
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500, $this->header, JSON_UNESCAPED_UNICODE);
        }
    }
}
