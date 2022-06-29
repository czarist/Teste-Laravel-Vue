<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatNacionalTable extends Migration
{
    public function up()
    {
        Schema::create('chat_nacional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('avaliacao_id');
            $table->foreign('avaliacao_id')->references('id')->on('avaliacao_nacional');
            $table->unsignedBigInteger('avaliado_id')->nullable();
            $table->foreign('avaliado_id')->references('id')->on('users');
            $table->unsignedBigInteger('coordenador_id')->nullable();
            $table->foreign('coordenador_id')->references('id')->on('coordenador_nacional');
            $table->string('mensagem')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_nacional');
    }
}
