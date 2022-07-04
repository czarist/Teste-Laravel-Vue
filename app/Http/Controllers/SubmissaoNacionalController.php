<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoNacional;
use App\Models\CoautorOrganizadoresSubNaci;
use App\Models\SubmissaoNacional;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoNacionalController extends Controller
{
    public function usuario()
    {
        return User::select('id', 'name')
            ->with(
                'todos_tipos:id,descricao',
                'associado',
                'enderecos',
                'nacional',
                'nacional.submissaoPublicom.avaliacao',
                'nacional.submissaoPublicom.CoautorOrganizadoresSubNaci',
                'nacional.submissaoGp.avaliacao',
                'nacional.submissaoGp.CoautorOrganizadoresSubNaci',
                'nacional.submissaoJunior.avaliacao',
                'nacional.submissaoJunior.CoautorOrganizadoresSubNaci',
            )
                ->find(Auth::user()->id);
    }

    public function submissaoJunior()
    {
        $user = $this->usuario();
        $tipo = 1;

        return view('nacional.inscricao.submissaojunior', compact('user', 'tipo'));
    }

    public function submissaoGp()
    {
        $user = $this->usuario();
        $tipo = 2;

        return view('nacional.inscricao.submissaogp', compact('user', 'tipo'));
    }

    public function submissaoPublicom()
    {
        $user = $this->usuario();
        $tipo = 3;

        return view('nacional.inscricao.submissaopublicom', compact('user', 'tipo'));
    }

    public function store(Request $request)
    {
        try {
            $post = json_decode($request->post);
            $user = User::findOrFail(Auth::user()->id);
            $submissao = SubmissaoNacional::where('id', $post->id ?? null)->first();

            //IDS DOS COAUTORES QUE FORAM ENVIADOS PELO FORMULÁRIO
            $coautor_ids = array_map(function ($res) {
                return $res->id ?? null;
            }, $post->coautoresOrientadores);

            if (! empty($submissao) && $submissao->tipo == $post->tipo->name) {
                $coautores = CoautorOrganizadoresSubNaci::where('submissao_id', $submissao->id)->get();
                foreach ($coautores as $coautor) {
                    if (! in_array($coautor->id, $coautor_ids)) {
                        $coautor->delete();
                    }
                }
            }

            $now = Carbon::now()->format('Y-m-d H:i:s');

            if ($now <= '2022-07-12 00:00:00') {
                if (empty($submissao) || $submissao->tipo != $post->tipo->name) {
                    $submissao_save = SubmissaoNacional::create([
                        'inscricao_id' => $user->nacional->id,
                        'dt' => $post->divisoes_tematicas[0],
                        'ciente' => $post->ciente,
                        'tipo' => $post->tipo->name,
                        'titulo' => $post->titulo,
                        'lattes' => $post->lattes,
                        'termo_autoria' => $post->termo_autoria,
                        'autorizacao' => $post->autorizacao,
                        'ano' => $post->ano,
                        'editora' => $post->editora,
                    ]);

                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $name = date('mdYHis').uniqid();
                        $file->move(public_path().'/pdf/submissao_nacional_2022/', $name);
                        $submissao_save->link_trabalho = $name;
                        $submissao_save->save();
                    }

                    foreach ($post->coautoresOrientadores as $coautor) {
                        if (! empty($coautor->id)) {
                            $coautor_save = CoautorOrganizadoresSubNaci::findOrFail($coautor->id);

                            $coautor_save->update([
                                'submissao_id' => $submissao_save->id,
                                'nome_completo' => $coautor->nome_completo,
                                'cpf' => $coautor->cpf,
                                'categoria' => $coautor->categoria,
                            ]);
                        }

                        if (empty($coautor->id)) {
                            $coautor_save = CoautorOrganizadoresSubNaci::create([
                                'submissao_id' => $submissao_save->id,
                                'nome_completo' => $coautor->nome_completo,
                                'cpf' => $coautor->cpf,
                                'categoria' => $coautor->categoria,
                            ]);
                        }
                    }
                }
            }

            if (! empty($submissao) && $submissao->tipo == $post->tipo->name) {
                $submissao->update([
                    'tipo' => $post->tipo->name,
                    'dt' => $post->divisoes_tematicas[0],
                    'ciente' => $post->ciente,
                    'titulo' => $post->titulo,
                    'lattes' => $post->lattes,
                    'termo_autoria' => $post->termo_autoria,
                    'autorizacao' => $post->autorizacao,
                    'ano' => $post->ano,
                    'editora' => $post->editora,
                ]);

                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $name = date('mdYHis').uniqid();
                    $file->move(public_path().'/pdf/submissao_nacional_2022/', $name);
                    $submissao->link_trabalho = $name;
                    $submissao->save();
                }

                foreach ($post->coautoresOrientadores as $coautor) {
                    if (! empty($coautor->id)) {
                        $coautor_save = CoautorOrganizadoresSubNaci::findOrFail($coautor->id);

                        $coautor_save->update([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria,
                        ]);
                    }

                    if (empty($coautor->id)) {
                        $coautor_save = CoautorOrganizadoresSubNaci::create([
                            'submissao_id' => $submissao->id,
                            'nome_completo' => $coautor->nome_completo,
                            'cpf' => $coautor->cpf,
                            'categoria' => $coautor->categoria,
                        ]);
                    }
                }

                // if($submissao && $submissao->id){
                //     $sub = SubmissaoNacional::select('id', 'avaliacao')
                //     ->with('avaliacao')
                //     ->whereId($submissao->id)->first();

                //     $avaliacao = DistribuicaoTipo123::where('id', $sub->avaliacao)->first();
                //     if(!empty($avaliacao)){
                //         $avaliacao->update([
                //             'edit' => 0,
                //         ]);
                //     }
                // }
            }

            Log::info('User: '.Auth::user()->id.' | Nacional 2022 | Submeteu seu trabalho: '.json_encode($post));

            return response()->json(['message' => 'success', 'response' => $user], 201);
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function edit(Request $request)
    {
        $avaliacao = AvaliacaoNacional::findOrFail($request->id);
        $avaliacao->update([
            'edit' => $request->edit,
        ]);

        Log::info('User: '.Auth::user()->id.' | Avaliação Nacional editada | ID: '.json_encode($request->all()));

        return response()->json(['success' => true, $avaliacao]);
    }

}
