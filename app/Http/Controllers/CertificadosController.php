<?php

namespace App\Http\Controllers;

use App\Models\AvaliadorExpocom;
use App\Models\DistribuicaoTipo123;
use App\Models\DistribuicaoTipoExpocom;
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
use App\Models\SubmissaoRegionalCentrooeste;
use App\Models\SubmissaoRegionalNordestes;
use App\Models\SubmissaoRegionalNorte;
use App\Models\SubmissaoRegionalSudeste;
use App\Models\SubmissaoRegionalSul;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;

class CertificadosController extends Controller
{
    public function index()
    {
        $user = User::select('id', 'name', 'email', 'cpf')
        ->with(
            'todos_tipos:id,descricao',
            'regional_nordeste:id,user_id,regiao,ano,presenca',
            'regional_nordeste.submissaoExpocom:id,inscricao_id,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_nordeste.submissaoExpocom.coautorOrientadorSubNordeste',
            'regional_nordeste.submissaoMesa',
            'regional_nordeste.submissaoDt',
            'regional_nordeste.submissaoJunior',
            'regional_norte:id,user_id,regiao,ano,presenca',
            'regional_norte.submissaoExpocom:id,inscricao_id,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_norte.submissaoExpocom.coautorOrientadorSubNortes',
            'regional_sul:id,user_id,regiao,ano,presenca',
            'regional_sul.submissaoExpocom:id,inscricao_id,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_sul.submissaoExpocom.coautorOrientadorSubSuls',
            'regional_suldeste:id,user_id,regiao,ano,presenca',
            'regional_suldeste.submissaoExpocom:id,inscricao_id,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_suldeste.submissaoExpocom.coautorOrientadorSubSudeste',
            'regional_centrooeste:id,user_id,regiao,ano,presenca',
            'regional_centrooeste.submissaoExpocom:id,inscricao_id,regiao,ano,apresentacao,vencedor,regiao,ano',
            'regional_centrooeste.submissaoExpocom.coautorOrientadorSubCentrooeste',
            'nacional',

            'coautor_nordeste_2022',
            'coautor_nordeste_2022.submissao',
            'coautor_norte_2022',
            'coautor_norte_2022.submissao',
            'coautor_sudeste_2022',
            'coautor_sudeste_2022.submissao',
            'coautor_sul_2022',
            'coautor_sul_2022.submissao',
            'coautor_centrooeste_2022',
            'coautor_centrooeste_2022.submissao',

            'coautor_expo_nordeste_2022',
            'coautor_expo_nordeste_2022.submissao',
            'coautor_expo_norte_2022',
            'coautor_expo_norte_2022.submissao',
            'coautor_expo_sudeste_2022',
            'coautor_expo_sudeste_2022.submissao',
            'coautor_expo_sul_2022',
            'coautor_expo_sul_2022.submissao',
            'coautor_expo_centrooeste_2022',
            'coautor_expo_centrooeste_2022.submissao',
        )
        ->whereId(Auth::user()->id)
        ->first();

        return view('certificado.index', compact('user'));
    }

    public function certificado_presenca($user_id, $regiao, $id)
    {
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO

        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')->findOrFail($user_id);
        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
        }

