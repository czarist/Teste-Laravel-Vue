<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        header('Access-Control-Allow-Origin:*');
        setlocale(LC_ALL, 'pt_BR.UTF-8');
        Schema::defaultStringLength(191);
        Carbon::setLocale('pt_BR');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function register()
    {
        // DESCOMENTAR PARA PRODUÇÃO
        $this->app->bind('path.public', function() {
            return '../www';

        });
    }
}
