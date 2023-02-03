<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->references('id')->on('client');
            $table->dateTime('period_from');
            $table->dateTime('period_to');
            $table->integer('period_app_limit');
            $table->integer('daily_app_limit')->nullable();
        });

        Schema::create('delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->references('id')->on('client');
            $table->dateTime('delivery_date');
            $table->string('driver_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
