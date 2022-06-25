<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AvaliacaoAvaliadorController;
use App\Http\Controllers\AvaliacaoAvaliadorExpocomController;
use App\Http\Controllers\AvaliacaoNacionalController;
use App\Http\Controllers\AvaliadorExpocomController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CertificadosController;
use App\Http\Controllers\ChatAvaliacaoController;
use App\Http\Controllers\CoordenadorController;
use App\Http\Controllers\CoordenadorNacionalController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistribuicaoTipo123Controller;
use App\Http\Controllers\DistribuicaoTipoExpocomController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndicacaoAdminController;
use App\Http\Controllers\IndicacaoController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\ListaTrabalhosController;
use App\Http\Controllers\ListaTrabalhosExpocomController;
use App\Http\Controllers\NacionalController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\PagamentosAdminController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegionalCentrooesteController;
use App\Http\Controllers\RegionalNordesteController;
use App\Http\Controllers\RegionalNorteController;
use App\Http\Controllers\RegionalSulController;
use App\Http\Controllers\RegionalSuldesteController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\SubmissaoController;
use App\Http\Controllers\SubmissaoExpocomController;
use App\Http\Controllers\SubmissaoExpocomRegionalCentrooesteController;
use App\Http\Controllers\SubmissaoExpocomRegionalNordesteController;
use App\Http\Controllers\SubmissaoExpocomRegionalNorteController;
use App\Http\Controllers\SubmissaoExpocomRegionalSudesteController;
use App\Http\Controllers\SubmissaoExpocomRegionalSulController;
use App\Http\Controllers\SubmissaoNacionalController;
use App\Http\Controllers\SubmissaoRegionalCentrooesteController;
use App\Http\Controllers\SubmissaoRegionalNordestesController;
use App\Http\Controllers\SubmissaoRegionalNorteController;
use App\Http\Controllers\SubmissaoRegionalSudesteController;
use App\Http\Controllers\SubmissaoRegionalSulController;
use App\Http\Controllers\TitulacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidarApresentacaoController;
use App\Http\Controllers\ValidarApresentacaoExpocomController;
use App\Http\Controllers\ValidarPresencaController;
use App\Models\AvaliacaoNacional;
use App\Models\CoordenadorNacional;
use App\Models\SubmissaoNacional;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::match(['get', 'post'], 'register', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'auth'] , function() {

    // Route::get('/', [PerfilController::class , 'perfil']);
    Route::get('perfil', [PerfilController::class , 'perfil'])->name('perfil');
    Route::post('perfil/save', [PerfilController::class , 'store'])->name('perfil.save');
    Route::put('perfil/senhaupdate', [PerfilController::class , 'senhaUpdate'])->name('perfil.senhaupdate');
    Route::post('perfil/passcheck', [PerfilController::class , 'passCheck'])->name('perfil.passcheck');
    Route::post('perfil/emailcheck', [PerfilController::class , 'emailCheck'])->name('perfil.emailcheck');

    Route::get('filiese', [PerfilController::class , 'filiese'])->name('filiese');
    Route::get('anuidade', [PerfilController::class , 'anuidade'])->name('anuidade');

    Route::prefix('admin')->group(function () {

        Route::middleware(['roles:admin/usuarios'])->group(function () {
            Route::resource('usuarios', UserController::class)->except(['show', 'create', 'edit']);
            Route::get('usuarios/get', [UserController::class ,'get'])->name('usuarios.get');
        });  
        
        Route::middleware(['roles:admin/coordenador'])->group(function () {
            Route::resource('coordenador', CoordenadorController::class)->except(['show', 'create', 'edit']);
            Route::get('coordenador/get', [CoordenadorController::class ,'get'])->name('coordenador.get');
        });
        
        Route::middleware(['roles:admin/coordenador/nacional'])->group(function () {
            Route::resource('coordenador_nacional', CoordenadorNacionalController::class)->except(['show', 'create', 'edit']);
            Route::get('coordenador_nacional/get', [CoordenadorNacionalController::class ,'get'])->name('coordenador_nacional.get');
        });    


        Route::middleware(['roles:admin/titulacao'])->group(function () {
            Route::resource('titulacao', TitulacaoController::class)->except(['show', 'create', 'edit']);
            Route::get('titulacao/get', [TitulacaoController::class ,'get'])->name('titulacao.get');
        });    

        Route::middleware(['roles:admin/sexo'])->group(function () {
            Route::resource('sexo', SexoController::class)->except(['show', 'create', 'edit']);
            Route::get('sexo/get', [SexoController::class ,'get'])->name('sexo.get');
        });        

        Route::middleware(['roles:admin/associado'])->group(function () {
            Route::resource('associado', AssociadoController::class)->except(['show', 'create', 'edit']);
            Route::get('associado/get', [AssociadoController::class ,'get'])->name('associado.get');
            Route::post('associado/check', [AssociadoController::class ,'check'])->name('associado.check');
        });        

        Route::middleware(['roles:admin/instituicao'])->group(function () {
            Route::resource('instituicao', InstituicaoController::class)->except(['show', 'create', 'edit']);
            Route::get('instituicao/get', [InstituicaoController::class ,'get'])->name('instituicao.get');
        });        

        Route::middleware(['roles:admin/titulacao'])->group(function () {
            Route::resource('titulacao', TitulacaoController::class)->except(['show', 'create', 'edit']);
            Route::get('titulacao/get', [TitulacaoController::class ,'get'])->name('titulacao.get');
        });    

        Route::middleware(['roles:admin/pagamento'])->group(function () {
            Route::resource('pagamentos', PagamentosAdminController::class)->except(['show', 'create', 'edit']);
            Route::get('pagamentos/get', [PagamentosAdminController::class ,'get'])->name('pagamentos.get');
            Route::get('pagamentos/pago/{id}', [PagamentosAdminController::class ,'pago'])->name('pagamentos.pago');
        });    

        Route::middleware(['roles:admin/indicacao'])->group(function () {
            Route::resource('indicacao', IndicacaoAdminController::class)->except(['index', 'show', 'create', 'edit']);
            Route::get('indicacao/index', [IndicacaoAdminController::class ,'index'])->name('admin.indicacao.index');
            Route::get('indicacao/get', [IndicacaoAdminController::class ,'get'])->name('admin.indicacao.get');
            Route::get('indicacao/delete/{id}', [IndicacaoAdminController::class ,'delete'])->name('admin.indicacao.get');
        });    

        Route::middleware(['roles:admin/validar-presenca'])->group(function () {
            Route::resource('validar-presenca', ValidarPresencaController::class)->except(['index', 'show', 'create', 'edit']);
            Route::get('validar-presenca/index', [ValidarPresencaController::class ,'index'])->name('admin.validar-presenca.index');
            Route::get('validar-presenca/get', [ValidarPresencaController::class ,'get'])->name('admin.validar-presenca.get');
            Route::get('validar-presenca/delete/{id}', [ValidarPresencaController::class ,'delete'])->name('admin.validar-presenca.delete');
            Route::post('validar-presenca/confirmar', [ValidarPresencaController::class ,'confirmar'])->name('admin.validar-presenca.confirmar');
        });  
        
        Route::middleware(['roles:admin/lista-trabalho-expocom'])->group(function () {
            Route::resource('lista-trabalho-expocom', ListaTrabalhosExpocomController::class)->except(['index', 'show', 'create', 'edit']);
            Route::get('lista-trabalho-expocom/index', [ListaTrabalhosExpocomController::class ,'index'])->name('admin.lista-trabalho-expocom.index');
            Route::get('lista-trabalho-expocom/get', [ListaTrabalhosExpocomController::class ,'get'])->name('lista-trabalho-expocom.get');
        });    
    });

    Route::prefix('financeiro')->group(function () {
        Route::middleware(['roles:financeiro/relatorios'])->group(function () {
            Route::get('relatorios/index', [RelatoriosController::class ,'index'])->name('financeiro.relatorios.index');
            Route::get('relatorios/get', [RelatoriosController::class ,'get'])->name('financeiro.relatorios.get');
            Route::post('relatorios/excel', [RelatoriosController::class ,'excel'])->name('financeiro.relatorios.excel');
        });    
    });

    //PAGSEGURO
    Route::get('pagseguro/pagamento', [PagSeguroController::class, 'pagamento'])->name('pagseguro.pagamento');
    Route::post('pagseguro/associado/credito', [PagSeguroController::class , 'associadocredito'])->name('pagseguro.associado.credito');
    Route::post('pagseguro/associado/credito/anuidade', [PagSeguroController::class , 'associadocreditoanuidade'])->name('pagseguro.associado.credito.anuidade');
    Route::post('pagseguro/associado/boleto', [PagSeguroController::class , 'associadoboleto'])->name('pagseguro.associado.boleto');
    Route::post('pagseguro/associado/boleto/anuidade', [PagSeguroController::class , 'associadoboletoanuidade'])->name('pagseguro.associado.boleto.anuidade');

    //PAGSEGURO REGIONAIS
    Route::post('pagseguro/regionais/credito', [PagSeguroController::class , 'regionaiscredito'])->name('pagseguro.regionais.credito');
    Route::post('pagseguro/regionais/boleto', [PagSeguroController::class , 'regionaisboleto'])->name('pagseguro.regionais.boleto');

    //PAGSEGURO NACIONAL
    Route::post('pagseguro/nacional/credito', [PagSeguroController::class , 'nacionalcredito'])->name('pagseguro.nacional.credito');
    Route::post('pagseguro/nacional/boleto', [PagSeguroController::class , 'nacionalboleto'])->name('pagseguro.nacional.boleto');

    //Associado
    Route::get('associado/area', [AssociadoController::class ,'area'])->name('associado.area');
    Route::get('associado', [AssociadoController::class ,'area'])->name('associado');

    //AREA DE PAGAMENTO
    Route::resource('pagamento', PagamentoController::class)->except(['show', 'create', 'edit']);
    Route::get('pagamento/get', [PagamentoController::class ,'get'])->name('pagamento.get');
    Route::post('pagamento/recibo_pagamento', [PagamentoController::class ,'recibo_pagamento'])->name('pagamento.recibo_pagamento');

    //AREA DE CERTIFICADOS
    Route::resource('certificados', CertificadosController::class)->except(['show', 'create', 'edit']);
    Route::get('certificados/certificado_presenca/pdf/{user}/{regiao}/{id}', [CertificadosController::class ,'certificado_presenca'])->name('certificados.presenca');
    Route::get('certificados/certificado_apresentacao_expocom/pdf/{user}/{regiao}/{id}', [CertificadosController::class ,'certificado_apresentacao_expocom'])->name('certificados.apresentacao.expocom');
    Route::get('certificados/certificado_vencedor_expocom/pdf/{user}/{regiao}/{id}', [CertificadosController::class ,'certificado_vencedor_expocom'])->name('certificados.vencedor.expocom');
    Route::get('certificados/certificado_apresentacao_expocom_coautor/pdf/{user_id}/{regiao}', [CertificadosController::class ,'certificado_apresentacao_expocom_coautor'])->name('certificados.certificado_apresentacao_expocom_coautor');
    Route::get('certificados/certificado_vencedor_expocom_coautor/pdf/{user_id}/{regiao}', [CertificadosController::class ,'certificado_vencedor_expocom_coautor'])->name('certificados.certificado_vencedor_expocom_coautor');
    Route::get('certificados/certificado_apresentacao/pdf/{user}/{regiao}/{id}', [CertificadosController::class ,'certificado_apresentacao'])->name('certificados.apresentacao');
    Route::get('certificados/certificado_apresentacao_coautor/pdf/{user}/{regiao}', [CertificadosController::class ,'certificado_apresentacao_coautor'])->name('certificados.apresentacao.coautor');

    Route::get('certificados/certificado_parecerista_expocom/pdf/{user_id}', [CertificadosController::class ,'certificado_parecerista_expocom'])->name('certificados.parecerista.expocom');
    Route::get('certificados/certificado_parecerista/pdf/{user_id}', [CertificadosController::class ,'certificado_parecerista'])->name('certificados.parecerista');

    //FORM AVALIADOR EXPOCOM
    Route::get('/avaliadorjr', [AvaliadorExpocomController::class, 'formavaliadorjr'])->name('avaliadorjr');
    Route::get('/avaliadorexpocom', [AvaliadorExpocomController::class, 'formavaliadorexpocom'])->name('avaliadorexpocom');
    Route::post('avaliador/save', [AvaliadorExpocomController::class , 'store'])->name('avaliador.save');
    Route::post('/avaliador/nacional/save', [AvaliadorExpocomController::class, 'store_avaliador_nacional'])->name('avaliador.nacional.save');
    Route::get('/avaliador_nacional_jr', [AvaliadorExpocomController::class, 'form_avaliador_nacional_jr'])->name('avaliador.nacional.jr');
    Route::get('/avaliador_nacional_gp', [AvaliadorExpocomController::class, 'form_avaliador_nacional_gp'])->name('avaliador.nacional.gp');
    // Route::get('/avaliador_nacional_publicom', [AvaliadorExpocomController::class, 'form_avaliador_nacional_publicom'])->name('avaliador.nacional.publicom');

    //NACIONAL 
    Route::get('nacional', [NacionalController::class ,'index'])->name('nacional');
    Route::post('nacional/save', [NacionalController::class , 'store'])->name('nacional.save');

    //SUBMISSAO NACIONAL
    Route::get('submissao/nacional/gp', [SubmissaoNacionalController::class ,'submissaoGp'])->name('submissao.nacional.gp');
    Route::get('submissao/nacional/junior', [SubmissaoNacionalController::class ,'submissaoJunior'])->name('submissao.nacional.junior');
    Route::get('submissao/nacional/publicom', [SubmissaoNacionalController::class ,'submissaoPublicom'])->name('submissao.nacional.publicom');
    Route::post('submissao/nacional/save', [SubmissaoNacionalController::class , 'store'])->name('submissao.nacional.save');
    
    //REGIONAL SUL
    Route::get('regional/sul', [RegionalSulController::class ,'formregionalsul'])->name('regional.sul');
    Route::post('regional/sul/save', [RegionalSulController::class , 'store'])->name('regional.sul.save');

    //REGIONAL NORDESTE
    Route::get('regional/nordeste', [RegionalNordesteController::class ,'formregionalnordeste'])->name('regional.nordeste');
    Route::post('regional/nordeste/save', [RegionalNordesteController::class , 'store'])->name('regional.nordeste.save');

    //REGIONAL NORTE
    Route::get('regional/norte', [RegionalNorteController::class ,'formregionalnorte'])->name('regional.norte');
    Route::post('regional/norte/save', [RegionalNorteController::class , 'store'])->name('regional.norte.save');

    //REGIONAL CENTRO-OESTE
    Route::get('regional/centrooeste', [RegionalCentrooesteController::class ,'formregionalcentrooeste'])->name('regional.centrooeste');
    Route::post('regional/centrooeste/save', [RegionalCentrooesteController::class , 'store'])->name('regional.centrooeste.save');

    //REGIONAL SULDESTE
    Route::get('regional/suldeste', [RegionalSuldesteController::class ,'formregionalsuldeste'])->name('regional.suldeste');
    Route::post('regional/suldeste/save', [RegionalSuldesteController::class , 'store'])->name('regional.suldeste.save');


    //SUBMISSAO REGIONAL SUL
    Route::get('submissao/regional/sul', [SubmissaoRegionalSulController::class ,'submissaoRegionalSul'])->name('submissao.regional.sul');
    Route::get('submissaoexpocom/regional/sul', [SubmissaoRegionalSulController::class ,'submissaoExpocomRegionalSul'])->name('submissaoexpocom.regional.sul');
    Route::get('submissaojunior/regional/sul', [SubmissaoRegionalSulController::class ,'submissaoJuniorRegionalSul'])->name('submissaojunior.regional.sul');
    Route::get('submissaomesa/regional/sul', [SubmissaoRegionalSulController::class ,'submissaoMesaRegionalSul'])->name('submissaomesa.regional.sul');
    Route::post('submissao/sul/save', [SubmissaoRegionalSulController::class , 'store'])->name('submissao.sul.save');
    Route::post('submissaoexpocom/sul/save', [SubmissaoExpocomRegionalSulController::class , 'store'])->name('submissaoexpocom.sul.save');

    //SUBMISSAO REGIONAL NORTE
    Route::get('submissao/regional/norte', [SubmissaoRegionalNorteController::class ,'submissaoRegionalNorte'])->name('submissao.regional.norte');
    Route::get('submissaoexpocom/regional/norte', [SubmissaoRegionalNorteController::class ,'submissaoExpocomRegionalNorte'])->name('submissaoexpocom.regional.norte');
    Route::get('submissaojunior/regional/norte', [SubmissaoRegionalNorteController::class ,'submissaoJuniorRegionalNorte'])->name('submissaojunior.regional.norte');
    Route::get('submissaomesa/regional/norte', [SubmissaoRegionalNorteController::class ,'submissaoMesaRegionalNorte'])->name('submissaomesa.regional.norte');
    Route::post('submissao/norte/save', [SubmissaoRegionalNorteController::class , 'store'])->name('submissao.norte.save');
    Route::post('submissaoexpocom/norte/save', [SubmissaoExpocomRegionalNorteController::class , 'store'])->name('submissaoexpocom.norte.save');

    //SUBMISSAO REGIONAL NORDESTE
    Route::get('submissao/regional/nordeste', [SubmissaoRegionalNordestesController::class ,'submissaoRegionalNordeste'])->name('submissao.regional.nordeste');
    Route::get('submissaoexpocom/regional/nordeste', [SubmissaoRegionalNordestesController::class ,'submissaoExpocomRegionalNordeste'])->name('submissaoexpocom.regional.nordeste');
    Route::get('submissaojunior/regional/nordeste', [SubmissaoRegionalNordestesController::class ,'submissaoJuniorRegionalNordeste'])->name('submissaojunior.regional.nordeste');
    Route::get('submissaomesa/regional/nordeste', [SubmissaoRegionalNordestesController::class ,'submissaoMesaRegionalNordeste'])->name('submissaomesa.regional.nordeste');
    Route::post('submissao/nordeste/save', [SubmissaoRegionalNordestesController::class , 'store'])->name('submissao.nordeste.save');
    Route::post('submissaoexpocom/nordeste/save', [SubmissaoExpocomRegionalNordesteController::class , 'store'])->name('submissaoexpocom.nordeste.save');

    //SUBMISSAO REGIONAL SUDESTE
    Route::get('submissao/regional/suldeste', [SubmissaoRegionalSudesteController::class ,'submissaoRegionalSudeste'])->name('submissao.regional.suldeste');
    Route::get('submissaoexpocom/regional/suldeste', [SubmissaoRegionalSudesteController::class ,'submissaoExpocomRegionalSudeste'])->name('submissaoexpocom.regional.suldeste');
    Route::get('submissaojunior/regional/suldeste', [SubmissaoRegionalSudesteController::class ,'submissaoJuniorRegionalSudeste'])->name('submissaojunior.regional.suldeste');
    Route::get('submissaomesa/regional/suldeste', [SubmissaoRegionalSudesteController::class ,'submissaoMesaRegionalSudeste'])->name('submissaomesa.regional.suldeste');
    Route::post('submissao/suldeste/save', [SubmissaoRegionalSudesteController::class , 'store'])->name('submissao.suldeste.save');
    Route::post('submissaoexpocom/suldeste/save', [SubmissaoExpocomRegionalSudesteController::class , 'store'])->name('submissaoexpocom.suldeste.save');

    //SUBMISSAO REGIONAL CENTRO-OESTE
    Route::get('submissao/regional/centrooeste', [SubmissaoRegionalCentrooesteController::class ,'submissaoRegionalCentrooeste'])->name('submissao.regional.centrooeste');
    Route::get('submissaoexpocom/regional/centrooeste', [SubmissaoRegionalCentrooesteController::class ,'submissaoExpocomRegionalCentrooeste'])->name('submissaoexpocom.regional.centrooeste');
    Route::get('submissaojunior/regional/centrooeste', [SubmissaoRegionalCentrooesteController::class ,'submissaoJuniorRegionalCentrooeste'])->name('submissaojunior.regional.centrooeste');
    Route::get('submissaomesa/regional/centrooeste', [SubmissaoRegionalCentrooesteController::class ,'submissaoMesaRegionalCentrooeste'])->name('submissaomesa.regional.centrooeste');
    Route::post('submissao/centrooeste/save', [SubmissaoRegionalCentrooesteController::class , 'store'])->name('submissao.centrooeste.save');
    Route::post('submissaoexpocom/centrooeste/save', [SubmissaoExpocomRegionalCentrooesteController::class , 'store'])->name('submissaoexpocom.centrooeste.save');

    Route::resource('avaliacao', DistribuicaoTipo123Controller::class)->except(['show', 'create', 'edit']);
    Route::get('avaliacao/get', [DistribuicaoTipo123Controller::class ,'get'])->name('avaliacao.get');
    Route::post('avaliacao/avaliador/save', [DistribuicaoTipo123Controller::class , 'avaliadorSave'])->name('avaliacao.avaliador.save');
    Route::post('avaliacao/coordenador/save', [DistribuicaoTipo123Controller::class , 'coordenadorSave'])->name('avaliacao.coordenador.save');

    Route::resource('avaliacaoexpocom', DistribuicaoTipoExpocomController::class)->except(['show', 'create', 'edit']);

    Route::get('avaliacaoexpocom/view/{regiao}', [DistribuicaoTipoExpocomController::class ,'view'])->name('avaliacaoexpocom.view');

    Route::get('avaliacaoexpocom/get', [DistribuicaoTipoExpocomController::class ,'get'])->name('avaliacaoexpocom.get');
    Route::post('avaliacaoexpocom/avaliador/save', [DistribuicaoTipoExpocomController::class , 'avaliadorSave'])->name('avaliacaoexpocom.avaliador.save');
    Route::post('avaliacaoexpocom/coordenador/save', [DistribuicaoTipoExpocomController::class , 'coordenadorSave'])->name('avaliacaoexpocom.coordenador.save');

    //AVALIACAO NACIONAL
    Route::resource('avaliacao_nacional', AvaliacaoNacionalController::class)->except(['show', 'create', 'edit']);
    Route::get('avaliacao_nacional/get', [AvaliacaoNacionalController::class ,'get'])->name('avaliacao_nacional.get');
    Route::post('avaliacao_nacional/avaliador/save', [AvaliacaoNacionalController::class , 'avaliadorSave'])->name('avaliacao_nacional.avaliador.save');
    Route::post('avaliacao_nacional/coordenador/save', [AvaliacaoNacionalController::class , 'coordenadorSave'])->name('avaliacao_nacional.coordenador.save');


    //GRID AVALIADOR TIPO 1,2,3
    Route::resource('avaliador', AvaliacaoAvaliadorController::class)->except(['show', 'create', 'edit']);
    Route::get('avaliador/get', [AvaliacaoAvaliadorController::class ,'get'])->name('avaliador.get');

    //GRID AVALIADOR EXPOCOM
    Route::resource('avaliador-expocom', AvaliacaoAvaliadorExpocomController::class)->except(['show', 'create', 'edit']);
    Route::get('avaliador-expocom/get', [AvaliacaoAvaliadorExpocomController::class ,'get'])->name('avaliador.get');

    //CHAT TIPO 1,2,3
    Route::get('coordenador/get/chat/{id}', [ChatAvaliacaoController::class ,'getChat'])->name('chatcoordenador.get.chat');
    Route::post('coordenador/send/message',[ChatAvaliacaoController::class,'sendMensagem'])->name('chatcoordenador.send.message');
    
    //CHAT ENTRE COORDENADOR E AVALIADOR TIPO 1,2,3
    Route::get('coordenador/get/chat/avaliador/{id}', [ChatAvaliacaoController::class ,'getChatAvaliador'])->name('chatcoordenador.get.chat.avaliador');
    Route::post('coordenador/avaliador/send/message',[ChatAvaliacaoController::class,'sendMensagemAvaliador'])->name('chatcoordenador.avaliador.send.message');

    //CHAT EXPOCOM
    Route::get('coordenador/expocom/get/chat/{id}', [ChatAvaliacaoController::class ,'getChatExpocom'])->name('chatcoordenador.expocom.get.chat');
    Route::post('coordenador/expocom/send/message',[ChatAvaliacaoController::class,'sendMensagemExpocom'])->name('chatcoordenador.expocom.send.message');

    //GRID AUTOR (AVALIADO)
    Route::resource('submissao', SubmissaoController::class)->except(['show', 'create', 'edit']);
    Route::get('submissao/get', [SubmissaoController::class ,'get'])->name('submissao.get');
    Route::post('submissao/edit', [SubmissaoController::class , 'edit'])->name('submissao.edit');
    Route::get('submissao/carta_aceite/pdf/{regiao}/{id}', [SubmissaoController::class ,'carta_aceite'])->name('submissao.carta_aceite');

    //GRID AUTOR (AVALIADO EXPOCOM)
    Route::resource('submissao-expocom', SubmissaoExpocomController::class)->except(['show', 'create', 'edit']);
    Route::get('submissao-expocom/get', [SubmissaoExpocomController::class ,'get'])->name('submissao-expocom.get');
    Route::post('submissao-expocom/edit', [SubmissaoExpocomController::class , 'edit'])->name('submissao-expocom.edit');
    Route::post('submissao-expocom/envio_video', [SubmissaoExpocomController::class , 'envio_video'])->name('submissao-expocom.envio_video');
    Route::get('submissao-expocom/carta_aceite/pdf/{regiao}/{id}', [SubmissaoExpocomController::class ,'carta_aceite'])->name('submissao-expocom.carta_aceite');

    //VALIDAÇÃO DE APRESENTAÇÃO DE TRABALHO EXPOCOM E VENCEDOR
    Route::resource('validar-apresentacao-expocom', ValidarApresentacaoExpocomController::class)->except(['index', 'show', 'create', 'edit']);
    Route::get('validar-apresentacao-expocom/index', [ValidarApresentacaoExpocomController::class ,'index'])->name('validar-apresentacao-expocom.index');
    Route::get('validar-apresentacao-expocom/get', [ValidarApresentacaoExpocomController::class ,'get'])->name('validar-apresentacao-expocom.get');
    Route::get('validar-apresentacao-expocom/delete/{id}', [ValidarApresentacaoExpocomController::class ,'delete'])->name('validar-apresentacao-expocom.delete');
    Route::post('validar-apresentacao-expocom/confirmar_apresentacao', [ValidarApresentacaoExpocomController::class ,'confirmar_apresentacao'])->name('validar-apresentacao-expocom.confirmar_apresentacao');
    Route::post('validar-apresentacao-expocom/confirmar_vencedor', [ValidarApresentacaoExpocomController::class ,'confirmar_vencedor'])->name('validar-apresentacao-expocom.confirmar_vencedor');

    //VALIDAÇÃO DE APRESENTAÇÃO DE TRABALHO DT,IJ E MESA E VENCEDOR
    Route::resource('validar-apresentacao', ValidarApresentacaoController::class)->except(['index', 'show', 'create', 'edit']);
    Route::get('validar-apresentacao/index', [ValidarApresentacaoController::class ,'index'])->name('validar-apresentacao.index');
    Route::get('validar-apresentacao/get', [ValidarApresentacaoController::class ,'get'])->name('validar-apresentacao.get');
    Route::get('validar-apresentacao/delete/{id}', [ValidarApresentacaoController::class ,'delete'])->name('validar-apresentacao.delete');
    Route::post('validar-apresentacao/confirmar_apresentacao', [ValidarApresentacaoController::class ,'confirmar_apresentacao'])->name('validar-apresentacao.confirmar_apresentacao');
    Route::post('validar-apresentacao/confirmar_vencedor', [ValidarApresentacaoController::class ,'confirmar_vencedor'])->name('validar-apresentacao.confirmar_vencedor');
    
    
    //Lista de trabalhos aceitos expocom com link do video
    Route::resource('lista-trabalho-expocom', ListaTrabalhosExpocomController::class)->except(['index', 'show', 'create', 'edit']);
    Route::get('lista-trabalho-expocom/view/{regiao_id}', [ListaTrabalhosExpocomController::class ,'view'])->name('lista-trabalho-expocom.view');
    Route::get('lista-trabalho-expocom/get', [ListaTrabalhosExpocomController::class ,'get'])->name('lista-trabalho-expocom.get');


});
//END AUTH

