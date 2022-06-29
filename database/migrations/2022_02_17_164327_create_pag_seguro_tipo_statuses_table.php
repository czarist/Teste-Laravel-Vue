<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagSeguroTipoStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('pag_seguro_tipo_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('memo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pag_seguro_tipo_statuses');
    }
}
