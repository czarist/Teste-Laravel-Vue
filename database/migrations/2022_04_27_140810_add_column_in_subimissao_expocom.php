<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInSubimissaoExpocom extends Migration
{
    public function up()
    {
        Schema::table('submissao_expocom_regional_suls', function (Blueprint $table) {
            $table->string('link_aceite')->after('link_trabalho')->nullable();
        });

        Schema::table('submissao_expocom_regional_centrooestes', function (Blueprint $table) {
            $table->string('link_aceite')->after('link_trabalho')->nullable();
        });

        Schema::table('submissao_expocom_regional_nordestes', function (Blueprint $table) {
            $table->string('link_aceite')->after('link_trabalho')->nullable();
        });

        Schema::table('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->string('link_aceite')->after('link_trabalho')->nullable();
        });

        Schema::table('submissao_expocom_regional_sudestes', function (Blueprint $table) {
            $table->string('link_aceite')->after('link_trabalho')->nullable();
        });
    }

    public function down()
    {
        Schema::table('submissao_expocom_regional_suls', function (Blueprint $table) {
            $table->dropColumn('link_aceite');
        });

        Schema::table('submissao_expocom_regional_centrooestes', function (Blueprint $table) {
            $table->dropColumn('link_aceite');
        });

        Schema::table('submissao_expocom_regional_nordestes', function (Blueprint $table) {
            $table->dropColumn('link_aceite');
        });

        Schema::table('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->dropColumn('link_aceite');
        });

        Schema::table('submissao_expocom_regional_sudestes', function (Blueprint $table) {
            $table->dropColumn('link_aceite');
        });
    }
}
