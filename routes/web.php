<?php

use App\Http\Controllers\AssociadoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('/configclear', function () {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
});

Route::get('/viewclear', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
});

Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    dd('migrated!');
});

Auth::routes();

Route::match(['get', 'post'], 'register', function () {
    return redirect('/login');
});



Route::group(['middleware' => 'auth'], function () {

    Route::resource('fornecedores', FornecedoresController::class);

    // Route::get('/', [PerfilController::class , 'perfil']);
    Route::get('perfil', [PerfilController::class, 'perfil'])->name('perfil');
    Route::post('perfil/save', [PerfilController::class, 'store'])->name('perfil.save');
    Route::put('perfil/senhaupdate', [PerfilController::class, 'senhaUpdate'])->name('perfil.senhaupdate');
    Route::post('perfil/passcheck', [PerfilController::class, 'passCheck'])->name('perfil.passcheck');
    Route::post('perfil/emailcheck', [PerfilController::class, 'emailCheck'])->name('perfil.emailcheck');

    Route::prefix('admin')->group(function () {
        Route::middleware(['roles:admin/usuarios'])->group(function () {
            Route::resource('usuarios', UserController::class)->except(['show', 'create', 'edit']);
            Route::get('usuarios/get', [UserController::class, 'get'])->name('usuarios.get');
        });
    });

    Route::prefix('financeiro')->group(function () {
        Route::middleware(['roles:financeiro/relatorios'])->group(function () {
            Route::get('relatorios/index', [RelatoriosController::class, 'index'])->name('financeiro.relatorios.index');
            Route::get('relatorios/get', [RelatoriosController::class, 'get'])->name('financeiro.relatorios.get');
            Route::post('relatorios/excel', [RelatoriosController::class, 'excel'])->name('financeiro.relatorios.excel');
        });
    });
});
//END AUTH

//GET no banco livres
Route::prefix('get')->group(function () {
    Route::get('userlogado', [GetController::class, 'userlogado'])->name('get.logado.user');
    Route::get('users', [GetController::class, 'getUsers'])->name('get.user');
    Route::get('tiposusuarios', [GetController::class, 'tiposUsuarios'])->name('get.tiposUsuarios');
    Route::get('acessos', [GetController::class, 'acessos'])->name('get.acessos');
    Route::get('estados', [GetController::class, 'getEstados'])->name('get.estados');
    Route::get('municipios/{estado_id}', [GetController::class, 'getMunicipios'])->name('get.municipios');
    Route::get('tiposexo', [GetController::class, 'getTipoSexo'])->name('get.tiposexo');
    Route::get('titulacoes', [GetController::class, 'getTitulacoes'])->name('get.titulacao');
});



Route::get('/register', function () {
    return redirect('/login');
});
Route::get('/password/reset', function () {
    return redirect('/login');
});

Route::get('/password/reset', function () {
    return redirect('/login');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

Route::get('/cadastro', [CadastroController::class, 'index'])->name('cadastro');
Route::post('/cadastro/save', [CadastroController::class, 'store'])->name('cadastro.save');
Route::post('/cadastro/emailcheck', [CadastroController::class, 'emailCheck'])->name('cadastro.emailcheck');
Route::post('/cadastro/cpfcheck', [CadastroController::class, 'cpfCheck'])->name('cadastro.cpfcheck');
Route::post('cadastro/passaportecheck', [CadastroController::class, 'passaporteCheck'])->name('cadastro.passaportecheck');

//RESET DE SENHA
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
