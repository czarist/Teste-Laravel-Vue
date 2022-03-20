<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissaoExpocomRegionalNortesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inscricao_id')->nullable();
            $table->foreign('inscricao_id')->references('id')->on('regional_nortes');
            $table->string('ano');
            $table->string('campus');
            $table->longText('desc_obj_estudo')->nullable();
            $table->longText('desc_pesquisa')->nullable();
            $table->longText('desc_producao')->nullable();
            $table->boolean('termo_autoria')->nullable();
            $table->boolean('autorizacao')->nullable();
            $table->string('link_trabalho')->nullable();
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
        Schema::dropIfExists('submissao_expocom_regional_nortes');
    }
}
