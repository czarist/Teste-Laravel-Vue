<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InstituicaoController extends Controller
{
    public function index()
    {
        return view('admin.instituicao.index');
    }

    public function get(Request $request)
    {
        $titulacooes = Instituicao::select('id', 'instituicao', 'sigla_instituicao')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where(function ($q) use ($request) {
                                $q->where('instituicao', 'like', '%'.$request->search.'%');
                            });
                        })
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when($request->sort == 'instituicao', function ($query) use ($request) {
                            $query->orderBy('instituicao', $request->asc == 'true' ? 'ASC' : 'DESC');
                        })
                        ->paginate(20);

        return response()->json($titulacooes, 201);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $instituicao = Instituicao::create($data);
            Log::info('User: '.Auth::user().' | Create instituicao | '.__METHOD__.' | Request Send to: '.json_encode($data));

            return  response()->json(['response' => $instituicao], 201);
        } catch (Exception $exception) {
            Log::error($exception);
            Log::error('User: '.Auth::user().' | Error Create instituicao | Request Send to: '.json_encode($data));

            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $instituicao = Instituicao::findOrFail($id);
            $instituicao->update($data);
            Log::info('User: '.Auth::user().' | Update instituicao | '.__METHOD__.' | Request Send to: '.json_encode($data));

            return  response()->json(['response' =>$instituicao], 200);
        } catch (Exception $exception) {
            Log::error($exception);
            Log::error('User: '.Auth::user().' | Error Update instituicao | Request Send to: '.json_encode($data));

            return  response()->json(['status' => 'Server Error'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $instituicao = Instituicao::select('id')->findOrFail($id);
            $instituicao->delete();
            Log::info('Usuário '.Auth::user().' Deletou a instituicao | '.__METHOD__.' |'.json_encode($instituicao));
        } catch (Exception $exception) {
            Log::error($exception);

            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
