<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosRegionaisTable extends Migration
{
    public function up()
    {
        Schema::create('produtos_regionais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->float('valor', 15,2);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down()
    {
        Schema::dropIfExists('produtos_regionais');
    }
}
