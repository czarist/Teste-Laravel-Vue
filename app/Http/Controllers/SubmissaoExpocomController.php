<?php

namespace App\Http\Controllers;

use App\Models\DistribuicaoTipo123;
use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\SubmissaoExpocomRegionalCentrooeste;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Models\SubmissaoExpocomRegionalNorte;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\SubmissaoExpocomRegionalSul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoExpocomController extends Controller
{
    public function index()
    {
        return view('regionais.avaliadoExpocom.index');
    }

    public function submissao(){
        $regional_sul = RegionalSul::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_sudeste = RegionalSuldeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_nordeste = RegionalNordeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_norte = RegionalNorte::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_centro = RegionalCentrooeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
    
        $submissao = [];

        if($regional_sul && $regional_sul->id){

            $submissao_sul = SubmissaoExpocomRegionalSul::with('avaliacao')->whereInscricaoId($regional_sul->id)->get();
            
            if(isset($submissao_sul)){
                $submissao = array_merge($submissao, $submissao_sul);
            }

        }

        if($regional_sudeste && $regional_sudeste->id){
        
            $submissao_sudeste = SubmissaoExpocomRegionalSudeste::with('avaliacao')->whereInscricaoId($regional_sudeste->id)->get()->toArray();

            if(isset($submissao_sudeste)){
                $submissao = array_merge($submissao, $submissao_sudeste);
            }

        }

        if($regional_nordeste && $regional_nordeste->id){

            $submissao_nordeste = SubmissaoExpocomRegionalNordeste::with('avaliacao')->whereInscricaoId($regional_nordeste->id)->get()->toArray();

            if(isset($submissao_nordeste)){
                $submissao = array_merge($submissao, $submissao_nordeste);
            }
            
        }

        if($regional_norte && $regional_norte->id){

            $submissao_norte = SubmissaoExpocomRegionalNorte::with('avaliacao')->whereInscricaoId($regional_norte->id)->get()->toArray();

            if(isset($submissao_norte)){
                $submissao = array_merge($submissao, $submissao_norte);
            }
            
        }

        if($regional_centro && $regional_centro->id){
    
            $submissao_centro = SubmissaoExpocomRegionalCentrooeste::with('avaliacao')->whereInscricaoId($regional_centro->id)->get()->toArray();

            if(isset($submissao_centro)){
                $submissao = array_merge($submissao, $submissao_centro);
            }

        }
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