        if ($regiao == 'centrooeste') {
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Centro-Oeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
        } elseif ($regiao == 'nordeste') {
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        } elseif ($regiao == 'norte') {
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
        } elseif ($regiao == 'sul') {
            $regional = RegionalSul::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Sul';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
        } elseif ($regiao == 'suldeste') {
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        if (! empty($regional)) {
            $certificado['regional'] = $regional->toArray();
        }
        if (isset($regional) && ! empty($regional) && $regional->presenca == 1) {
            if (Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id) {
                if ($regiao == 'nordeste') {
                    $data = view('pdf.certificados.certificado_presenca_nordeste', compact('certificado'));
                }
                if ($regiao == 'suldeste') {
                    $data = view('pdf.certificados.certificado_presenca_sudeste', compact('certificado'));
                }
                if ($regiao == 'norte') {
                    $data = view('pdf.certificados.certificado_presenca_norte', compact('certificado'));
                }
                if ($regiao == 'sul') {
                    $data = view('pdf.certificados.certificado_presenca_sul', compact('certificado'));
                }
                if ($regiao == 'centrooeste') {
                    $data = view('pdf.certificados.certificado_presenca_centrooeste', compact('certificado'));
                }

                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('isPhpEnabled', true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                // $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));
                if ($regiao == 'nordeste') {
                    $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);
                }
                if ($regiao == 'suldeste') {
                    $canvas->page_text(450, 818, '', $font, 8, [0, 0, 0]);
                }

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_presenca_{$user_id}_{$regiao}_{$id} R.pdf", ['Attachment' => false]);
                } else {
                    $result = $dompdf->output();
                }

                return $result;
            }
        }
    }

    public function certificado_apresentacao_expocom($user_id, $regiao, $id)
    {
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO

        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')
        ->with('indicacao')
        ->findOrFail($user_id);

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
            $certificado['categoria'] = $user->indicacao->categoria ?? 'Sem categoria';
            $certificado['modalidade'] = $user->indicacao->modalidade ?? 'Sem modalidade';
            $certificado['titulo'] = $user->indicacao->titulo_trabalho;
            $certificado['coautores'][] = trim(ucwords(mb_strtolower($user->name)));
        }

        if ($regiao == 'centrooeste') {
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubCentrooeste')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubCentrooeste) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubCentrooeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Centro-Oeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
        } elseif ($regiao == 'nordeste') {
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNordeste')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNordeste) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubNordeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        } elseif ($regiao == 'norte') {
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNorte')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNorte) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubNorte as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
        } elseif ($regiao == 'sul') {
            $regional = RegionalSul::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSuls')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSuls) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubSuls as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Sul';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
        } elseif ($regiao == 'suldeste') {
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSudeste')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSudeste) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubSudeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        $certificado['coautores'] = array_unique($certificado['coautores']);

        if (isset($regional) && ! empty($regional) && $regional->presenca == 1 && $regional->submissaoExpocom->apresentacao == 1) {
            if (Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id) {
                if ($regiao == 'nordeste') {
                    $data = view('pdf.certificados.certificado_apresentacao_expocom_nordeste', compact('certificado'));
                }
                if ($regiao == 'suldeste') {
                    $data = view('pdf.certificados.certificado_apresentacao_expocom_sudeste', compact('certificado'));
                }
                if ($regiao == 'norte') {
                    $data = view('pdf.certificados.certificado_apresentacao_expocom_norte', compact('certificado'));
                }
                if ($regiao == 'sul') {
                    $data = view('pdf.certificados.certificado_apresentacao_expocom_sul', compact('certificado'));
                }
                if ($regiao == 'centrooeste') {
                    $data = view('pdf.certificados.certificado_apresentacao_expocom_centrooeste', compact('certificado'));
                }

                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('isPhpEnabled', true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_apresentacao_expocom_{$user_id}_{$regiao}_{$id} R.pdf", ['Attachment' => false]);
                } else {
                    $result = $dompdf->output();
                }

                return $result;
            }
        }
    }

    public function certificado_vencedor_expocom($user_id, $regiao, $id)
    {
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO
        $certificado = [];

        $user = User::select('id', 'name', 'email', 'cpf')
        ->with('indicacao')
        ->findOrFail($user_id);

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
            $certificado['categoria'] = $user->indicacao->categoria ?? 'Sem categoria';
            $certificado['modalidade'] = $user->indicacao->modalidade ?? 'Sem modalidade';
            $certificado['titulo'] = $user->indicacao->titulo_trabalho;
            $certificado['coautores'][] = trim(ucwords(mb_strtolower($user->name)));
        }

        if ($regiao == 'centrooeste') {
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubCentrooeste')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubCentrooeste) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubCentrooeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Centro-Oeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
        } elseif ($regiao == 'nordeste') {
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNordeste')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNordeste) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubNordeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        } elseif ($regiao == 'norte') {
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNorte')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNorte) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubNorte as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
        } elseif ($regiao == 'sul') {
            $regional = RegionalSul::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSuls')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSuls) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubSuls as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Sul';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
        } elseif ($regiao == 'suldeste') {
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSudeste')
            ->findOrFail($id);

            if ($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSudeste) {
                foreach ($regional->submissaoExpocom->coautorOrientadorSubSudeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }
            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        $certificado['coautores'] = array_unique($certificado['coautores']);

        if (isset($regional) && ! empty($regional) && $regional->presenca == 1 && $regional->submissaoExpocom->apresentacao == 1 && $regional->submissaoExpocom->vencedor == 1) {
            if (Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id) {
                if ($regiao == 'nordeste') {
                    $data = view('pdf.certificados.certificado_vencedor_expocom_nordeste', compact('certificado'));
                }
                if ($regiao == 'suldeste') {
                    $data = view('pdf.certificados.certificado_vencedor_expocom_sudeste', compact('certificado'));
                }
                if ($regiao == 'norte') {
                    $data = view('pdf.certificados.certificado_vencedor_expocom_norte', compact('certificado'));
                }
                if ($regiao == 'centrooeste') {
                    $data = view('pdf.certificados.certificado_vencedor_expocom_centrooeste', compact('certificado'));
                }
                if ($regiao == 'sul') {
                    $data = view('pdf.certificados.certificado_vencedor_expocom_sul', compact('certificado'));
                }

                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('isPhpEnabled', true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_vencedor_expocom_{$user_id}_{$regiao}_{$id} R.pdf", ['Attachment' => false]);
                } else {
                    $result = $dompdf->output();
                }

                return $result;
            }
        }
    }

    public function certificado_apresentacao_expocom_coautor($user_id, $submissao_id, $regiao)
    {

        $user = User::select('id', 'cpf', 'name')->with('todos_tipos',)->where('id', $user_id)->first();

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
            $certificado['coautores'][] = trim(ucwords(mb_strtolower($user->name)));
        }

        if (isset($regiao) && $regiao == 'nordeste') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 7) {
                        $submissao = SubmissaoExpocomRegionalNordeste::with(
                            'coautorOrientadorSubNordeste',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubNordeste) {
                                foreach ($submissao->coautorOrientadorSubNordeste as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] =trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }
                            $regiao = 'nordeste';
                            $certificado['regiao'] = 'Nordeste';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'sudeste') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 8) {
                        $submissao = SubmissaoExpocomRegionalSudeste::with(
                            'coautorOrientadorSubSudeste',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubSudeste) {
                                foreach ($submissao->coautorOrientadorSubSudeste as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }

                            $regiao = 'sudeste';
                            $certificado['regiao'] = 'Sudeste';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'norte') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 10) {
                        $submissao = SubmissaoExpocomRegionalNorte::with(
                            'coautorOrientadorSubNortes',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubNortes) {
                                foreach ($submissao->coautorOrientadorSubNortes as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }

                            $regiao = 'norte';
                            $certificado['regiao'] = 'Norte';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'sul') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 6) {
                        $submissao = SubmissaoExpocomRegionalSul::with(
                            'coautorOrientadorSubSuls',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubSuls) {
                                foreach ($submissao->coautorOrientadorSubSuls as $coautor) {
                                    if ($coautor->cpf != $user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }

                            $regiao = 'sul';
                            $certificado['regiao'] = 'Sul';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'centrooeste') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 9) {
                        $submissao = SubmissaoExpocomRegionalCentrooeste::with(
                            'coautorOrientadorSubCentrooeste',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = $submissao->inscricao->user->name;
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubCentrooeste) {
                                foreach ($submissao->coautorOrientadorSubCentrooeste as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = $coautor->nome_completo;
                                    }
                                }
                            }

                            $regiao = 'centrooeste';
                            $certificado['regiao'] = 'Centro-Oeste';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
                        }
                    }
                }
            }
        }

        $certificado['coautores'] = array_unique($certificado['coautores']);

        if (in_array('', $certificado)) {
            return false;
        }

        if (Auth::user()->id == $user_id) {
            if ($regiao == 'nordeste') {
                $data = view('pdf.certificados.certificado_apresentacao_expocom_nordeste', compact('certificado'));
            }
            if ($regiao == 'sudeste') {
                $data = view('pdf.certificados.certificado_apresentacao_expocom_sudeste', compact('certificado'));
            }
            if ($regiao == 'norte') {
                $data = view('pdf.certificados.certificado_apresentacao_expocom_norte', compact('certificado'));
            }
            if ($regiao == 'sul') {
                $data = view('pdf.certificados.certificado_apresentacao_expocom_sul', compact('certificado'));
            }
            if ($regiao == 'centrooeste') {
                $data = view('pdf.certificados.certificado_apresentacao_expocom_centrooeste', compact('certificado'));
            }

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_apresentacao_expocom_{$user_id}_{$regiao}_R.pdf", ['Attachment' => false]);
            } else {
                $result = $dompdf->output();
            }

            return $result;
        }
    }

    public function certificado_vencedor_expocom_coautor($user_id, $submissao_id, $regiao)
    {
        $user = User::select('id', 'cpf', 'name')->with('todos_tipos')->where('id', $user_id)->first();

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
            $certificado['coautores'][] = trim(ucwords(mb_strtolower($user->name)));
        }

        if (isset($regiao) && $regiao == 'nordeste') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 7) {
                        $submissao = SubmissaoExpocomRegionalNordeste::with(
                            'coautorOrientadorSubNordeste',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubNordeste) {
                                foreach ($submissao->coautorOrientadorSubNordeste as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }

                            $regiao = 'nordeste';
                            $certificado['regiao'] = 'Nordeste';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'suldeste') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 8) {
                        $submissao = SubmissaoExpocomRegionalSudeste::with(
                            'coautorOrientadorSubSudeste',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubSudeste) {
                                foreach ($submissao->coautorOrientadorSubSudeste as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }
                            $regiao = 'suldeste';
                            $certificado['regiao'] = 'Sudeste';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'norte') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 10) {
                        $submissao = SubmissaoExpocomRegionalNorte::with(
                            'coautorOrientadorSubNortes',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubNortes) {
                                foreach ($submissao->coautorOrientadorSubNortes as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }
                            $regiao = 'norte';
                            $certificado['regiao'] = 'Norte';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'sul') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 6) {
                        $submissao = SubmissaoExpocomRegionalSul::with(
                            'coautorOrientadorSubSuls',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubSuls) {
                                foreach ($submissao->coautorOrientadorSubSuls as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }
                            $regiao = 'sul';
                            $certificado['regiao'] = 'Sul';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
                        }
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'centrooeste') {
            if (isset($user) && ! empty($user)) {
                foreach ($user->todos_tipos as $tipo) {
                    if ($tipo->id == 9) {
                        $submissao = SubmissaoExpocomRegionalCentrooeste::with(
                            'coautorOrientadorSubCentrooeste',
                            'inscricao',
                            'inscricao.user',
                            'inscricao.user.indicacao',
                        )
                            ->where('id', $submissao_id)
                        ->first();

                        if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                            if (isset($submissao) && $submissao->inscricao) {
                                $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;
                                $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                            }

                            if (isset($submissao) && $submissao->coautorOrientadorSubCentrooeste) {
                                foreach ($submissao->coautorOrientadorSubCentrooeste as $coautor) {
                                    if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                    }
                                }
                            }
                            $regiao = 'centrooeste';
                            $certificado['regiao'] = 'Centro-Oeste';
                            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
                        }
                    }
                }
            }
        }

        $certificado['coautores'] = array_unique($certificado['coautores']);

        if (in_array('', $certificado)) {
            return false;
        }

        if (Auth::user()->id == $user_id) {
            if ($regiao == 'nordeste') {
                $data = view('pdf.certificados.certificado_vencedor_expocom_nordeste', compact('certificado'));
            }
            if ($regiao == 'suldeste') {
                $data = view('pdf.certificados.certificado_vencedor_expocom_sudeste', compact('certificado'));
            }
            if ($regiao == 'norte') {
                $data = view('pdf.certificados.certificado_vencedor_expocom_norte', compact('certificado'));
            }
            if ($regiao == 'sul') {
                $data = view('pdf.certificados.certificado_vencedor_expocom_sul', compact('certificado'));
            }
            if ($regiao == 'centrooeste') {
                $data = view('pdf.certificados.certificado_vencedor_expocom_centrooeste', compact('certificado'));
            }

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_vencedor_expocom_{$user_id}_{$regiao}_R.pdf", ['Attachment' => false]);
            } else {
                $result = $dompdf->output();
            }

            return $result;
        }
    }

    public function certificado_apresentacao($user_id, $regiao, $id)
    {
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO

        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')
        ->findOrFail($user_id);

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
            $certificado['coautores'][] = trim(ucwords(mb_strtolower($user->name)));
        }

        if ($regiao == 'centrooeste') {
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')
            ->with(
                'submissaoMesa',
                'submissaoDt',
                'submissaoJunior',
                'submissaoMesa.divisao_tematica',
                'submissaoDt.divisao_tematica',
                'submissaoJunior.divisao_tematica',
                'submissaoMesa.coautorOrientadorSubCentrooeste',
                'submissaoDt.coautorOrientadorSubCentrooeste',
                'submissaoJunior.coautorOrientadorSubCentrooeste',
            )
            ->findOrFail($id);

            if (isset($regional) && ! empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubCentrooeste) {
                $certificado['titulo'] = $regional->submissaoMesa->titulo;
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach ($regional->submissaoMesa->coautorOrientadorSubCentrooeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubCentrooeste) {
                $certificado['titulo'] = $regional->submissaoDt->titulo;
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach ($regional->submissaoDt->coautorOrientadorSubCentrooeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubCentrooeste) {
                $certificado['titulo'] = $regional->submissaoJunior->titulo;
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach ($regional->submissaoJunior->coautorOrientadorSubCentrooeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }

            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
        } elseif ($regiao == 'nordeste') {
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')
            ->with(
                'submissaoMesa',
                'submissaoDt',
                'submissaoJunior',
                'submissaoMesa.divisao_tematica',
                'submissaoDt.divisao_tematica',
                'submissaoJunior.divisao_tematica',
                'submissaoMesa.coautorOrientadorSubNordeste',
                'submissaoDt.coautorOrientadorSubNordeste',
                'submissaoJunior.coautorOrientadorSubNordeste',
            )
            ->findOrFail($id);

            if (isset($regional) && ! empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubNordeste) {
                $certificado['titulo'] = $regional->submissaoMesa->titulo;
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach ($regional->submissaoMesa->coautorOrientadorSubNordeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubNordeste) {
                $certificado['titulo'] = $regional->submissaoDt->titulo;
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach ($regional->submissaoDt->coautorOrientadorSubNordeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubNordeste) {
                $certificado['titulo'] = $regional->submissaoJunior->titulo;
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach ($regional->submissaoJunior->coautorOrientadorSubNordeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }

            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        } elseif ($regiao == 'norte') {
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')
            ->with(
                'submissaoMesa',
                'submissaoDt',
                'submissaoJunior',
                'submissaoMesa.divisao_tematica',
                'submissaoDt.divisao_tematica',
                'submissaoJunior.divisao_tematica',
                'submissaoMesa.coautorOrientadorSubNortes',
                'submissaoDt.coautorOrientadorSubNortes',
                'submissaoJunior.coautorOrientadorSubNortes',
            )
            ->findOrFail($id);

            if (isset($regional) && ! empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubNortes) {
                $certificado['titulo'] = $regional->submissaoMesa->titulo;
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach ($regional->submissaoMesa->coautorOrientadorSubNortes as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubNortes) {
                $certificado['titulo'] = $regional->submissaoDt->titulo;
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach ($regional->submissaoDt->coautorOrientadorSubNortes as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubNortes) {
                $certificado['titulo'] = $regional->submissaoJunior->titulo;
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach ($regional->submissaoJunior->coautorOrientadorSubNortes as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }

            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
        } elseif ($regiao == 'sul') {
            $regional = RegionalSul::select('id', 'user_id', 'presenca')
            ->with(
                'submissaoMesa',
                'submissaoDt',
                'submissaoJunior',
                'submissaoMesa.divisao_tematica',
                'submissaoDt.divisao_tematica',
                'submissaoJunior.divisao_tematica',
                'submissaoMesa.coautorOrientadorSubSuls',
                'submissaoDt.coautorOrientadorSubSuls',
                'submissaoJunior.coautorOrientadorSubSuls',
            )
            ->findOrFail($id);

            if (isset($regional) && ! empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubSuls) {
                $certificado['titulo'] = $regional->submissaoMesa->titulo;
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach ($regional->submissaoMesa->coautorOrientadorSubSuls as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubSuls) {
                $certificado['titulo'] = $regional->submissaoDt->titulo;
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach ($regional->submissaoDt->coautorOrientadorSubSuls as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubSuls) {
                $certificado['titulo'] = $regional->submissaoJunior->titulo;
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach ($regional->submissaoJunior->coautorOrientadorSubSuls as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }

            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
        } elseif ($regiao == 'suldeste') {
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')
            ->with(
                'submissaoMesa',
                'submissaoDt',
                'submissaoJunior',
                'submissaoMesa.divisao_tematica',
                'submissaoDt.divisao_tematica',
                'submissaoJunior.divisao_tematica',
                'submissaoMesa.coautorOrientadorSubSudeste',
                'submissaoDt.coautorOrientadorSubSudeste',
                'submissaoJunior.coautorOrientadorSubSudeste',
            )
            ->findOrFail($id);

            if (isset($regional) && ! empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubSudeste) {
                $certificado['titulo'] = $regional->submissaoMesa->titulo;
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach ($regional->submissaoMesa->coautorOrientadorSubSudeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubSudeste) {
                $certificado['titulo'] = $regional->submissaoDt->titulo;
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach ($regional->submissaoDt->coautorOrientadorSubSudeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            } elseif (isset($regional) && ! empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubSudeste) {
                $certificado['titulo'] = $regional->submissaoJunior->titulo;
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach ($regional->submissaoJunior->coautorOrientadorSubSudeste as $coautor) {
                    if ($coautor->cpf != $user->cpf) {
                        $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                    }
                }
            }

            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        if (
            isset($regional) && ! empty($regional) && $regional->presenca == 1 && $regional->submissaoMesa && $regional->submissaoMesa->apresentacao == 1
            || isset($regional) && ! empty($regional) && $regional->presenca == 1 && $regional->submissaoDt && $regional->submissaoDt->apresentacao == 1
            || isset($regional) && ! empty($regional) && $regional->presenca == 1 && $regional->submissaoJunior && $regional->submissaoJunior->apresentacao == 1
        ) {
            if (Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id) {
                if ($regiao == 'nordeste') {
                    $data = view('pdf.certificados.certificado_apresentacao_nordeste', compact('certificado'));
                }
                if ($regiao == 'suldeste') {
                    $data = view('pdf.certificados.certificado_apresentacao_sudeste', compact('certificado'));
                }
                if ($regiao == 'norte') {
                    $data = view('pdf.certificados.certificado_apresentacao_norte', compact('certificado'));
                }
                if ($regiao == 'sul') {
                    $data = view('pdf.certificados.certificado_apresentacao_sul', compact('certificado'));
                }
                if ($regiao == 'centrooeste') {
                    $data = view('pdf.certificados.certificado_apresentacao_centrooeste', compact('certificado'));
                }

                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('isPhpEnabled', true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_apresentacao_{$user_id}_{$regiao}_{$id} R.pdf", ['Attachment' => false]);
                } else {
                    $result = $dompdf->output();
                }

                return $result;
            }
        }
    }

    public function certificado_apresentacao_coautor($user_id, $submissao_id, $regiao)
    {
        $user = User::select('id', 'cpf', 'name')
            ->with('todos_tipos')->where('id', $user_id)->first();

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();
            $certificado['coautores'][] = trim(ucwords(mb_strtolower($user->name)));
        }

        if (isset($regiao) && $regiao == 'nordeste') {
            foreach ($user->todos_tipos as $tipo) {
                if ($tipo->id == 7) {
                    $submissao = SubmissaoRegionalNordestes::with(
                        'coautorOrientadorSubNordeste',
                        'divisao_tematica',
                    )
                        ->where('id', $submissao_id)
                    ->first();

                    if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                        if (isset($submissao) && $submissao->inscricao) {
                            $certificado['titulo'] = $submissao->titulo;
                            $certificado['categoria'] = $submissao->divisao_tematica->descricao;
                            $certificado['tipo'] = $submissao->tipo;

                            $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                        }

                        if (isset($submissao) && $submissao->coautorOrientadorSubNordeste) {
                            foreach ($submissao->coautorOrientadorSubNordeste as $coautor) {
                                if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                    $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                }
                            }
                        }

                        $regiao = 'nordeste';
                        $certificado['regiao'] = 'Nordeste';
                        $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'norte') {
            foreach ($user->todos_tipos as $tipo) {
                if ($tipo->id == 10) {
                    $submissao = SubmissaoRegionalNorte::with(
                        'coautorOrientadorSubNortes',
                        'divisao_tematica',
                    )
                    ->where('id', $submissao_id)
                    ->first();

                    if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                        if (isset($submissao) && $submissao->inscricao) {
                            $certificado['titulo'] = $submissao->titulo;
                            $certificado['categoria'] = $submissao->divisao_tematica->descricao;
                            $certificado['tipo'] = $submissao->tipo;

                            $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                        }

                        if (isset($submissao) && $submissao->coautorOrientadorSubNortes) {
                            foreach ($submissao->coautorOrientadorSubNortes as $coautor) {
                                if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                    $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                }
                            }
                        }

                        $regiao = 'norte';
                        $certificado['regiao'] = 'Norte';
                        $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'sudeste') {
            foreach ($user->todos_tipos as $tipo) {
                if ($tipo->id == 8) {
                    $submissao = SubmissaoRegionalSudeste::with(
                        'coautorOrientadorSubSudeste',
                        'divisao_tematica',
                    )
                    ->where('id', $submissao_id)
                    ->first();

                    if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                        if (isset($submissao) && $submissao->inscricao) {
                            $certificado['titulo'] = $submissao->titulo;
                            $certificado['categoria'] = $submissao->divisao_tematica->descricao;
                            $certificado['tipo'] = $submissao->tipo;

                            $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                        }

                        if (isset($submissao) && $submissao->coautorOrientadorSubSudeste) {
                            foreach ($submissao->coautorOrientadorSubSudeste as $coautor) {
                                if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                    $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                }
                            }
                        }

                        $regiao = 'sudeste';
                        $certificado['regiao'] = 'Sudeste';
                        $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'sul') {
            foreach ($user->todos_tipos as $tipo) {
                if ($tipo->id == 6) {
                    $submissao = SubmissaoRegionalSul::with(
                        'coautorOrientadorSubSuls',
                        'divisao_tematica',
                    )
                    ->where('id', $submissao_id)
                    ->first();

                    if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                        if (isset($submissao) && $submissao->inscricao) {
                            $certificado['titulo'] = $submissao->titulo;
                            $certificado['categoria'] = $submissao->divisao_tematica->descricao;
                            $certificado['tipo'] = $submissao->tipo;

                            $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                        }

                        if (isset($submissao) && $submissao->coautorOrientadorSubSuls) {
                            foreach ($submissao->coautorOrientadorSubSuls as $coautor) {
                                if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                    $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                }
                            }
                        }

                        $regiao = 'sul';
                        $certificado['regiao'] = 'Sul';
                        $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";
                    }
                }
            }
        }

        if (isset($regiao) && $regiao == 'centrooeste') {
            foreach ($user->todos_tipos as $tipo) {
                if ($tipo->id == 9) {
                    $submissao = SubmissaoRegionalCentrooeste::with(
                        'coautorOrientadorSubCentrooeste',
                        'divisao_tematica',
                    )
                    ->where('id', $coautor->submissao_id)
                    ->first();

                    if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                        if (isset($submissao) && $submissao->inscricao) {
                            $certificado['titulo'] = $submissao->titulo;
                            $certificado['categoria'] = $submissao->divisao_tematica->descricao;
                            $certificado['tipo'] = $submissao->tipo;

                            $certificado['coautores'][] = trim(ucwords(mb_strtolower($submissao->inscricao->user->name)));
                        }

                        if (isset($submissao) && $submissao->coautorOrientadorSubCentrooeste) {
                            foreach ($submissao->coautorOrientadorSubCentrooeste as $coautor) {
                                if ($coautor->cpf != $user->cpf && $coautor->cpf != $submissao->inscricao->user->cpf) {
                                    $certificado['coautores'][] = trim(ucwords(mb_strtolower($coautor->nome_completo)));
                                }
                            }
                        }

                        $regiao = 'centrooeste';
                        $certificado['regiao'] = 'Centro-Oeste';
                        $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
                    }
                }
            }
        }

        if (in_array('', $certificado)) {
            return false;
        }

        $certificado['coautores'] = array_unique($certificado['coautores']);

        if (Auth::user()->id == $user_id) {
            if ($regiao == 'nordeste') {
                $data = view('pdf.certificados.certificado_apresentacao_nordeste', compact('certificado'));
            }
            if ($regiao == 'sudeste') {
                $data = view('pdf.certificados.certificado_apresentacao_sudeste', compact('certificado'));
            }

            if ($regiao == 'norte') {
                $data = view('pdf.certificados.certificado_apresentacao_norte', compact('certificado'));
            }

            if ($regiao == 'sul') {
                $data = view('pdf.certificados.certificado_apresentacao_sul', compact('certificado'));
            }

            if ($regiao == 'centrooeste') {
                $data = view('pdf.certificados.certificado_apresentacao_centrooeste', compact('certificado'));
            }

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_apresentacao_expocom_{$user_id}_{$regiao}_R.pdf", ['Attachment' => false]);
            } else {
                $result = $dompdf->output();
            }

            return $result;
        }
    }

    public function certificado_parecerista_expocom($user_id, $regiao)
    {
        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')->findOrFail($user_id);

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();

            $avaliador = AvaliadorExpocom::select('id', 'user_id', 'avaliador')
            ->where('user_id', Auth::user()->id)
            ->first();
            if (isset($avaliador) && ! empty($avaliador) && $avaliador->avaliador == 1) {
                $avaliacoes = DistribuicaoTipoExpocom::select('id', 'avaliador_1', 'status_avaliador_1', 'avaliador_2', 'status_avaliador_2', 'avaliador_3', 'status_avaliador_3')
                ->with(
                    'submissaoExpocomNordeste.inscricao.user.indicacao',
                    'submissaoExpocomNorte.inscricao.user.indicacao',
                    'submissaoExpocomSul.inscricao.user.indicacao',
                    'submissaoExpocomSudeste.inscricao.user.indicacao',
                    'submissaoExpocomCentroOeste.inscricao.user.indicacao',
                )
                ->where('avaliador_1', $avaliador->user_id)
                ->orWhere('avaliador_2', $avaliador->user_id)
                ->orWhere('avaliador_3', $avaliador->user_id)
                ->get();

                if (isset($avaliacoes) && ! empty($avaliacoes) && $avaliacoes->count() > 0) {
                    foreach ($avaliacoes as $avaliacao) {
                        if (
                            $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == 'Avaliado'
                            || $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == 'Recusado'
                            || $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == 'Avaliado'
                            || $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == 'Recusado'   
                            ||$avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == 'Avaliado'
                            || $avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == 'Recusado'
                            ) {
                            if ($avaliacao->submissaoExpocomNordeste && $regiao == 'nordeste') {
                                $certificado['categoria'][] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'][] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['regiao'] = 'Nordeste';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";

                            } elseif ($avaliacao->submissaoExpocomNorte && $regiao == 'norte') {
                                $certificado['categoria'][] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'][] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['regiao'] = 'Norte';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";

                            } elseif ($avaliacao->submissaoExpocomSul && $regiao == 'sul') {
                                $certificado['categoria'][] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'][] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['regiao'] = 'Sul';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";

                            } elseif ($avaliacao->submissaoExpocomSudeste && $regiao == 'sudeste') {
                                $certificado['categoria'][] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'][] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['regiao'] = 'Sudeste';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";

                            } elseif ($avaliacao->submissaoExpocomCentroOeste && $regiao == 'centrooeste') {
                                $certificado['categoria'][] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->categoria ?? 'Sem categoria';
                                $certificado['modalidade'][] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->modalidade ?? 'Sem modalidade';
                                $certificado['regiao'] = 'Centro-Oeste';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";
                            }
                        }
                    }
                }
            }
        }

        $certificado['categoria'] = array_unique($certificado['categoria']);
        $certificado['modalidade'] = array_unique($certificado['modalidade']);

        if (in_array('', $certificado)) {
            return false;
        }

        if (Auth::user()->id == $user_id) {
            if($regiao == 'centrooeste'){
                $data = view('pdf.certificados.certificado_parecerista_expocom_centrooeste', compact('certificado'));
            }
            if($regiao == 'sul'){
                $data = view('pdf.certificados.certificado_parecerista_expocom_sul', compact('certificado'));
            }
            if($regiao == 'sudeste'){
                $data = view('pdf.certificados.certificado_parecerista_expocom_sudeste', compact('certificado'));
            }
            if($regiao == 'norte'){
                $data = view('pdf.certificados.certificado_parecerista_expocom_norte', compact('certificado'));
            }
            if($regiao == 'nordeste'){
                $data = view('pdf.certificados.certificado_parecerista_expocom_nordeste', compact('certificado'));
            }
    
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_parecerista_expocom_{$user_id}_R.pdf", ['Attachment' => false]);
            } else {
                $result = $dompdf->output();
            }

            return $result;
        }
    }

    public function certificado_parecerista($user_id, $regiao)
    {
        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')->findOrFail($user_id);

        if (! empty($user)) {
            $certificado['user'] = $user->toArray();

            $avaliador = AvaliadorExpocom::select('id', 'user_id', 'avaliador_junior')
            ->where('user_id', Auth::user()->id)
            ->first();
            if (isset($avaliador) && ! empty($avaliador) && $avaliador->avaliador_junior == 1) {
                $avaliacoes = DistribuicaoTipo123::select('id', 'avaliador_1', 'status_avaliador_1', 'avaliador_2', 'status_avaliador_2', 'avaliador_3', 'status_avaliador_3')
                ->with(
                    'submissaoNordeste.divisao_tematica',
                    'submissaoNorte.divisao_tematica',
                    'submissaoSul.divisao_tematica',
                    'submissaoSudeste.divisao_tematica',
                    'submissaoCentroOeste.divisao_tematica',
                )
                ->where('avaliador_1', $avaliador->user_id)
                ->orWhere('avaliador_2', $avaliador->user_id)
                ->orWhere('avaliador_3', $avaliador->user_id)
                ->get();

                if (isset($avaliacoes) && ! empty($avaliacoes) && $avaliacoes->count() > 0) {
                    foreach ($avaliacoes as $avaliacao) {
                        if (
                            $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == 'Aceito'
                            || $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == 'Recusado'
                            || $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == 'Aceito'
                            || $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == 'Recusado'   
                            ||$avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == 'Aceito'
                            || $avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == 'Recusado'
                        ) {
                            if ($avaliacao->submissaoNordeste && $regiao == 'nordeste') {
                                $certificado['categoria'][] = $avaliacao->submissaoNordeste->divisao_tematica->descricao;
                                $certificado['tipo'][] = $avaliacao->submissaoNordeste->tipo;
                                $certificado['regiao'] = 'Nordeste';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";

                            } elseif ($avaliacao->submissaoNorte && $regiao == 'norte') {
                                $certificado['categoria'][] = $avaliacao->submissaoNorte->divisao_tematica->descricao;
                                $certificado['tipo'][] = $avaliacao->submissaoNorte->tipo;
                                $certificado['regiao'] = 'Norte';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-norte.jpg');";

                            } elseif ($avaliacao->submissaoSul && $regiao == 'sul') {
                                $certificado['categoria'][] = $avaliacao->submissaoSul->divisao_tematica->descricao;
                                $certificado['tipo'][] = $avaliacao->submissaoSul->tipo;
                                $certificado['regiao'] = 'Sul';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sul.jpg');";

                            } elseif ($avaliacao->submissaoSudeste && $regiao == 'sudeste') {
                                $certificado['categoria'][] = $avaliacao->submissaoSudeste->divisao_tematica->descricao;
                                $certificado['tipo'][] = $avaliacao->submissaoSudeste->tipo;
                                $certificado['regiao'] = 'Sudeste';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";

                            } elseif ($avaliacao->submissaoCentroOeste && $regiao == 'centrooeste') {
                                $certificado['categoria'][] = $avaliacao->submissaoCentroOeste->divisao_tematica->descricao;
                                $certificado['tipo'][] = $avaliacao->submissaoCentroOeste->tipo;
                                $certificado['regiao'] = 'Centro-Oeste';
                                $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-centrooeste.jpg');";

                            }
                        }
                    }
                }
            }
        }
        
        $certificado['categoria'] = array_unique($certificado['categoria']);
        $certificado['tipo'] = array_unique($certificado['tipo']);

        if (in_array('', $certificado)) {
            return false;
        }

        if (Auth::user()->id == $user_id) {
            if($regiao == 'centrooeste'){
                $data = view('pdf.certificados.certificado_parecerista_centrooeste', compact('certificado'));
            }
            if($regiao == 'sul'){
                $data = view('pdf.certificados.certificado_parecerista_sul', compact('certificado'));
            }
            if($regiao == 'sudeste'){
                $data = view('pdf.certificados.certificado_parecerista_sudeste', compact('certificado'));
            }
            if($regiao == 'norte'){
                $data = view('pdf.certificados.certificado_parecerista_norte', compact('certificado'));
            }
            if($regiao == 'nordeste'){
                $data = view('pdf.certificados.certificado_parecerista_nordeste', compact('certificado'));
            }

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, '', $font, 8, [0, 0, 0]);

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_parecerista_{$user_id}_R.pdf", ['Attachment' => false]);
            } else {
                $result = $dompdf->output();
            }

            return $result;
        }
    }
}
