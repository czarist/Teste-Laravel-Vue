<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNacionalsTable extends Migration
{
    public function up()
    {
        Schema::create('nacionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('categoria_inscricao')->nullable();
            $table->string('numero_matricula')->nullable();
            $table->string('ano')->nullable();
            $table->boolean('guardador_sabado')->nullable();
            $table->string('port_nece_espe')->nullable();
            $table->string('port_nece_espe_qual')->nullable();
            $table->string('port_nece_espe_outra')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nacionals');
    }
}
