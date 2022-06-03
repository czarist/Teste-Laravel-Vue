<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApresentacaoInSubmissoes extends Migration
{
    public function up()
    {
        Schema::table('submissao_expocom_regional_centrooestes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_expocom_regional_nordestes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_expocom_regional_suls', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_expocom_regional_sudestes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_nacionals', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_regional_centrooestes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_regional_nordestes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_regional_nortes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_regional_suls', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });

        Schema::table('submissao_regional_sudestes', function (Blueprint $table) {
            $table->boolean('apresentacao')->after('avaliacao')->default(false);
            $table->boolean('vencedor')->after('apresentacao')->default(false);
        });
    }

    public function down()
    {
        Schema::table('submissao_expocom_regional_centrooestes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_expocom_regional_nordestes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_expocom_regional_suls', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_expocom_regional_sudestes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_nacionals', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_nacionals', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_regional_centrooestes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_regional_nordestes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_regional_nortes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_regional_suls', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });

        Schema::table('submissao_regional_sudestes', function (Blueprint $table) {
            $table->dropColumn('apresentacao');
            $table->dropColumn('vencedor');
        });
    }
}
