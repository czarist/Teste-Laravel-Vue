<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliadorExpocomsTable extends Migration
{
    public function up()
    {
        Schema::create('avaliador_expocoms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('avaliador')->default(false);
            $table->boolean('avaliador_junior')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliador_expocoms');
    }
}
