<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sensor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sensor_type', 'device_id'
    ];

    public function device() {
        return $this->belongsTo('App\Device');
    }

    public function sensorType() {
        return $this->belongsTo('App\SensorType', 'sensor_type');
    }
}
