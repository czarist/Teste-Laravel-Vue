<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaRelacoesPublicasTable extends Migration
{
    public function up()
    {
        Schema::create('categoria_relacoes_publicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categoria_relacoes_publicas');
    }
}
