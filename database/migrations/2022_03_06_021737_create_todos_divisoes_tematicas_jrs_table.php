<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosDivisoesTematicasJrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos_divisoes_tematicas_jrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dt_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('dt_id')->references('id')->on('divisoes_tematicas_jrs');
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
        Schema::dropIfExists('todos_divisoes_tematicas_jrs');
    }
}
