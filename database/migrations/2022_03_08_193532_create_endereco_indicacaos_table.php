<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecoIndicacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endereco_indicacaos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('logradouro')->nullable();
            $table->integer('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->unsignedBigInteger('municipio_id')->unsigned();
            $table->string('cep')->nullable();
            $table->string('pais_id')->nullable();
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
        Schema::dropIfExists('endereco_indicacaos');
    }
}
