<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CreateGladiators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gladiators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('strength')->notnull();
            $table->integer('agility')->notnull();
            $table->integer('heals')->notnull();
            $table->float('cost')->notnull();
            $table->float('rate')->notnull();
            $table->string('image')->nullable();
            $table->string('master')->nullable();
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
        Schema::dropIfExists('gladiators');

    }
}