//GET no banco livres
Route::prefix('get')->group(function () {
    Route::get('userlogado', [GetController::class, 'userlogado'])->name('get.logado.user');
    Route::get('users', [GetController::class, 'getUsers'])->name('get.user');
    Route::get('tiposusuarios', [GetController::class, 'tiposUsuarios'])->name('get.tiposUsuarios');
    Route::get('tipo_isencao', [GetController::class, 'tipo_isencao'])->name('get.tipo_isencao');
    Route::get('acessos', [GetController::class, 'acessos'])->name('get.acessos');
    Route::get('estados', [GetController::class, 'getEstados'] )->name('get.estados');
    Route::get('municipios/{estado_id}', [GetController::class, 'getMunicipios'])->name('get.municipios');
    Route::get('tiposexo', [GetController::class, 'getTipoSexo'])->name('get.tiposexo');
    Route::get('titulacoes', [GetController::class, 'getTitulacoes'])->name('get.titulacao');
    Route::get('instituicoes', [GetController::class, 'getInstituicoes'])->name('get.instituicoes');
    Route::get('produtos', [GetController::class, 'getProdutos'])->name('get.produtos');
    Route::get('divisoes-tematicas', [GetController::class, 'getDivisoesTematicas'])->name('get.divisoes-tematicas');
    Route::get('gp', [GetController::class, 'getGrupoPesquisa'])->name('get.gp');
    Route::get('divisoes-tematicas-jr', [GetController::class, 'getDivisoesTematicasJr'])->name('get.divisoes-tematicas-jr');
    Route::get('cinema-audiovisual', [GetController::class, 'getCinemaAudiovisual'])->name('get.cinema-audiovisual');
    Route::get('jornalismo', [GetController::class, 'getJornalismo'])->name('get.jornalismo');
    Route::get('publicidade-propaganda', [GetController::class, 'getPublicidadePropaganda'])->name('get.publicidade-propaganda');
    Route::get('relacoes-publicas', [GetController::class, 'getRelacoesPublicas'])->name('get.relacoes-publicas');
    Route::get('producao-editorial', [GetController::class, 'getProdEdit'])->name('get.producao-editorial');
    Route::get('radio-internet', [GetController::class, 'getRadioInternet'])->name('get.radio-internet');
    Route::get('produtos-regionais-sul', [GetController::class, 'getProdutosRegionaisSul'])->name('get.produtos.regionais.sul');
    Route::get('produtos-regionais-suldeste', [GetController::class, 'getProdutosRegionaisSuldeste'])->name('get.produtos.regionais.suldeste');
    Route::get('produtos-regionais-norte', [GetController::class, 'getProdutosRegionaisNorte'])->name('get.produtos.regionais.norte');
    Route::get('produtos-regionais-nordeste', [GetController::class, 'getProdutosRegionaisNordeste'])->name('get.produtos.regionais.nordeste');
    Route::get('produtos-regionais-centrooeste', [GetController::class, 'getProdutosRegionaisCentrooeste'])->name('get.produtos.regionais.centrooeste');
    Route::get('produtos-nacional', [GetController::class, 'getProdutosNacional'])->name('get.produtos.nacional');
    Route::get('produtos-regionais', [GetController::class, 'getProdutosRegionais'])->name('get.produtos.regionais');
    Route::get('indicacao-expocom-2022', [GetController::class, 'getIndicacaoExpocom2022'])->name('get.indicacao.expocom.2022');
    Route::get('admin-indicacao-expocom-2022/{id}', [GetController::class, 'getAdminIndicacaoExpocom2022'])->name('get.admin.indicacao.expocom.2022');
    Route::get('avaliadores', [GetController::class, 'getAvaliadores'])->name('get.avaliadores');
    Route::get('avaliadores-expocom', [GetController::class, 'getAvaliadoresExpocom'])->name('get.avaliadores.expocom');
    Route::get('coordenador/{id}', [GetController::class, 'getCoordenador'])->name('get.coordenador');
    Route::get('status-pagamento', [GetController::class, 'getPagamentosStatuses'])->name('get.status-pagamento');

});

