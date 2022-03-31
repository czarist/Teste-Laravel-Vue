<?php

namespace App\Http\Controllers;

use App\Models\DistribuicaoTipo123;
use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalNorte;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoController extends Controller
{
    public function index()
    {
        return view('regionais.avaliado.index');
    }

    public function submissao(){
        $regional_sul = RegionalSul::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_sudeste = RegionalSuldeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_nordeste = RegionalNordeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_norte = RegionalNorte::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_centro = RegionalCentrooeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();

        $submissao_sul = SubmissaoRegionalSul::with('avaliacao')->whereInscricaoId($regional_sul->id)->get();
        $submissao_sudeste = SubmissaoRegionalSudeste::with('avaliacao')->whereInscricaoId($regional_sudeste->id)->get();
        $submissao_nordeste = SubmissaoRegionalNordestes::with('avaliacao')->whereInscricaoId($regional_nordeste->id)->get();
        $submissao_norte = SubmissaoRegionalNorte::with('avaliacao')->whereInscricaoId($regional_norte->id)->get();
        $submissao_centro = SubmissaoRegionalCentrooeste::with('avaliacao')->whereInscricaoId($regional_centro->id)->get();

        $submissao = $submissao_sul->merge($submissao_sudeste)->merge($submissao_nordeste)->merge($submissao_norte)->merge($submissao_centro);

        return $submissao;
    }

    public function get(Request $request){
        $data['data'] = $this->submissao();

        return response()->json($data);
    }

    public function edit(Request $request){

        $avaliacao = DistribuicaoTipo123::find($request->id);
        $avaliacao->update([
            'edit' => $request->edit
        ]);

        Log::info('User: '.Auth::user()->id.' | Avaliação editada | ID: '.json_encode($request->all()));

        return response()->json(['success' => true, $avaliacao]);
    }
}
