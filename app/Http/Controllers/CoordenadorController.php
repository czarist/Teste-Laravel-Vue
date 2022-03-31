<?php

namespace App\Http\Controllers;

use App\Models\Coordenador;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CoordenadorController extends Controller
{
    public function index()
    {
        return view('admin.coordenador.index');
    }

    public function usuarios()
    {
        return User::select('id', 'name', 'email','ativo', 'sexo_id', 'estrangeiro','passaporte','cpf','rg','orgao_expedidor','telefone','celular','data_nascimento')
            ->with('acessos:id,pagina,link',
                    'associado',   
                    'avaliador_expocom',
                    'coordenador_regional',
                    'todos_tipos:id,descricao',
                    'todos_divisoes_tematicas:id,descricao',
                    'todos_divisoes_tematicas_jr:id,descricao',
                    'todos_cinema_audiovisual:id,descricao',
                    'todos_jornalismo:id,descricao',
                    'todos_publicidade_propaganda:id,descricao',
                    'todos_relacoes_publicas:id,descricao',
                    'todos_producao_editorial:id,descricao',
                    'todos_radio_internet:id,descricao',    
            );
    }

    public function get(Request $request)
    {
        return $this->usuarios()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {    
                    $query->when($request->type == 'name', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    });
                    $query->when($request->type == 'cpf', function ($query) use ($request) {
                        $query->where('cpf', 'like', '%' . $request->search . '%');
                    });
                    $query->when($request->type == 'email', function ($query) use ($request) {
                        $query->where('email', 'like', '%' . $request->search . '%');
                    });
                });
            })
            ->when($request->sort == 'id', function ($query) {
                $query->orderBy('id', 'DESC');
            })
            ->when($request->sort == 'name', function ($query) use ($request) {
                $query->orderBy('name', $request->asc == 'true' ? 'ASC' : 'DESC');
            })
            ->when($request->status == 0, function ($query) use ($request) {
                $query->whereHas('coordenador_regional');
            })

            ->paginate(20);
    }

    public function store(Request $request)
    {
        try{
            $post = $request->all();
            $coordenador = Coordenador::create([
                'user_id' => $post['user_id'],
                'tipo' => $post['tipo'],
                'regiao' => $post['regiao'] ?? null,
                'ano' => $post['ano'],
                'dt' => $post['dt'][0] ?? null
            ]);

            Log::info('Coordenador create: '.$coordenador->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $coordenador], 201);
    
        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        $coordenador = Coordenador::findOrFail($request->id);

        try{
            $coordenador->update([
                'tipo' => $request->tipo,
                'regiao' => $request->regiao ?? null,
                'ano' => $request->ano,
                'dt' => $request->dt[0] ?? null
            ]);

            Log::info('Coordenador updated: '.$coordenador->id.' | Request: '.json_encode($request->all()));
            return response()->json(['message' => 'success', 'response' => $coordenador], 201);

        } catch (Exception $exception) {

            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