//GRID TRABALHOS ACEITOS EXPOCOM 
//Route::resource('lista-trabalhos-expocom', ListaTrabalhosExpocomController::class)->except(['show', 'create', 'edit']);
//Route::get('lista-trabalhos-expocom/view/{regiao}', [ListaTrabalhosExpocomController::class ,'view'])->name('lista-trabalhos.view');
//Route::get('lista-trabalhos-expocom/get', [ListaTrabalhosExpocomController::class ,'get'])->name('lista-trabalhos.get');

//GRID TRABALHOS ACEITOS 
Route::resource('lista-trabalhos', ListaTrabalhosController::class)->except(['show', 'create', 'edit']);
Route::get('lista-trabalhos/view/{regiao}', [ListaTrabalhosController::class ,'view'])->name('lista-trabalhos.view');
Route::get('lista-trabalhos/get', [ListaTrabalhosController::class ,'get'])->name('lista-trabalhos.get');

Route::get('cronjob/atualizar_valores', [CronController::class, 'atualizar_valores'])->name('cronjob.atualizar_valores');
Route::get('cronjob/deletar_pag_recusado', [CronController::class, 'deletar_pag_recusado'])->name('cronjob.deletar_pag_recusado');
Route::get('cronjob/verificar_pagamentos', [CronController::class, 'verificar_pagamentos'])->name('cronjob.verificar_pagamentos');
Route::get('cronjob/verificar_tipos_pagamentos_sul', [CronController::class, 'verificar_tipos_pagamentos_sul'])->name('cronjob.verificar_tipos_pagamentos_sul');
Route::get('cronjob/verificar_tipos_pagamentos_sudeste', [CronController::class, 'verificar_tipos_pagamentos_sudeste'])->name('cronjob.verificar_tipos_pagamentos_sudeste');
Route::get('cronjob/verificar_tipos_pagamentos_norte', [CronController::class, 'verificar_tipos_pagamentos_norte'])->name('cronjob.verificar_tipos_pagamentos_norte');
Route::get('cronjob/verificar_tipos_pagamentos_nordeste', [CronController::class, 'verificar_tipos_pagamentos_nordeste'])->name('cronjob.verificar_tipos_pagamentos_nordeste');
Route::get('cronjob/verificar_tipos_pagamentos_centro_oeste', [CronController::class, 'verificar_tipos_pagamentos_centro_oeste'])->name('cronjob.verificar_tipos_pagamentos_centro_oeste');
Route::get('cronjob/verificar_tipos_pagamentos_nacional', [CronController::class, 'verificar_tipos_pagamentos_nacional'])->name('cronjob.verificar_tipos_pagamentos_nacional');
Route::get('cronjob/teste', [CronController::class, 'teste'])->name('cronjob.teste');


