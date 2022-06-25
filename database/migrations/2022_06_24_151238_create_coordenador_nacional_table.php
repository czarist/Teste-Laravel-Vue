<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordenadorNacionalTable extends Migration
{
    public function up()
    {
        Schema::create('coordenador_nacional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('geral')->default(0);
            $table->char('tipo')->default(0);
            $table->string('gps')->nullable();
            $table->string('ij')->nullable();
            $table->string('dt')->nullable();
            $table->string('ano');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coordenador_nacional');
    }
}
