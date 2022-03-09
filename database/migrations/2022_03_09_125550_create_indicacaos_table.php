<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicacaosTable extends Migration
{
    public function up()
    {
        Schema::create('indicacaos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_respo');
            $table->string('cpf_respo')->nullable();
            $table->string('respo_indicacao');
            $table->string('email_respo');
            $table->string('email_curso');
            $table->string('celular')->nullable();
            $table->string('nome_autor');
            $table->string('cpf_autor')->unique()->nullable();
            $table->string('trabalho_produzido');
            $table->string('orientador');
            $table->string('titulo_trabalho');
            $table->string('categoria');
            $table->string('modalidade');
            $table->string('estado_id');
            $table->unsignedBigInteger('endereco_id');
            $table->foreign('endereco_id')->references('id')->on('endereco_indicacaos');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicaos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indicacaos');
    }
}
