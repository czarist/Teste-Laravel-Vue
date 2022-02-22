<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\TitulacaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::match(['get', 'post'], 'register', function () {
    return redirect('/');
});

Route::group(['middleware' => 'auth'] , function() {

    Route::get('/', [PerfilController::class , 'senha'])->name('senha');
    Route::get('/perfil', [PerfilController::class , 'senha'])->name('senha');
    Route::put('/perfil/senhaupdate', [PerfilController::class , 'senhaUpdate'])->name('perfil.senhaupdate');
    Route::post('perfil/passcheck', [PerfilController::class , 'passCheck'])->name('perfil.passcheck');
    Route::post('perfil/emailcheck', [PerfilController::class , 'emailCheck'])->name('perfil.emailcheck');


    Route::prefix('admin')->group(function () {

        Route::middleware(['roles:admin/usuarios'])->group(function () {
            Route::resource('titulacao', TitulacaoController::class)->except(['show', 'create', 'edit']);
            Route::get('titulacao/get', [TitulacaoController::class ,'get'])->name('titulacao.get');
        });

        Route::middleware(['roles:admin/sexo'])->group(function () {
            Route::resource('sexo', SexoController::class)->except(['show', 'create', 'edit']);
            Route::get('sexo/get', [SexoController::class ,'get'])->name('sexo.get');
        });    

        Route::middleware(['roles:admin/categoria'])->group(function () {
            Route::resource('categoria', CategoriaController::class)->except(['show', 'create', 'edit']);
            Route::get('categoria/get', [CategoriaController::class ,'get'])->name('categoria.get');
            Route::post('categoria/numerocheck', [CategoriaController::class ,'numberSociocheck'])->name('categoria.numberSociocheck');
        });    

        Route::middleware(['roles:admin/instituicao'])->group(function () {
            Route::resource('instituicao', InstituicaoController::class)->except(['show', 'create', 'edit']);
            Route::get('instituicao/get', [InstituicaoController::class ,'get'])->name('instituicao.get');
        });    

        Route::middleware(['roles:admin/usuarios'])->group(function () {
            Route::resource('usuarios', UserController::class)->except(['show', 'create', 'edit']);
            Route::get('usuarios/get', [UserController::class ,'get'])->name('usuarios.get');
        });    

        Route::middleware(['roles:admin/titulacao'])->group(function () {
            Route::resource('titulacao', TitulacaoController::class)->except(['show', 'create', 'edit']);
            Route::get('titulacao/get', [TitulacaoController::class ,'get'])->name('titulacao.get');
        });    



    });

});

Route::prefix('get')->group(function () {
    Route::get('userlogado', [GetController::class, 'userlogado'])->name('get.logado.user');
    Route::get('users', [GetController::class, 'getUsers'])->name('get.user');
    Route::get('tiposusuarios', [GetController::class, 'tiposUsuarios'])->name('get.tiposUsuarios');
    Route::get('acessos', [GetController::class, 'acessos'])->name('get.acessos');

});

Route::get('/register', function() {
    return redirect('/login');    
});
Route::get('/password/reset', function() {
    return redirect('/login');    
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
