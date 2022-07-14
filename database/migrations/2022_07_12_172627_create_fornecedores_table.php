<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj');
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('email');
            $table->string('telefone');
            $table->string('dados_bancarios');
            $table->string('estado');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('endereco');
            $table->string('CEP');
            $table->text('detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
