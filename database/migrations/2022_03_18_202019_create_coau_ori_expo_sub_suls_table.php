<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoauOriExpoSubSulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coau_ori_expo_sub_suls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('submissao_id');
            $table->foreign('submissao_id')->references('id')->on('submissao_expocom_regional_suls');
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
        Schema::dropIfExists('coau_ori_expo_sub_suls');
    }
}
