<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDtInSubmissaoExpocomRegionalCentrooeste extends Migration
{
    public function up()
    {
        Schema::table('submissao_expocom_regional_centrooestes', function (Blueprint $table) {
            $table->boolean('ciente')->after('inscricao_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('submissao_expocom_regional_centrooestes', function (Blueprint $table) {
            $table->dropColumn('ciente');
        });
    }
}
