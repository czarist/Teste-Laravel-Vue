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
            $table->boolean('pergunta_1_1')->nullable();
            $table->boolean('pergunta_1_2')->nullable();
            $table->boolean('pergunta_1_3')->nullable();
            $table->boolean('pergunta_1_4')->nullable();
            $table->boolean('pergunta_1_5')->nullable();
            $table->boolean('pergunta_1_6')->nullable();
            $table->boolean('pergunta_1_7')->nullable();
            $table->boolean('pergunta_1_8')->nullable();
            $table->boolean('pergunta_1_9')->nullable();
            $table->boolean('pergunta_1_10')->nullable();
            $table->boolean('pergunta_1_11')->nullable();
            $table->bigInteger('avaliador_2')->nullable();
            $table->string('status_avaliador_2')->nullable();
            $table->string('justificativa_avaliador_2')->nullable();
            $table->boolean('pergunta_2_1')->nullable();
            $table->boolean('pergunta_2_2')->nullable();
            $table->boolean('pergunta_2_3')->nullable();
            $table->boolean('pergunta_2_4')->nullable();
            $table->boolean('pergunta_2_5')->nullable();
            $table->boolean('pergunta_2_6')->nullable();
            $table->boolean('pergunta_2_7')->nullable();
            $table->boolean('pergunta_2_8')->nullable();
            $table->boolean('pergunta_2_9')->nullable();
            $table->boolean('pergunta_2_10')->nullable();
            $table->boolean('pergunta_2_11')->nullable();
            $table->bigInteger('avaliador_3')->nullable();
            $table->string('status_avaliador_3')->nullable();
            $table->string('justificativa_avaliador_3')->nullable();
            $table->boolean('pergunta_3_1')->nullable();
            $table->boolean('pergunta_3_2')->nullable();
            $table->boolean('pergunta_3_3')->nullable();
            $table->boolean('pergunta_3_4')->nullable();
            $table->boolean('pergunta_3_5')->nullable();
            $table->boolean('pergunta_3_6')->nullable();
            $table->boolean('pergunta_3_7')->nullable();
            $table->boolean('pergunta_3_8')->nullable();
            $table->boolean('pergunta_3_9')->nullable();
            $table->boolean('pergunta_3_10')->nullable();
            $table->boolean('pergunta_3_11')->nullable();
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
