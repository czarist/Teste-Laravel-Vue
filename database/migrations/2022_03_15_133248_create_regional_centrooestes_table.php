<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionalCentrooestesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regional_centrooestes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('regiao')->nullable();
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regional_centrooestes');
    }
}
