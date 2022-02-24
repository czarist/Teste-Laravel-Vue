<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagSeguroPgtosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pag_seguro_pgtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipo_pgto_detalhe');
            $table->string('transacao');
            $table->bigInteger('parcelas');
            $table->decimal('valor_parcela', 15,2);	
            $table->decimal('valor_total', 15,2);	
            $table->decimal('valor_juros', 15,2);	
            $table->decimal('valor_receber', 15,2);	
            $table->bigInteger('venda_id')->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->bigInteger('tipo_pagto_id')->unsigned();
            $table->foreign('tipo_pagto_id')->references('id')->on('pag_seguro_tipo_pagtos');
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('pag_seguro_tipo_statuses');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pag_seguro_pgtos');
    }
}
