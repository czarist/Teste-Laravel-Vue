<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AvaliadorExpocomController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndicacaoController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegionalCentrooesteController;
use App\Http\Controllers\RegionalNordesteController;
use App\Http\Controllers\RegionalNorteController;
use App\Http\Controllers\RegionalSulController;
use App\Http\Controllers\RegionalSuldesteController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\SubmissaoExpocomRegionalCentrooesteController;
use App\Http\Controllers\SubmissaoExpocomRegionalNordesteController;
use App\Http\Controllers\SubmissaoExpocomRegionalNorteController;
use App\Http\Controllers\SubmissaoExpocomRegionalSudesteController;
use App\Http\Controllers\SubmissaoExpocomRegionalSulController;
use App\Http\Controllers\SubmissaoRegionalCentrooesteController;
use App\Http\Controllers\SubmissaoRegionalNordestesController;
use App\Http\Controllers\SubmissaoRegionalNorteController;
use App\Http\Controllers\SubmissaoRegionalSudesteController;
use App\Http\Controllers\SubmissaoRegionalSulController;
use App\Http\Controllers\TitulacaoController;
use App\Http\Controllers\UserController;
use App\Models\SubmissaoExpocomRegionalCentrooeste;
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

    //Associado
    Route::get('associado/area', [AssociadoController::class ,'area'])->name('associado.area');
    Route::get('associado', [AssociadoController::class ,'area'])->name('associado');

    //AREA DE PAGAMENTO
    Route::resource('pagamento', PagamentoController::class)->except(['show', 'create', 'edit']);
    Route::get('pagamento/get', [PagamentoController::class ,'get'])->name('pagamento.get');

    //FORM AVALIADOR EXPOCOM
    Route::get('/avaliadorjr', [AvaliadorExpocomController::class, 'formavaliadorjr'])->name('avaliadorjr');
    Route::get('/avaliadorexpocom', [AvaliadorExpocomController::class, 'formavaliadorexpocom'])->name('avaliadorexpocom');
    Route::post('avaliador/save', [AvaliadorExpocomController::class , 'store'])->name('avaliador.save');


    //REGIONAL SUL
    Route::get('regional/sul', [RegionalSulController::class ,'formregionalsul'])->name('reginal.sul');
    Route::post('regional/sul/save', [RegionalSulController::class , 'store'])->name('regional.sul.save');

    //REGIONAL NORDESTE
    Route::get('regional/nordeste', [RegionalNordesteController::class ,'formregionalnordeste'])->name('reginal.nordeste');
    Route::post('regional/nordeste/save', [RegionalNordesteController::class , 'store'])->name('regional.nordeste.save');

    //REGIONAL NORTE
    Route::get('regional/norte', [RegionalNorteController::class ,'formregionalnorte'])->name('reginal.norte');
    Route::post('regional/norte/save', [RegionalNorteController::class , 'store'])->name('regional.norte.save');

    //REGIONAL CENTRO-OESTE
    Route::get('regional/centrooeste', [RegionalCentrooesteController::class ,'formregionalcentrooeste'])->name('reginal.centrooeste');
    Route::post('regional/centrooeste/save', [RegionalCentrooesteController::class , 'store'])->name('regional.centrooeste.save');

    //REGIONAL SULDESTE
    Route::get('regional/suldeste', [RegionalSuldesteController::class ,'formregionalsuldeste'])->name('reginal.suldeste');
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

});
//END AUTH

//GET no banco livres
Route::prefix('get')->group(function () {
    Route::get('userlogado', [GetController::class, 'userlogado'])->name('get.logado.user');
    Route::get('users', [GetController::class, 'getUsers'])->name('get.user');
    Route::get('tiposusuarios', [GetController::class, 'tiposUsuarios'])->name('get.tiposUsuarios');
    Route::get('acessos', [GetController::class, 'acessos'])->name('get.acessos');
    Route::get('estados', [GetController::class, 'getEstados'] )->name('get.estados');
    Route::get('municipios/{estado_id}', [GetController::class, 'getMunicipios'])->name('get.municipios');
    Route::get('tiposexo', [GetController::class, 'getTipoSexo'])->name('get.tiposexo');
    Route::get('titulacoes', [GetController::class, 'getTitulacoes'])->name('get.titulacao');
    Route::get('instituicoes', [GetController::class, 'getInstituicoes'])->name('get.instituicoes');
    Route::get('produtos', [GetController::class, 'getProdutos'])->name('get.produtos');
    Route::get('divisoes-tematicas', [GetController::class, 'getDivisoesTematicas'])->name('get.divisoes-tematicas');
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
    Route::get('produtos-regionais', [GetController::class, 'getProdutosRegionais'])->name('get.produtos.regionais');
    Route::get('indicacao-expocom-2022', [GetController::class, 'getIndicacaoExpocom2022'])->name('get.indicacao.expocom.2022');

});

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

