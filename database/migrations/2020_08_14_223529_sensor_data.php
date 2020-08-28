<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SensorData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device_id')->unsigned()->nullable(true)->index();
            $table->bigInteger('sensor_id')->unsigned()->nullable(true)->index();
            $table->tinyInteger('sensor_type')->unsigned();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('value');
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
        Schema::dropIfExists('sensor_data');
    }
}
