<?php

namespace App\Http\Controllers;

use App\Models\AvaliadorExpocom;
use App\Models\CoauOriExpoSubCentrooeste;
use App\Models\CoauOriExpoSubNordeste;
use App\Models\CoauOriExpoSubSudeste;
use App\Models\DistribuicaoTipo123;
use App\Models\DistribuicaoTipoExpocom;
use App\Models\RegionalCentrooeste;
use App\Models\RegionalNordeste;
use App\Models\RegionalNorte;
use App\Models\RegionalSul;
use App\Models\RegionalSuldeste;
use App\Models\SubmissaoExpocomRegionalCentrooeste;
use App\Models\SubmissaoExpocomRegionalNordeste;
use App\Models\SubmissaoExpocomRegionalSudeste;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificadosController extends Controller
{
    public function index(){
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

            'nacional'
        )
        ->whereId(Auth::user()->id)
        ->first();

        return view('certificado.index', compact('user'));
    }

    public function certificado_presenca($user_id, $regiao, $id){
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO
        
        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')->findOrFail($user_id);
        if(!empty($user)){
            $certificado['user'] = $user->toArray();
        }
        
        if($regiao == 'centrooeste'){
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Centro-Oeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'nordeste'){
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'norte'){
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'sul'){
            $regional = RegionalSul::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Sul';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'suldeste'){
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')->findOrFail($id);
            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        if(!empty($regional)){
            $certificado['regional'] = $regional->toArray();
        }

        if(isset($regional) && !empty($regional) && $regional->presenca == 1 && $regional->submissaoExpocom->apresentacao == 1){

            if(Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id){
                if($regiao == 'nordeste'){
                    $data = view('pdf.certificado_presenca_nordeste', compact('certificado'));                    
                }
                if($regiao == 'suldeste'){
                    $data = view('pdf.certificado_presenca_sudeste', compact('certificado'));
                }
                $options = new Options();
                $options->set('isRemoteEnabled', TRUE);
                $options->set("isPhpEnabled", true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                // $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));
                if($regiao == 'nordeste'){
                    $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));
                }
                if($regiao == 'suldeste'){
                    $canvas->page_text(450, 818, "", $font, 8, array(0, 0, 0));
                }

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_presenca_{$user_id}_{$regiao}_{$id} R.pdf", array("Attachment" => false));
                } else {
                    $result = $dompdf->output();
                }
                return $result;
            }
        }
    }

    public function certificado_apresentacao_expocom($user_id, $regiao, $id){
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO
        
        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')
        ->with('indicacao')
        ->findOrFail($user_id);

        if(!empty($user)){
            $certificado['user'] = $user->toArray();
            $certificado['categoria'] = $user->indicacao->categoria;
            $certificado['modalidade'] = $user->indicacao->modalidade;
            $certificado['titulo'] = $user->indicacao->titulo_trabalho;            
        }

        if($regiao == 'centrooeste'){
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubCentrooeste')
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubCentrooeste){
                foreach($regional->submissaoExpocom->coautorOrientadorSubCentrooeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Centro-Oeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'nordeste'){
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNordeste')
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNordeste){
                foreach($regional->submissaoExpocom->coautorOrientadorSubNordeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'norte'){
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNorte')            
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNorte){
                foreach($regional->submissaoExpocom->coautorOrientadorSubNorte as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'sul'){
            $regional = RegionalSul::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSuls')            
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSuls){
                foreach($regional->submissaoExpocom->coautorOrientadorSubSuls as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Sul';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'suldeste'){
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSudeste')
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSudeste){
                foreach($regional->submissaoExpocom->coautorOrientadorSubSudeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        if(isset($regional) && !empty($regional) && $regional->presenca == 1 && $regional->submissaoExpocom->apresentacao == 1){
            if(Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id){

                if($regiao == 'nordeste'){
                    $data = view('pdf.certificado_apresentacao_expocom_nordeste', compact('certificado'));
                }
                if($regiao == 'suldeste'){
                    $data = view('pdf.certificado_apresentacao_expocom_sudeste', compact('certificado'));
                }

                $options = new Options();
                $options->set('isRemoteEnabled', TRUE);
                $options->set("isPhpEnabled", true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_apresentacao_expocom_{$user_id}_{$regiao}_{$id} R.pdf", array("Attachment" => false));
                } else {
                    $result = $dompdf->output();
                }
                return $result;
            }
        }
    }

    public function certificado_vencedor_expocom($user_id, $regiao, $id){
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO
        $certificado = [];

        $user = User::select('id', 'name', 'email', 'cpf')
        ->with('indicacao')
        ->findOrFail($user_id);

        if(!empty($user)){
            $certificado['user'] = $user->toArray();
            $certificado['categoria'] = $user->indicacao->categoria;
            $certificado['modalidade'] = $user->indicacao->modalidade;
            $certificado['titulo'] = $user->indicacao->titulo_trabalho;            
        }
        
        if($regiao == 'centrooeste'){
            $regional = RegionalCentrooeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubCentrooeste')
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubCentrooeste){
                foreach($regional->submissaoExpocom->coautorOrientadorSubCentrooeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Centro-Oeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'nordeste'){
            $regional = RegionalNordeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNordeste')
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNordeste){
                foreach($regional->submissaoExpocom->coautorOrientadorSubNordeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'norte'){
            $regional = RegionalNorte::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubNorte')            
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubNorte){
                foreach($regional->submissaoExpocom->coautorOrientadorSubNorte as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Norte';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'sul'){
            $regional = RegionalSul::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSuls')            
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSuls){
                foreach($regional->submissaoExpocom->coautorOrientadorSubSuls as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Sul';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'suldeste'){
            $regional = RegionalSuldeste::select('id', 'user_id', 'presenca')
            ->with('submissaoExpocom', 'submissaoExpocom.coautorOrientadorSubSudeste')
            ->findOrFail($id);

            if($regional && $regional->submissaoExpocom && $regional->submissaoExpocom->coautorOrientadorSubSudeste){
                foreach($regional->submissaoExpocom->coautorOrientadorSubSudeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";
        }

        if(isset($regional) && !empty($regional) && $regional->presenca == 1 && $regional->submissaoExpocom->apresentacao == 1 && $regional->submissaoExpocom->vencedor == 1){

            if(Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id){
                if($regiao == 'nordeste'){
                    $data = view('pdf.certificado_vencedor_expocom_nordeste', compact('certificado'));
                }
                if($regiao == 'suldeste'){
                    $data = view('pdf.certificado_vencedor_expocom_sudeste', compact('certificado'));
                }
                $options = new Options();
                $options->set('isRemoteEnabled', TRUE);
                $options->set("isPhpEnabled", true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_vencedor_expocom_{$user_id}_{$regiao}_{$id} R.pdf", array("Attachment" => false));
                } else {
                    $result = $dompdf->output();
                }
                return $result;
            }
        }

    }

    public function verificar_pago($regiao, $cpf){
        $user = User::select('id', 'cpf')
                    ->with(
                        'todos_tipos',
                        'regional_sul',
                        'regional_norte',
                        'regional_nordeste',
                        'regional_centrooeste',
                        'regional_suldeste',
                        )
                    ->where('cpf', $cpf)
        ->first();
        //centrooeste
        if($regiao == 4){
            if(isset($user) && !empty($user) && !empty($user->regional_centrooeste)){
                if($user->regional_centrooeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 9) {
                            return true;
                        }
                    }
                    return false;    
                }
                return false;
            }
        }

        if($regiao == 2){
            if(isset($user) && !empty($user) && !empty($user->regional_nordeste)){
                if($user->regional_nordeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 7) {
                            return true;
                        }
                    }
                    return false;
                }
                return false;
            }
        }

        if($regiao == 5){
            if(isset($user) && !empty($user) && !empty($user->regional_norte)){
                if($user->regional_norte->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 10) {
                            return true;
                        }
                    }
                    return false;
                }
                return false;
            }
        }

        if($regiao == 3){
            if(isset($user) && !empty($user) && !empty($user->regional_suldeste)){
                if($user->regional_suldeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 8) {
                            return true;
                        }
                    }
                    return false;
                }
                return false;
            }
        }

        if($regiao == 1){
            if(isset($user) && !empty($user) && !empty($user->regional_sul)){
                if($user->regional_sul->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 6) {
                            return true;
                        }
                    }
                    return false;
                }
                return false;
            }
        }
    }

    public function certificado_apresentacao_expocom_coautor($user_id, $regiao){
        $user = User::select('id', 'cpf', 'name')
            ->with(
                'todos_tipos',
                'regional_sul',
                'regional_sul.submissaoExpocom',
                'regional_sul.submissaoExpocom.coautorOrientadorSubSuls',

                'regional_norte',
                'regional_norte.submissaoExpocom',
                'regional_norte.submissaoExpocom.coautorOrientadorSubNortes',

                'regional_nordeste',
                'regional_nordeste.submissaoExpocom',
                'regional_nordeste.submissaoExpocom.coautorOrientadorSubNordeste',

                'regional_centrooeste',
                'regional_centrooeste.submissaoExpocom',
                'regional_centrooeste.submissaoExpocom.coautorOrientadorSubCentrooeste',

                'regional_suldeste',
                'regional_suldeste.submissaoExpocom',
                'regional_suldeste.submissaoExpocom.coautorOrientadorSubSudeste',

                )
            ->where('id', $user_id)
        ->first();

        if(!empty($user)){
            $certificado['user'] = $user->toArray();
        }

        if(isset($regiao) && $regiao == "nordeste"){
            if(isset($user) && !empty($user) && !empty($user->regional_nordeste)){
                if($user->regional_nordeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 7) { 
                            $coautores = CoauOriExpoSubNordeste::where('cpf', $user->cpf)->get();
                            foreach ($coautores as $coautor) {
                                if($coautor->cpf == $user->cpf){
                                    $submissao = SubmissaoExpocomRegionalNordeste::with(
                                        'coautorOrientadorSubNordeste',
                                        'inscricao',
                                        'inscricao.user',
                                        'inscricao.user.indicacao',
                                        )
                                        ->where('id', $coautor->submissao_id)
                                    ->first();

                                    if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                                        if(isset($submissao) &&  $submissao->inscricao){
                                            $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria;
                                            $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade;
                                            $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;  
                                            $certificado['coautores'][] = $submissao->inscricao->user->name;    
                                        }

                                        if(isset($submissao) && $submissao->coautorOrientadorSubNordeste){
                                            foreach($submissao->coautorOrientadorSubNordeste as $coautor){
                                                if($coautor->cpf != $user->cpf){
                                                    $certificado['coautores'][] = $coautor->nome_completo;
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
                }
            }
        }

        if(isset($regiao) && $regiao == "suldeste"){
            if(isset($user) && !empty($user) && !empty($user->regional_suldeste)){
                if($user->regional_suldeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 8) { 
                            $coautores = CoauOriExpoSubSudeste::where('cpf', $user->cpf)->get();
                            foreach ($coautores as $coautor) {
                                if($coautor->cpf == $user->cpf){
                                    $submissao = SubmissaoExpocomRegionalSudeste::with(
                                        'coautorOrientadorSubSudeste',
                                        'inscricao',
                                        'inscricao.user',
                                        'inscricao.user.indicacao',
                                        )
                                        ->where('id', $coautor->submissao_id)
                                    ->first();

                                    if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                                        if(isset($submissao) &&  $submissao->inscricao){
                                            $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria;
                                            $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade;
                                            $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;  
                                            $certificado['coautores'][] = $submissao->inscricao->user->name;    
                                        }

                                        if(isset($submissao) && $submissao->coautorOrientadorSubSudeste){
                                            foreach($submissao->coautorOrientadorSubSudeste as $coautor){
                                                if($coautor->cpf != $user->cpf){
                                                    $certificado['coautores'][] = $coautor->nome_completo;
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
                }
            }
        }


        if(in_array("", $certificado)){
            return false;
        }

        if(Auth::user()->id == $user_id){
            if($regiao == 'nordeste'){
                $data = view('pdf.certificado_apresentacao_expocom_nordeste', compact('certificado'));
            }
            if($regiao == 'suldeste'){
                $data = view('pdf.certificado_apresentacao_expocom_sudeste', compact('certificado'));
            }

            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $options->set("isPhpEnabled", true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_apresentacao_expocom_{$user_id}_{$regiao}_R.pdf", array("Attachment" => false));
            } else {
                $result = $dompdf->output();
            }
            return $result;
        }
    }

    public function certificado_vencedor_expocom_coautor($user_id, $regiao){
        $user = User::select('id', 'cpf', 'name')
            ->with(
                'todos_tipos',
                'regional_sul',
                'regional_sul.submissaoExpocom',
                'regional_sul.submissaoExpocom.coautorOrientadorSubSuls',

                'regional_norte',
                'regional_norte.submissaoExpocom',
                'regional_norte.submissaoExpocom.coautorOrientadorSubNortes',

                'regional_nordeste',
                'regional_nordeste.submissaoExpocom',
                'regional_nordeste.submissaoExpocom.coautorOrientadorSubNordeste',

                'regional_centrooeste',
                'regional_centrooeste.submissaoExpocom',
                'regional_centrooeste.submissaoExpocom.coautorOrientadorSubCentrooeste',

                'regional_suldeste',
                'regional_suldeste.submissaoExpocom',
                'regional_suldeste.submissaoExpocom.coautorOrientadorSubSudeste',

                )
            ->where('id', $user_id)
        ->first();

        if(!empty($user)){
            $certificado['user'] = $user->toArray();
        }

        if(isset($regiao) && $regiao == "nordeste"){
            if(isset($user) && !empty($user) && !empty($user->regional_nordeste)){
                if($user->regional_nordeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 7) { 
                            $coautores = CoauOriExpoSubNordeste::where('cpf', $user->cpf)->get();
                            foreach ($coautores as $coautor) {
                                if($coautor->cpf == $user->cpf){
                                    $submissao = SubmissaoExpocomRegionalNordeste::with(
                                        'coautorOrientadorSubNordeste',
                                        'inscricao',
                                        'inscricao.user',
                                        'inscricao.user.indicacao',
                                        )
                                        ->where('id', $coautor->submissao_id)
                                    ->first();

                                    if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1){
                                        if(isset($submissao) &&  $submissao->inscricao){
                                            $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria;
                                            $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade;
                                            $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;  
                                            $certificado['coautores'][] = $submissao->inscricao->user->name;    
                                        }


                                        if(isset($submissao) && $submissao->coautorOrientadorSubNordeste){
                                            foreach($submissao->coautorOrientadorSubNordeste as $coautor){
                                                if($coautor->cpf != $user->cpf){
                                                    $certificado['coautores'][] = $coautor->nome_completo;
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
                }
            }
        }

        if(isset($regiao) && $regiao == "suldeste"){
            if(isset($user) && !empty($user) && !empty($user->regional_suldeste)){
                if($user->regional_suldeste->presenca == 1){
                    foreach ($user->todos_tipos as $tipo) {
                        if ($tipo->id == 8) { 
                            $coautores = CoauOriExpoSubSudeste::where('cpf', $user->cpf)->get();
                            foreach ($coautores as $coautor) {
                                if($coautor->cpf == $user->cpf){
                                    $submissao = SubmissaoExpocomRegionalSudeste::with(
                                        'coautorOrientadorSubSudeste',
                                        'inscricao',
                                        'inscricao.user',
                                        'inscricao.user.indicacao',
                                        )
                                        ->where('id', $coautor->submissao_id)
                                    ->first();

                                    if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1){
                                        if(isset($submissao) &&  $submissao->inscricao){
                                            $certificado['categoria'] = $submissao->inscricao->user->indicacao->categoria;
                                            $certificado['modalidade'] = $submissao->inscricao->user->indicacao->modalidade;
                                            $certificado['titulo'] = $submissao->inscricao->user->indicacao->titulo_trabalho;  
                                            $certificado['coautores'][] = $submissao->inscricao->user->name;    
                                        }


                                        if(isset($submissao) && $submissao->coautorOrientadorSubSudeste){
                                            foreach($submissao->coautorOrientadorSubSudeste as $coautor){
                                                if($coautor->cpf != $user->cpf){
                                                    $certificado['coautores'][] = $coautor->nome_completo;
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
                }
            }
        }


        if(in_array("", $certificado)){
            return false;
        }

        if(Auth::user()->id == $user_id){
            if($regiao == 'nordeste'){
                $data = view('pdf.certificado_vencedor_expocom_nordeste', compact('certificado'));
            }
            if($regiao == 'suldeste'){
                $data = view('pdf.certificado_vencedor_expocom_sudeste', compact('certificado'));
            }
            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $options->set("isPhpEnabled", true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_vencedor_expocom_{$user_id}_{$regiao}_R.pdf", array("Attachment" => false));
            } else {
                $result = $dompdf->output();
            }
            return $result;
        }

    }

    public function certificado_apresentacao($user_id, $regiao, $id){
        //RECEBE ID DO USER, REGIAO POR STRING E ID DA INSCRICAO

        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')
        ->findOrFail($user_id);

        if(!empty($user)){
            $certificado['user'] = $user->toArray();
        }

        if($regiao == 'centrooeste'){
        }
        elseif($regiao == 'nordeste'){
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

            if(isset($regional) && !empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubNordeste){
                $certificado['titulo'] = $regional->submissaoMesa->titulo;                        
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach($regional->submissaoMesa->coautorOrientadorSubNordeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            elseif(isset($regional) && !empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubNordeste){
                $certificado['titulo'] = $regional->submissaoDt->titulo;                        
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach($regional->submissaoDt->coautorOrientadorSubNordeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            elseif(isset($regional) && !empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubNordeste){
                $certificado['titulo'] = $regional->submissaoJunior->titulo;                        
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach($regional->submissaoJunior->coautorOrientadorSubNordeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }

            $certificado['regiao'] = 'Nordeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";
        }
        elseif($regiao == 'norte'){
        }
        elseif($regiao == 'sul'){
        }
        elseif($regiao == 'suldeste'){
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

            if(isset($regional) && !empty($regional) && $regional->submissaoMesa && $regional->submissaoMesa->coautorOrientadorSubSudeste){
                $certificado['titulo'] = $regional->submissaoMesa->titulo;                        
                $certificado['categoria'] = $regional->submissaoMesa->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoMesa->tipo;

                foreach($regional->submissaoMesa->coautorOrientadorSubSudeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            elseif(isset($regional) && !empty($regional) && $regional->submissaoDt && $regional->submissaoDt->coautorOrientadorSubSudeste){
                $certificado['titulo'] = $regional->submissaoDt->titulo;                        
                $certificado['categoria'] = $regional->submissaoDt->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoDt->tipo;

                foreach($regional->submissaoDt->coautorOrientadorSubSudeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }
            elseif(isset($regional) && !empty($regional) && $regional->submissaoJunior && $regional->submissaoJunior->coautorOrientadorSubSudeste){
                $certificado['titulo'] = $regional->submissaoJunior->titulo;                        
                $certificado['categoria'] = $regional->submissaoJunior->divisao_tematica->descricao;
                $certificado['tipo'] = $regional->submissaoJunior->tipo;

                foreach($regional->submissaoJunior->coautorOrientadorSubSudeste as $coautor){
                    $certificado['coautores'][] = $coautor->nome_completo;
                }
            }

            $certificado['regiao'] = 'Sudeste';
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-sudeste.jpg');";

        }

        if(
            isset($regional) && !empty($regional) && $regional->presenca == 1 && $regional->submissaoMesa && $regional->submissaoMesa->apresentacao == 1 
            || isset($regional) && !empty($regional) && $regional->presenca == 1 && $regional->submissaoDt && $regional->submissaoDt->apresentacao == 1 
            || isset($regional) && !empty($regional) && $regional->presenca == 1 && $regional->submissaoJunior && $regional->submissaoJunior->apresentacao == 1
        ){
            if(Auth::user()->id == $user->id && Auth::user()->id == $regional->user->id){
                if($regiao == 'nordeste'){
                    $data = view('pdf.certificado_apresentacao_nordeste', compact('certificado'));
                }
                if($regiao == 'suldeste'){
                    $data = view('pdf.certificado_apresentacao_sudeste', compact('certificado'));
                }
                $options = new Options();
                $options->set('isRemoteEnabled', TRUE);
                $options->set("isPhpEnabled", true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($data);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $fontMetrics = $dompdf->getFontMetrics();
                $canvas = $dompdf->get_canvas();
                $font = $fontMetrics->getFont('Courier');
                $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

                if (empty($output) || $output == null) {
                    $result = $dompdf->stream("certificado_apresentacao_{$user_id}_{$regiao}_{$id} R.pdf", array("Attachment" => false));
                } else {
                    $result = $dompdf->output();
                }
                return $result;
            }
        }        
    }

    public function certificado_parecerista_expocom($user_id){
        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')->findOrFail($user_id);

        if(!empty($user)){            
            $certificado['user'] = $user->toArray();
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";

            $avaliador = AvaliadorExpocom::select('id', 'user_id', 'avaliador')
            ->where('user_id', Auth::user()->id)
            ->first();
            if(isset($avaliador) && !empty($avaliador) && $avaliador->avaliador == 1){
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

                if(isset($avaliacoes) && !empty($avaliacoes) && $avaliacoes->count() > 0){
                    foreach ($avaliacoes as $avaliacao) {
                        if(
                            $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == "Avaliado" 
                            || $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == "Recusado"){
                            if($avaliacao->submissaoExpocomNordeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Nordeste';

                            }
                            elseif($avaliacao->submissaoExpocomNorte){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Norte';
                            }
                            elseif($avaliacao->submissaoExpocomSul){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Sul';
                            }
                            elseif($avaliacao->submissaoExpocomSudeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Sudeste';
                            }
                            elseif($avaliacao->submissaoExpocomCentroOeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Centro-Oeste';
                            }
                        }
                        if(
                            $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == "Avaliado" 
                            || $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == "Recusado"){
                            if($avaliacao->submissaoExpocomNordeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Nordeste';
                            }
                            elseif($avaliacao->submissaoExpocomNorte){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Norte';
                            }
                            elseif($avaliacao->submissaoExpocomSul){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Sul';
                            }
                            elseif($avaliacao->submissaoExpocomSudeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Sudeste';
                            }
                            elseif($avaliacao->submissaoExpocomCentroOeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Centro-Oeste';
                            }
                        }
                        if(
                            $avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == "Avaliado" 
                            || $avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == "Recusado"){
                            if($avaliacao->submissaoExpocomNordeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomNordeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Nordeste';
                            }
                            elseif($avaliacao->submissaoExpocomNorte){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomNorte->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Norte';
                            }
                            elseif($avaliacao->submissaoExpocomSul){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomSul->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Sul';
                            }
                            elseif($avaliacao->submissaoExpocomSudeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomSudeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Sudeste';
                            }
                            elseif($avaliacao->submissaoExpocomCentroOeste){
                                $certificado['categoria'] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->categoria;
                                $certificado['modalidade'] = $avaliacao->submissaoExpocomCentroOeste->inscricao->user->indicacao->modalidade;
                                $certificado['regiao'] = 'Centro-Oeste';
                            }
                        }
                    }
                }                 
            }
        }

        if(in_array("", $certificado)){
            return false;
        }

        if(Auth::user()->id == $user_id){
            $data = view('pdf.certificado_parecerista_expocom', compact('certificado'));
            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $options->set("isPhpEnabled", true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_parecerista_expocom_{$user_id}_R.pdf", array("Attachment" => false));
            } else {
                $result = $dompdf->output();
            }
            return $result;
        }
    }

    public function certificado_parecerista($user_id){
        $certificado = [];
        $user = User::select('id', 'name', 'email', 'cpf')->findOrFail($user_id);

        if(!empty($user)){            
            $certificado['user'] = $user->toArray();
            $certificado['image'] = "background-image: url('https://www.sistemas.intercom.org.br/images/certificados/certificado-congressista-nordeste.jpg');";

            $avaliador = AvaliadorExpocom::select('id', 'user_id', 'avaliador_junior')
            ->where('user_id', Auth::user()->id)
            ->first();
            if(isset($avaliador) && !empty($avaliador) && $avaliador->avaliador_junior == 1){
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

                if(isset($avaliacoes) && !empty($avaliacoes) && $avaliacoes->count() > 0){
                    foreach ($avaliacoes as $avaliacao) {
                        if(
                            $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == "Aceito" 
                            || $avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == "Recusado"
                        ){
                            if($avaliacao->submissaoNordeste){
                                $certificado['divisao'] = $avaliacao->submissaoNordeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoNordeste->tipo;
                                $certificado['regiao'] = 'Nordeste';

                            }
                            elseif($avaliacao->submissaoNorte){
                                $certificado['categoria'] = $avaliacao->submissaoNorte->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoNorte->tipo;
                                $certificado['regiao'] = 'Norte';

                            }
                            elseif($avaliacao->submissaoSul){
                                $certificado['categoria'] = $avaliacao->submissaoSul->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoSul->tipo;
                                $certificado['regiao'] = 'Sul';
                            }
                            elseif($avaliacao->submissaoSudeste){
                                $certificado['categoria'] = $avaliacao->submissaoSudeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoSudeste->tipo;
                                $certificado['regiao'] = 'Sudeste';
                            }
                            elseif($avaliacao->submissaoCentroOeste){
                                $certificado['categoria'] = $avaliacao->submissaoCentroOeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoCentroOeste->tipo;
                                $certificado['regiao'] = 'Centro-Oeste';
                            }
                        }
                        if(
                            $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == "Aceito" 
                            || $avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == "Recusado"
                        ){
                            if($avaliacao->submissaoNordeste){
                                $certificado['categoria'] = $avaliacao->submissaoNordeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoNordeste->tipo;
                                $certificado['regiao'] = 'Nordeste';
                            }
                            elseif($avaliacao->submissaoNorte){
                                $certificado['categoria'] = $avaliacao->submissaoNorte->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoNorte->tipo;
                                $certificado['regiao'] = 'Norte';
                            }
                            elseif($avaliacao->submissaoSul){
                                $certificado['categoria'] = $avaliacao->submissaoSul->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoSul->tipo;
                                $certificado['regiao'] = 'Sul';
                            }
                            elseif($avaliacao->submissaoSudeste){
                                $certificado['categoria'] = $avaliacao->submissaoSudeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoSudeste->tipo;
                                $certificado['regiao'] = 'Sudeste';
                            }
                            elseif($avaliacao->submissaoCentroOeste){
                                $certificado['categoria'] = $avaliacao->submissaoCentroOeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoCentroOeste->tipo;
                                $certificado['regiao'] = 'Centro-Oeste';
                            }
                        }
                        if(
                            $avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == "Aceito" 
                            || $avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == "Recusado"
                        ){
                            if($avaliacao->submissaoNordeste){
                                $certificado['categoria'] = $avaliacao->submissaoNordeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoNordeste->tipo;
                                $certificado['regiao'] = 'Nordeste';
                            }
                            elseif($avaliacao->submissaoNorte){
                                $certificado['categoria'] = $avaliacao->submissaoNorte->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoNorte->tipo;
                                $certificado['regiao'] = 'Norte';
                            }
                            elseif($avaliacao->submissaoSul){
                                $certificado['categoria'] = $avaliacao->submissaoSul->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoSul->tipo;
                                $certificado['regiao'] = 'Sul';
                            }
                            elseif($avaliacao->submissaoSudeste){
                                $certificado['categoria'] = $avaliacao->submissaoSudeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoSudeste->tipo;
                                $certificado['regiao'] = 'Sudeste';
                            }
                            elseif($avaliacao->submissaoCentroOeste){
                                $certificado['categoria'] = $avaliacao->submissaoCentroOeste->divisao_tematica->descricao;
                                $certificado['tipo'] = $avaliacao->submissaoCentroOeste->tipo;
                                $certificado['regiao'] = 'Centro-Oeste';
                            }
                        }
                    }
                }                 
            }
        }

        if(in_array("", $certificado)){
            return false;
        }

        if(Auth::user()->id == $user_id){
            $data = view('pdf.certificado_parecerista', compact('certificado'));
            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $options->set("isPhpEnabled", true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($data);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $fontMetrics = $dompdf->getFontMetrics();
            $canvas = $dompdf->get_canvas();
            $font = $fontMetrics->getFont('Courier');
            $canvas->page_text(538, 818, "", $font, 8, array(0, 0, 0));

            if (empty($output) || $output == null) {
                $result = $dompdf->stream("certificado_parecerista_{$user_id}_R.pdf", array("Attachment" => false));
            } else {
                $result = $dompdf->output();
            }
            return $result;
        }

    }
}
