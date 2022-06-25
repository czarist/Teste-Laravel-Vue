<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoTiposIsencaoTable extends Migration
{
    public function up()
    {
        Schema::create('todo_tipos_isencao', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('tipo_isencao_id')->unsigned();
            $table->foreign('tipo_isencao_id')->references('id')->on('tipo_isencao');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_tipos_isencao');
    }
}