Route::prefix('indicacao')->group(function(){
    Route::get('/', [IndicacaoController::class, 'index'])->name('indicacao.index');
    Route::post('cpfcheckindicacao', [IndicacaoController::class, 'cpfCheckIndicacao'])->name('indicacao.cpfcheckindicacao');
    Route::post('save', [IndicacaoController::class , 'store'])->name('indicacao.save');
});

Route::get('/register', function() {
    return redirect('/login');    
});
Route::get('/password/reset', function() {
    return redirect('/login');    
});

Route::get('/password/reset', function() {
    return redirect('/login');    
});


Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

Route::get('/cadastro', [CadastroController::class, 'index'])->name('cadastro');
Route::post('/cadastro/save', [CadastroController::class , 'store'])->name('cadastro.save');
Route::post('/cadastro/emailcheck', [CadastroController::class , 'emailCheck'])->name('cadastro.emailcheck');
Route::post('/cadastro/cpfcheck', [CadastroController::class , 'cpfCheck'])->name('cadastro.cpfcheck');
Route::post('cadastro/passaportecheck', [CadastroController::class , 'passaporteCheck'])->name('cadastro.passaportecheck');

//RESET DE SENHA
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::prefix('dashboard')->middleware('roles:dashboard')->group(function () {

    Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('inscritos', [DashboardController::class , 'inscritos'])->name('dashboard.inscritos');
    Route::post('inscritos_pagos', [DashboardController::class , 'inscritos_pagos'])->name('dashboard.inscritos_pagos');
    Route::post('valor_total', [DashboardController::class , 'valor_total'])->name('dashboard.valor_total');
    Route::post('inscritos_isentos', [DashboardController::class , 'inscritos_isentos'])->name('dashboard.inscritos_isentos');
    Route::post('submissao_expocom', [DashboardController::class , 'submissao_expocom'])->name('dashboard.submissao_expocom');
    Route::post('submissao_dt', [DashboardController::class , 'submissao_dt'])->name('dashboard.submissao_dt');
    Route::post('submissao_ij', [DashboardController::class , 'submissao_ij'])->name('dashboard.submissao_ij');
    Route::post('submissao_mesa', [DashboardController::class , 'submissao_mesa'])->name('dashboard.submissao_mesa');
    Route::post('associados_inscritos', [DashboardController::class , 'associados_inscritos'])->name('dashboard.associados_inscritos');

});

Route::get('excelll', [ExcelController::class, 'export'])->name('excelll');
