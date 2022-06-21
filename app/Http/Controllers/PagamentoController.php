<?php

namespace App\Http\Controllers;

use App\Models\Nacional;
use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\Venda;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PagamentoController extends Controller
{
    public function index()
    {
        return view('pagamento.index');
    }

    public function get(Request $request)
    {
        $vendas = Venda::select('id', 'user_id', 'created_at')
                        ->with(
                                'pagamento',
                                'pagamento.tipo_pgto_detalhe',
                                'pagamento.status',
                                'pagamento.tipo_pgto',
                                'vendas_item', 
                                'vendas_item.produto',
                                'user:id,name,cpf'                                
                                )
                        ->wherehas('pagamento')
                        ->when($request->sort == 'id', function ($query) {
                            $query->orderBy('id', 'DESC');
                        })
                        ->when(Auth::user()->is_user && !Auth::user()->is_admin, function ($q) {
                            $q->whereUserId(Auth::user()->id);
                        })            
                        ->paginate(20);

        return response()->json($vendas, 201);
    }

    public function recibo_pagamento(Request $request){

        if(!$request->has('nome') ||  !$request->has('cpf') ||  !$request->has('valor') || !$request->has('produto_id') ||
        !$request->has('data_pagamento') || !$request->has('tipo_pagamento') || !$request->has('autenticacao')){
            return response()->json(['error' => 'Falta Informação'], 400);
        }

        $recibo = [];
        $recibo['nome'] = $request->nome;
        $recibo['cpf'] = $request->cpf;
        $recibo['valor'] = $request->valor;
        $recibo['data_pagamento'] = Carbon::create($request->data_pagamento)->format('d/m/Y');

        $recibo['tipo_pagamento'] = $request->tipo_pagamento;
        $recibo['autenticacao'] = $request->autenticacao;

        if($request->produto_id != null){
            if($request->produto_id == 1 || $request->produto_id == 2){
                $recibo['numero_congresso'] = "Anuidade 2022";
                $recibo['data_congresso'] = "2022";
                $regional= RegionalSul::where('user_id', Auth::user()->id)->first();
                if($request->produto_id != null){
                    $recibo['recibo'] = $request->produto_id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['recibo'] = 0;                    
                }

                if(Auth::user()->id){
                    $data = view('pdf.recibo.recibo_pagamento_anuidade', compact('recibo'));
                    $options = new Options();
                    $options->set('isRemoteEnabled', TRUE);
                    $options->set("isPhpEnabled", true);
                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml($data);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    $fontMetrics = $dompdf->getFontMetrics();
                    $canvas = $dompdf->get_canvas();
                    $font = $fontMetrics->getFont('Courier');
                    $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));
        
                    if (empty($output) || $output == null) {
                        $result = $dompdf->stream("recibo_pagamento_R.pdf", array("Attachment" => false));
                    } else {
                        $result = $dompdf->output();
                    }
                    return $result;
    
                } else{
                    return response()->json(['error' => 'Usuário não tem permissão para gerar o recibo'], 400);
                }
    
            }    

            if($request->produto_id == 3 || $request->produto_id == 4 || $request->produto_id == 5 || $request->produto_id == 6){
                $recibo['numero_congresso'] = "21º Congresso de Ciências da Comunicação na Região Sul";
                $recibo['data_congresso'] = "16 a 18 de junho de 2022";
                $regional= RegionalSul::where('user_id', Auth::user()->id)->first();
                if($regional != null){
                    $recibo['inscricao'] = $regional->id ?? "Sem Inscrição";
                    $recibo['recibo'] = $regional->id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['inscricao'] = 0;
                    $recibo['recibo'] = 0;                    
                }
            }

            if($request->produto_id == 8 || $request->produto_id == 9 || $request->produto_id == 10 || $request->produto_id == 11){
                $recibo['numero_congresso'] = "22º Congresso de Ciências da Comunicação na Região Nordeste";
                $recibo['data_congresso'] = "18 a 20 de maio de 2022";
                $regional= RegionalNordeste::where('user_id', Auth::user()->id)->first();
                if($regional != null){
                    $recibo['inscricao'] = $regional->id ?? "Sem Inscrição";
                    $recibo['recibo'] = $regional->id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['inscricao'] = 0;
                    $recibo['recibo'] = 0;                    
                }
            }

            if($request->produto_id == 13 || $request->produto_id == 14 || $request->produto_id == 15 || $request->produto_id == 16){
                $recibo['numero_congresso'] = "25º Congresso de Ciências da Comunicação na Região Sudeste";
                $recibo['data_congresso'] = "26 a 28 de maio de 2022";
                $regional= RegionalSuldeste::where('user_id', Auth::user()->id)->first();
                if($regional != null){
                    $recibo['inscricao'] = $regional->id ?? "Sem Inscrição";
                    $recibo['recibo'] = $regional->id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['inscricao'] = 0;
                    $recibo['recibo'] = 0;                    
                }
            }

            if($request->produto_id == 18 || $request->produto_id == 19 || $request->produto_id == 20 || $request->produto_id == 21){
                $recibo['numero_congresso'] = "22º Congresso de Ciências da Comunicação na Região Centro-Oeste";
                $recibo['data_congresso'] = "9 a 11 de junho de 2022";
                $regional= RegionalCentrooeste::where('user_id', Auth::user()->id)->first();
                if($regional != null){
                    $recibo['inscricao'] = $regional->id ?? "Sem Inscrição";
                    $recibo['recibo'] = $regional->id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['inscricao'] = 0;
                    $recibo['recibo'] = 0;                    
                }
            }

            if($request->produto_id == 23 || $request->produto_id == 24 || $request->produto_id == 25 || $request->produto_id == 26){
                $recibo['numero_congresso'] = "19º Congresso de Ciências da Comunicação na Região Norte";
                $recibo['data_congresso'] = "2 a 4 de junho de 2022";
                $regional= RegionalNorte::where('user_id', Auth::user()->id)->first();
                if($regional != null){
                    $recibo['inscricao'] = $regional->id ?? "Sem Inscrição";
                    $recibo['recibo'] = $regional->id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['inscricao'] = 0;
                    $recibo['recibo'] = 0;                    
                }
            }

            if($request->produto_id == 27 || $request->produto_id == 28 || $request->produto_id == 29 || $request->produto_id == 30){
                $recibo['numero_congresso'] = "45º Congresso Brasileiro de Ciências da Comunicação";
                $recibo['data_congresso'] = "5 a 9 de setembro de 2022";
                $regional= Nacional::where('user_id', Auth::user()->id)->first();
                if($regional != null){
                    $recibo['inscricao'] = $regional->id ?? "Sem Inscrição";
                    $recibo['recibo'] = $regional->id + Auth::user()->id ?? "Sem Número de Recibo";
                }else{
                    $recibo['inscricao'] = 0;
                    $recibo['recibo'] = 0;                    
                }
            }
            
            if(Auth::user()->id == $regional->user_id){
                $data = view('pdf.recibo.recibo_pagamento', compact('recibo'));
                $options = new Options();
                $options->set('isRemoteEnabled', TRUE);
                $options->set("isPhpEnabled", true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));
    
                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("recibo_pagamento_R.pdf", array("Attachment" => false));
                } else {
                    $result = $dompdf->output();
                }
                return $result;

            } else{
                return response()->json(['error' => 'Usuário não tem permissão para gerar o recibo'], 400);
            }
    
        }
    }
}
