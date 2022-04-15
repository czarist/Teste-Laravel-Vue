<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissaoNacionalsTable extends Migration
{
    public function up()
    {
        Schema::create('submissao_nacionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inscricao_id')->nullable();
            $table->foreign('inscricao_id')->references('id')->on('nacionals');
            $table->bigInteger('avaliacao')->nullable();
            $table->bigInteger('dt')->nullable();
            $table->string('tipo');
            $table->string('titulo');
            $table->string('palavra_chave_1')->nullable();
            $table->string('palavra_chave_2')->nullable();
            $table->string('palavra_chave_3')->nullable();
            $table->string('palavra_chave_4')->nullable();
            $table->string('palavra_chave_5')->nullable();
            $table->boolean('ciente')->nullable();
            $table->string('ano')->nullable();
            $table->string('editora')->nullable();
            $table->boolean('termo_autoria')->nullable();
            $table->boolean('autorizacao')->nullable();
            $table->string('link_trabalho')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('submissao_nacionals');
    }
}
