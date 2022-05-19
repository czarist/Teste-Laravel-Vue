<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColuminInAvaliadorExpocom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avaliador_expocoms', function (Blueprint $table) {
            $table->boolean('nacional_gp')->after('avaliador_junior')->default(false);
            $table->boolean('nacional_ij')->after('nacional_gp')->default(false);
            $table->boolean('nacional_publicom')->after('nacional_ij')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avaliador_expocoms', function (Blueprint $table) {
            $table->dropColumn('nacional_gp');
            $table->dropColumn('nacional_ij');
            $table->dropColumn('nacional_publicom');

        });
    }
}
