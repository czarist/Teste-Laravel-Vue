<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTiposPagamentosTable extends Migration
{
    public function up()
    {
        Schema::create('todos_tipos_pagamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tipo_pagamento_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('tipo_pagamento_id')->references('id')->on('tipos_pagamentos');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todos_tipos_pagamentos');
    }
}
