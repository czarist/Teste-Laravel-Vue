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
            $table->string('numero_socio')->unique();
            $table->boolean('isencao')->nullable();
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->foreign('instituicao_id')->references('id')->on('instituicaos')->onDelete('cascade');
            $table->unsignedBigInteger('titulacao_id')->nullable();
            $table->foreign('titulacao_id')->references('id')->on('titulacaos')->onDelete('cascade');
            $table->date('anuidade');
            $table->string('divisao_tematica');
            $table->string('obs_isentamos')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('associados');
    }
}
