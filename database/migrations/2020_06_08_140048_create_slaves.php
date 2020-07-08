<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slaves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('agility')->notnull();
            $table->integer('intelligence')->notnull();
            $table->float('cost')->notnull();
            $table->float('rateComfort')->notnull();
            $table->float('dailyExpenses')->notnull();
            $table->string('image')->nullable();
            $table->string('master')->nullable();
            $table->string('seller')->nullable();
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
        Schema::dropIfExists('slaves');
    }
}
