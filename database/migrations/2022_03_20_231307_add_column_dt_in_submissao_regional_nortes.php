<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDtInSubmissaoRegionalNortes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissao_regional_nortes', function (Blueprint $table) {
            $table->bigInteger('dt')->after('inscricao_id')->nullable();
            $table->boolean('ciente')->after('dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissao_regional_nortes', function (Blueprint $table) {
            $table->dropColumn('dt');
            $table->dropColumn('ciente');
        });
    }
}
