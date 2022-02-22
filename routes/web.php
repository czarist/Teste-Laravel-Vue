<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\TitulacaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'] , function() {

    Route::prefix('config')->group(function () {

        Route::middleware(['roles:config/sexo'])->group(function () {
            Route::resource('sexo', SexoController::class)->except(['show', 'create', 'edit']);
            Route::get('sexo/get', [SexoController::class ,'get'])->name('sexo.get');
        });

        Route::middleware(['roles:config/categoria'])->group(function () {
            Route::resource('categoria', CategoriaController::class)->except(['show', 'create', 'edit']);
            Route::get('categoria/get', [CategoriaController::class ,'get'])->name('categoria.get');
            Route::post('categoria/numerocheck', [CategoriaController::class ,'numberSociocheck'])->name('categoria.numberSociocheck');
        });

        Route::middleware(['roles:config/instituicao'])->group(function () {
            Route::resource('instituicao', InstituicaoController::class)->except(['show', 'create', 'edit']);
            Route::get('instituicao/get', [InstituicaoController::class ,'get'])->name('instituicao.get');
        });

        Route::middleware(['roles:config/usuario'])->group(function () {
            Route::resource('usuario', UserController::class)->except(['show', 'create', 'edit']);
            Route::get('usuario/get', [UserController::class ,'get'])->name('usuario.get');
        });

        Route::middleware(['roles:config/titulacao'])->group(function () {
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

Route::get('/', function() {
    return redirect('/config/sexo');    
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
