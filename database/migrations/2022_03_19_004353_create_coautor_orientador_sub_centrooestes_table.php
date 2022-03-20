<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoautorOrientadorSubCentrooestesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coautor_orientador_sub_centrooestes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('submissao_id');
            $table->foreign('submissao_id')->references('id')->on('submissao_regional_centrooestes');
            $table->string('nome_completo')->nullable();
            $table->string('curso_coautor')->nullable();
            $table->string('cpf')->nullable();
            $table->string('categoria')->nullable();
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
        Schema::dropIfExists('coautor_orientador_sub_centrooestes');
    }
}
