<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociadosTable extends Migration
{
    public function up()
    {
        Schema::create('associados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('numero_socio')->nullable();
            $table->string('anuidade')->nullable();
            $table->boolean('isencao')->nullable();
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->foreign('instituicao_id')->references('id')->on('instituicaos')->nullable();
            $table->unsignedBigInteger('titulacao_id')->nullable();
            $table->foreign('titulacao_id')->references('id')->on('titulacaos')->nullable();
            $table->string('divisao_tematica')->nullable();
            $table->string('obs_isentamos')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('associados');
    }
}
