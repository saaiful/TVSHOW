<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shows', function (Blueprint $table) {
            $table->date('premiered')->nullable();
            $table->tinyInteger('thetvdb')->unsigned();
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->tinyInteger('status')->unsigned()->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shows', function ($table) {
            $table->dropColumn('premiered');
            $table->dropColumn('thetvdb');
        });

        // Schema::table('episodes', function (Blueprint $table) {
        //     $table->dropColumn('status');
        // });
    }
}
