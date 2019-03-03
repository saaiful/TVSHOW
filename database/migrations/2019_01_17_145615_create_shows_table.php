<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tvmaze_id');
            $table->string('imdb', 20)->nullable();
            $table->string('genres', 255)->nullable();
            $table->string('name', 255);
            $table->string('search', 255)->nullable();
            $table->string('match', 255)->nullable();
            $table->text('summary')->nullable();
            $table->time('schedule');
            $table->string('cover', 255);
            $table->integer('season');
            $table->integer('episode');
            $table->integer('p_episode');
            $table->integer('n_episode');
            $table->date('last_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shows');
    }
}
