<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\TitulacaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::match(['get', 'post'], 'register', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'auth'] , function() {

    // Route::get('/', [PerfilController::class , 'perfil']);
    Route::get('perfil', [PerfilController::class , 'perfil'])->name('perfil');
    Route::put('perfil/senhaupdate', [PerfilController::class , 'senhaUpdate'])->name('perfil.senhaupdate');
    Route::post('perfil/passcheck', [PerfilController::class , 'passCheck'])->name('perfil.passcheck');
    Route::post('perfil/emailcheck', [PerfilController::class , 'emailCheck'])->name('perfil.emailcheck');

    Route::get('filiese', [PerfilController::class , 'filiese'])->name('filiese');



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

});

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

});

Route::get('/register', function() {
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


//PAGSEGURO
Route::get('/pagseguro/pagamento', [PagSeguroController::class, 'pagamento'])->name('pagseguro.pagmento');
Route::post('pagseguro/associado/credito', [PagSeguroController::class , 'associadocredito'])->name('pagseguro.associado.credito');
