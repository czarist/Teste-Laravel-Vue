<?php

use App\Http\Controllers\GetController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'] , function() {

    Route::prefix('config')->group(function () {

        Route::middleware(['roles:config/sexo'])->group(function () {
            Route::resource('sexo', SexoController::class)->except(['show', 'create', 'edit']);
            Route::get('sexo/get', [SexoController::class ,'get'])->name('sexo.get');
        });

    });




    Route::group(['middleware' => 'roles:sales'], function () {

        Route::get('/sales', function() {
            // $category_name = '';
            $data = [
                'category_name' => 'dashboard',
                'page_name' => 'sales',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
                'alt_menu' => 0,
            ];
            // $pageName = 'sales';
            return view('dashboard2')->with($data);
        });
    });

});

Route::prefix('get')->group(function () {
    Route::get('userlogado', [GetController::class, 'userlogado'])->name('get.logado.user');
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
