<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sensor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('sensor_type')->unsigned()->index()->nullable(true);
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('device');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device');
    }
}
