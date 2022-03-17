<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoautorOrientadorSubSulsTable extends Migration
{
    public function up()
    {
        Schema::create('coautor_orientador_sub_suls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('submissao_id');
            $table->foreign('submissao_id')->references('id')->on('submissao_regional_suls');
            $table->string('nome_completo');
            $table->string('cpf');
            $table->string('categoria');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coautor_orientador_sub_suls');
    }
}
