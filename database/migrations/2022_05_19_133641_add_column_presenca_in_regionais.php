<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPresencaInRegionais extends Migration
{
    public function up()
    {
        Schema::table('regional_nordestes', function (Blueprint $table) {
            $table->boolean('presenca')->after('user_id')->default(false);
        });

        Schema::table('regional_centrooestes', function (Blueprint $table) {
            $table->boolean('presenca')->after('user_id')->default(false);
        });

        Schema::table('regional_suldestes', function (Blueprint $table) {
            $table->boolean('presenca')->after('user_id')->default(false);
        });

        Schema::table('regional_suls', function (Blueprint $table) {
            $table->boolean('presenca')->after('user_id')->default(false);
        });

        Schema::table('regional_nortes', function (Blueprint $table) {
            $table->boolean('presenca')->after('user_id')->default(false);
        });

        Schema::table('nacionals', function (Blueprint $table) {
            $table->boolean('presenca')->after('user_id')->default(false);
        });
    }

    public function down()
    {
        Schema::table('regional_nordestes', function (Blueprint $table) {
            $table->dropColumn('presenca');
        });

        Schema::table('regional_centrooestes', function (Blueprint $table) {
            $table->dropColumn('presenca');
        });

        Schema::table('regional_suldestes', function (Blueprint $table) {
            $table->dropColumn('presenca');
        });

        Schema::table('regional_suls', function (Blueprint $table) {
            $table->dropColumn('presenca');
        });

        Schema::table('regional_nortes', function (Blueprint $table) {
            $table->dropColumn('presenca');
        });

        Schema::table('nacionals', function (Blueprint $table) {
            $table->dropColumn('presenca');
        });
    }
}
