<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('estrangeiro')->nullable();
            $table->string('passaporte')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('rg')->unique()->nullable();
            $table->string('orgao_expedidor')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->unsignedBigInteger('sexo_id')->nullable();
            $table->foreign('sexo_id')->references('id')->on('sexos')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->char('ativo')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
