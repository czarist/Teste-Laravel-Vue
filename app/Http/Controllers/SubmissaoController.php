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
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissaoController extends Controller
{
    public function index()
    {
        return view('regionais.avaliado.index');
    }

    public function submissao()
    {
        $regional_sul = RegionalSul::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_sudeste = RegionalSuldeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_nordeste = RegionalNordeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_norte = RegionalNorte::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();
        $regional_centro = RegionalCentrooeste::select('id', 'user_id')->where('user_id', Auth::user()->id)->first();

        $submissao = [];

        if ($regional_sul && $regional_sul->id) {
            $submissao_sul = SubmissaoRegionalSul::with('avaliacao')->whereInscricaoId($regional_sul->id)->get()->toArray();

            if (isset($submissao_sul)) {
                $submissao = array_merge($submissao, $submissao_sul);
            }
        }

        if ($regional_sudeste && $regional_sudeste->id) {
            $submissao_sudeste = SubmissaoRegionalSudeste::with('avaliacao')->whereInscricaoId($regional_sudeste->id)->get()->toArray();

            if (isset($submissao_sudeste)) {
                $submissao = array_merge($submissao, $submissao_sudeste);
            }
        }

        if ($regional_nordeste && $regional_nordeste->id) {
            $submissao_nordeste = SubmissaoRegionalNordestes::with('avaliacao')->whereInscricaoId($regional_nordeste->id)->get()->toArray();

            if (isset($submissao_nordeste)) {
                $submissao = array_merge($submissao, $submissao_nordeste);
            }
        }

        if ($regional_norte && $regional_norte->id) {
            $submissao_norte = SubmissaoRegionalNorte::with('avaliacao')->whereInscricaoId($regional_norte->id)->get()->toArray();

            if (isset($submissao_norte)) {
                $submissao = array_merge($submissao, $submissao_norte);
            }
        }

        if ($regional_centro && $regional_centro->id) {
            $submissao_centro = SubmissaoRegionalCentrooeste::with('avaliacao')->whereInscricaoId($regional_centro->id)->get()->toArray();

            if (isset($submissao_centro)) {
                $submissao = array_merge($submissao, $submissao_centro);
            }
        }

        return $submissao;
    }

    public function get(Request $request)
    {
        $data['data'] = $this->submissao();

        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $avaliacao = DistribuicaoTipo123::find($request->id);
        $avaliacao->update([
            'edit' => $request->edit,
        ]);

        Log::info('User: '.Auth::user()->id.' | Avaliação editada | ID: '.json_encode($request->all()));

        return response()->json(['success' => true, $avaliacao]);
    }

    public function carta_aceite($regiao, $id)
    {
        $trabalho['coautores'] = [];
        if ($regiao == 1) {
            $submissao = SubmissaoRegionalSul::with(
                'inscricao',
                'inscricao.user',
                'coautorOrientadorSubSuls'
            )->find($id);

            if (! empty($submissao) && $submissao->coautorOrientadorSubSuls) {
                foreach ($submissao->coautorOrientadorSubSuls as $coautor) {
                    array_push($trabalho['coautores'], $coautor->nome_completo);
                }
            }
        }

        if ($regiao == 2) {
            $submissao = SubmissaoRegionalNordestes::with(
                'inscricao',
                'inscricao.user',
                'coautorOrientadorSubNordeste'
            )->find($id);

            if (! empty($submissao) && $submissao->coautorOrientadorSubNordeste) {
                foreach ($submissao->coautorOrientadorSubNordeste as $coautor) {
                    array_push($trabalho['coautores'], $coautor->nome_completo);
                }
            }
        }

        if ($regiao == 3) {
            $submissao = SubmissaoRegionalSudeste::with(
                'inscricao',
                'inscricao.user',
                'coautorOrientadorSubSudeste'
            )->find($id);

            if (! empty($submissao) && $submissao->coautorOrientadorSubSudeste) {
                foreach ($submissao->coautorOrientadorSubSudeste as $coautor) {
                    array_push($trabalho['coautores'], $coautor->nome_completo);
                }
            }
        }

        if ($regiao == 4) {
            $submissao = SubmissaoRegionalCentrooeste::with(
                'inscricao',
                'inscricao.user',
                'coautorOrientadorSubCentrooeste'
            )->find($id);

            if (! empty($submissao) && $submissao->coautorOrientadorSubCentrooeste) {
                foreach ($submissao->coautorOrientadorSubCentrooeste as $coautor) {
                    array_push($trabalho['coautores'], $coautor->nome_completo);
                }
            }
        }

        if ($regiao == 5) {
            $submissao = SubmissaoRegionalNorte::with(
                'inscricao',
                'inscricao.user',
                'coautorOrientadorSubNorte'
            )->find($id);

            if (! empty($submissao) && $submissao->coautorOrientadorSubNorte) {
                foreach ($submissao->coautorOrientadorSubNorte as $coautor) {
                    array_push($trabalho['coautores'], $coautor->nome_completo);
                }
            }
        }

        if (! empty($submissao)) {
            $trabalho['titulo'] = $submissao->titulo;
        }
        if (! empty($submissao) && $submissao->inscricao && $submissao->inscricao->user) {
            $trabalho['autor'] = $submissao->inscricao->user->name;
        }

        $trabalho['data'] = date('Y');

        switch ($regiao) {
            case 1:
                $trabalho['regiao'] = 'Sul';
                break;
            case 2:
                $trabalho['regiao'] = 'Nordeste';
                break;
            case 3:
                $trabalho['regiao'] = 'Sudeste';
                break;
            case 4:
                $trabalho['regiao'] = 'Centro Oeste';
                break;
            case 5:
                $trabalho['regiao'] = 'Norte';
                break;
        }

        if (Auth::user()->id == $submissao->inscricao->user->id) {
            $data = view('pdf.carta_aceite.carta_aceite', compact('trabalho'));
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("carta_aceite_{$regiao}_{$id} R.pdf", ['Attachment' => false]);
            } else {
                $result = $dompdf->output();
            }

            return $result;
        }
    }
}
