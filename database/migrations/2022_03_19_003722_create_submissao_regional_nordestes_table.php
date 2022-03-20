<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissaoRegionalNordestesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissao_regional_nordestes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inscricao_id')->nullable();
            $table->foreign('inscricao_id')->references('id')->on('regional_nordestes');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('palavra_chave_1')->nullable();
            $table->string('palavra_chave_2')->nullable();
            $table->string('palavra_chave_3')->nullable();
            $table->string('palavra_chave_4')->nullable();
            $table->string('palavra_chave_5')->nullable();
            $table->boolean('termo_autoria')->nullable();
            $table->boolean('autorizacao')->nullable();
            $table->string('link_trabalho')->nullable();
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
        Schema::dropIfExists('submissao_regional_nordestes');
    }
}
