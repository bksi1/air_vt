<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sensor_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'sensor_id', 'sensor_type', 'latitude', 'longitude', 'value'
    ];
}
