<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('qtd');
            $table->float('valor', 15,2);
            $table->decimal('valor_total', 15,2);
            $table->bigInteger('venda_id')->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->bigInteger('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
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
        Schema::dropIfExists('venda_items');
    }
}
