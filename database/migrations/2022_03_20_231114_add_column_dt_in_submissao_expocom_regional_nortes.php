<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDtInSubmissaoExpocomRegionalNortes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->boolean('ciente')->after('inscricao_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissao_expocom_regional_nortes', function (Blueprint $table) {
            $table->dropColumn('ciente');
        });
    }
}
