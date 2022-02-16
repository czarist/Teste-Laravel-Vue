<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->date('data_nascimento');
            $table->boolean('estrangeiro')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->string('rg')->unique()->nullable();
            $table->string('orgao_expedidor')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular');
            $table->bigInteger('sexo_id')->nullable();
            $table->bigInteger('instituicao_id')->nullable();
            $table->bigInteger('titulacao_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->bigInteger('tipo_users_id')->default(1)->unsigned();
            $table->foreign('tipo_users_id')->references('id')->on('tipo_users');
            $table->char('ativo')->default(1);
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
        Schema::dropIfExists('users');
    }
}
