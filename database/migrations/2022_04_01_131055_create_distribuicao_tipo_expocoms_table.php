<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistribuicaoTipoExpocomsTable extends Migration
{
    public function up()
    {
        Schema::create('distribuicao_tipo_expocoms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('avaliador_1');
            $table->string('status_avaliador_1')->nullable();
            $table->string('justificativa_avaliador_1')->nullable();
            $table->decimal('expe_1', 15, 2)->nullable();
            $table->decimal('qualidade_1', 15, 2)->nullable();
            $table->decimal('coerencia_1', 15, 2)->nullable();
            $table->decimal('media_1', 15, 2)->nullable();
            $table->bigInteger('avaliador_2')->nullable();
            $table->string('status_avaliador_2')->nullable();
            $table->string('justificativa_avaliador_2')->nullable();
            $table->decimal('expe_2', 15, 2)->nullable();
            $table->decimal('qualidade_2', 15, 2)->nullable();
            $table->decimal('coerencia_2', 15, 2)->nullable();
            $table->decimal('media_2', 15, 2)->nullable();
            $table->bigInteger('avaliador_3')->nullable();
            $table->string('status_avaliador_3')->nullable();
            $table->string('justificativa_avaliador_3')->nullable();
            $table->decimal('expe_3', 15, 2)->nullable();
            $table->decimal('qualidade_3', 15, 2)->nullable();
            $table->decimal('coerencia_3', 15, 2)->nullable();
            $table->decimal('media_3', 15, 2)->nullable();
            $table->string('status_coordenador')->nullable();
            $table->string('justificativa_coordenador')->nullable();
            $table->decimal('media_final', 15, 2)->nullable();
            $table->bigInteger('edit')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distribuicao_tipo_expocoms');
    }
}
