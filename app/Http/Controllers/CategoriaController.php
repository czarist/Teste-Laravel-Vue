<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
     public function index()
    {
        return view('config.categoria.index');
    }

    public function get(Request $request)
    {
        $categorias = Categoria::select('id', 'numero_socio','categoria', 'anuidade','divisao_tematica','obs_isentamos','user_id')
                        ->with('user')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function($q) use ($request) {
                                $q->orWhere('numero_socio', 'like', '%'. $request->search . '%')
                                ->orWhere('categoria', 'like', '%'. $request->search . '%')
                                ->orWhere(DB::raw("(DATE_FORMAT(anuidade,'%d/%m/%Y'))"),'LIKE', '%'. $request->search . '%')
                                ->orWhere('divisao_tematica', 'like', '%'. $request->search . '%')
                                ->orWhereHas('user', function($query) use($request) {
                                    $query->where('name','like', '%'. $request->search . '%');
                                });
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when($request->sort == 'numero_socio', function ($query) use ($request) {
                            $query->orderBy('numero_socio', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->paginate(20);
        return response()->json($categorias,201);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $categoria = Categoria::create($data);
            $categoria->load('user');
            Log::info('User: ' . Auth::user() . ' | Create categoria | '  . __METHOD__ . ' | Request Send to: ' . json_encode($data));
            return  response()->json(['response' => $categoria],201);
        }catch(Exception $exception) {
            Log::error($exception);
            Log::error('User: ' . Auth::user() . ' | Error Create categoria | Request Send to: ' . json_encode($data));
            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $data = $request->all();
            $categoria = Categoria::findOrFail($id);
            $categoria->update($data);
             $categoria->load('user');
            Log::info('User: ' . Auth::user() . ' | Update categoria | '  . __METHOD__ . ' | Request Send to: ' . json_encode($data));
            return  response()->json(['response' =>$categoria],200);
        }catch(Exception $exception) {
            Log::error($exception);
            Log::error('User: ' . Auth::user() . ' | Error Update categoria | Request Send to: ' . json_encode($data));
            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::select('id')->findOrFail($id);
            $categoria->delete();
            Log::info('Usuário ' .Auth::user() . ' Deletou a categoria | '  . __METHOD__ . ' |' .json_encode($categoria));
        }catch(Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    public function numberSociocheck(Request $request)
    {
        try {
            Log::info('User: '. Auth::user()->id . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()));
            $chip = Categoria::select('id', 'numero_socio')->whereNumeroSocio($request->numero_socio)->withTrashed();
            if($chip->first()) {
                if($chip->first()->id == $request->id[0]) {
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
