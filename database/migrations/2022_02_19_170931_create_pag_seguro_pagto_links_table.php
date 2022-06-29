<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagSeguroPagtoLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pag_seguro_pagto_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('link');
            $table->bigInteger('pagseguro_pagto_id')->unsigned();
            $table->foreign('pagseguro_pagto_id')->references('id')->on('pag_seguro_pgtos');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('pag_seguro_pagto_links');
    }
}
