<?php

namespace App\Http\Controllers;

use App\Models\Sexo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SexoController extends Controller
{
    public function index()
    {
        return view('config.sexo.index');
    }

    public function get(Request $request)
    {
        $sexos = Sexo::select('id','tipo_sexo')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function($q) use ($request) {
                                $q->where('tipo_sexo', 'like', '%'. $request->search . '%');
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when($request->sort == 'tipo_sexo', function ($query) use ($request) {
                            $query->orderBy('tipo_sexo', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->paginate(20);
        return response()->json($sexos,201);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $sexo = Sexo::create($data);
            Log::info('User: ' . Auth::user() . ' | Create sexo | '  . __METHOD__ . ' | Request Send to: ' . json_encode($data));
            return  response()->json(['response' => $sexo],201);
        }catch(Exception $exception) {
            Log::error($exception);
            Log::error('User: ' . Auth::user() . ' | Error Create sexo | Request Send to: ' . json_encode($data));
            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $data = $request->all();
            $sexo = sexo::findOrFail($id);
            $sexo->update($data);
            Log::info('User: ' . Auth::user() . ' | Update sexo | '  . __METHOD__ . ' | Request Send to: ' . json_encode($data));
            return  response()->json(['response' =>$sexo],200);
        }catch(Exception $exception) {
            Log::error($exception);
            Log::error('User: ' . Auth::user() . ' | Error Update sexo | Request Send to: ' . json_encode($data));
            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $sexo = Sexo::select('id')->findOrFail($id);
            $sexo->delete();
            Log::info('Usuário ' .Auth::user() . ' Deletou a sexo | '  . __METHOD__ . ' |' .json_encode($sexo));
        }catch(Exception $exception) {
            Log::error($exception);
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
