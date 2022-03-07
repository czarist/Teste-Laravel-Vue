<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosCategoriaJornalismosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos_categoria_jornalismos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('categoria_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categoria_jornalismos');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('todos_categoria_jornalismos');
    }
}
