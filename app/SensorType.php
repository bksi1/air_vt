<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sensor_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'unit', 'min', 'max',
    ];

    public function sensors() {
        return $this->hasMany('App\Sensor');
    }

    public static function getSensorList() {
        $allTypes = self::all();
        $returnData = [];
        foreach ($allTypes as $type) {
            $returnData[$type->id] = $type->toArray();
        }

        return $returnData;
    }
}
