<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class ArenaInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arenaInfo', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->integer('strength')->notnull();
            $table->integer('agility')->notnull();
            $table->integer('heals')->notnull();
            $table->float('cost')->notnull();
            $table->float('rate')->notnull();
            $table->string('image')->nullable();
            $table->string('master')->nullable();
            $table->string('seller')->nullable();
            $table->string('arena')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arenaInfo');

    }
}
