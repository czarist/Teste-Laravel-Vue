<?php

namespace App\Http\Controllers;

use App\Models\Titulacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TitulacaoController extends Controller
{
    public function index()
    {
        return view('admin.titulacao.index');
    }

    public function get(Request $request)
    {
        $titulacooes = Titulacao::select('id', 'titulacao')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($q) use ($request) {
                                $q->where('titulacao', 'like', '%'.$request->search.'%');
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when($request->sort == 'titulacao', function ($query) use ($request) {
                            $query->orderBy('titulacao', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->paginate(20);

        return response()->json($titulacooes, 201);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $titulacao = Titulacao::create($data);
            Log::info('User: '.Auth::user().' | Create titulacao | '.__METHOD__.' | Request Send to: '.json_encode($data));

            return  response()->json(['response' => $titulacao], 201);
        } catch (Exception $exception) {
            Log::error($exception);
            Log::error('User: '.Auth::user().' | Error Create titulacao | Request Send to: '.json_encode($data));

            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $titulacao = Titulacao::findOrFail($id);
            $titulacao->update($data);
            Log::info('User: '.Auth::user().' | Update titulacao | '.__METHOD__.' | Request Send to: '.json_encode($data));

            return  response()->json(['response' =>$titulacao], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            Log::error('User: '.Auth::user().' | Error Update titulacao | Request Send to: '.json_encode($data));

            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $titulacao = Titulacao::select('id')->findOrFail($id);
            $titulacao->delete();
            Log::info('Usuário '.Auth::user().' Deletou a titulacao | '.__METHOD__.' |'.json_encode($titulacao));
        } catch (Exception $exception) {
            Log::error($exception);

            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
