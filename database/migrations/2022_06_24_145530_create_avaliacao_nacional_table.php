<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoNacionalTable extends Migration
{
    public function up()
    {
        Schema::create('avaliacao_nacional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('avaliador_1');
            $table->string('status_avaliador_1')->nullable();
            $table->string('justificativa_avaliador_1')->nullable();
            $table->bigInteger('avaliador_2')->nullable();
            $table->string('status_avaliador_2')->nullable();
            $table->string('justificativa_avaliador_2')->nullable();
            $table->bigInteger('avaliador_3')->nullable();
            $table->string('status_avaliador_3')->nullable();
            $table->string('justificativa_avaliador_3')->nullable();
            $table->string('status_coordenador')->nullable();
            $table->string('justificativa_coordenador')->nullable();
            $table->bigInteger('edit')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacao_nacional');
    }
}
