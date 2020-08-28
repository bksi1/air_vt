<?php

namespace App\Http\Controllers;

use App\Device;
use App\SensorType;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index() {
        $gmapsApiKey = config('api.gmaps_key');
        $gmapsLatitude = config('api.gmaps_lat');
        $gmapsLongitude = config('api.gmaps_lng');
        $types = SensorType::getSensorList();
        $deviceInfo = $this->getDeviceInfo();

        return view('map', ['gmapsApiKey' => $gmapsApiKey, 'gmapsLatitude' => $gmapsLatitude, 'gmapsLongitude' => $gmapsLongitude, 'devices' => $deviceInfo, 'types' => $types]);
    }

    public function refresh() {
        $types = SensorType::getSensorList();
        $deviceInfo = $this->getDeviceInfo();
        $returnData = ['devices' => $deviceInfo, 'types' => $types];

        echo json_encode($returnData);
        exit;
    }

    private function getDeviceInfo() {
        $devices= Device::all();
        $types = SensorType::getSensorList();

        $deviceInfo = [];

        foreach ($devices as $device) {
            if (! empty($device->last_data)) {
                $lastData = json_decode($device->last_data, true);
                $latestLocation = ! empty($lastData['location']) ? ['lat' => $lastData['location']['lat'], 'lng' => $lastData['location']['lng']] : ['lat' => $device->latitude, 'lng' => $device->longitude];
                unset($lastData['location']);
                $alert = 'green';
                $sensorData = [];
                foreach ($lastData as $sensorType => $value) {
                    if ($value >= $types[$sensorType]['max']) {
                        $alert = 'red';
                    }
                    $sensorData[$types[$sensorType]['title']] = [
                        'units' => $types[$sensorType]['unit'],
                        'value' => $value,
                        'alert' => $value >= $types[$sensorType]['max'] ? 'red' : ($value <= $types[$sensorType]['min'] ? 'blue' : 'green')
                    ];
                    $deviceInfo[$device->title] = [
                        'sensorData' => $sensorData,
                        'location' => $latestLocation,
                        'alertIcon' => $alert
                    ];
                }

            }
        }
        return $deviceInfo;
    }

}
