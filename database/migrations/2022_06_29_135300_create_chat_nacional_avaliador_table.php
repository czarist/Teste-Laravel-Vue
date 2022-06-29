<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatNacionalAvaliadorTable extends Migration
{
    public function up()
    {
        Schema::create('chat_nacional_avaliador', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('avaliacao_id');
            $table->foreign('avaliacao_id')->references('id')->on('avaliacao_nacional');
            $table->bigInteger('avaliador_id')->nullable();
            $table->unsignedBigInteger('coordenador_id')->nullable();
            $table->foreign('coordenador_id')->references('id')->on('coordenador_nacional');
            $table->bigInteger('send_avaliador')->nullable();
            $table->string('mensagem')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_nacional_avaliador');
    }
}
