<?php

namespace App\Http\Controllers;

use App\Device;
use App\Sensor;
use App\SensorData;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Response;
use HttpException;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class SensorDataController extends Controller
{
    private $request;
    private $device;
    private $requestBody;

    public function __construct(Request $request)
    {
        $action = Route::getCurrentRoute()->getActionName();

        if (!empty($request->getContent())) {
            $requestBody = json_decode($request->getContent());
            if (!empty($requestBody->token)) {
                $token = $requestBody->token;
                $this->requestBody = $requestBody;
            }
        }

        if (empty($token)) $token = $request->get('token');
        $this->device = Device::query()->where('token', '=', $token)->first();
        if (empty ($this->device) && strpos($action, "gettoken") === false) {
            echo json_encode(['message' => 'Device not found', 'success' => false]);
            exit;
        }

        $this->request = $request;
    }

    public function getdata() {

        if (! empty($this->requestBody)) {
            $this->request->merge(['sensor_types' => ! empty($this->requestBody->sensor_types) ? $this->requestBody->sensor_types : null]);
        }
        try {

            $this->validate($this->request, [
                'sensor_types' => 'required',
            ]);
        } catch (ValidationException $e) {
            echo json_encode(['message' => $e->getMessage(), 'success' => false]);
            exit;
        }
        $data = $this->request->all();

        if (empty($data['latitude']) || empty($data['longitude'])) {
            $data['latitude'] = $this->device->latitude;
            $data['longitude'] = $this->device->longitude;
        }

        $data['device_id'] = $this->device->id;
        try {
            $payLoad = $data;
            $this->device->last_data = json_encode($data['sensor_types']);
            unset($data['sensor_types']);
            foreach ($payLoad['sensor_types'] as $typeId => $value) {
                $data['sensor_type'] = $typeId;
                $data['value'] = $value;
                SensorData::query()->create($data);
            }
            $this->device->save();

            echo json_encode(['message' => 'Success', 'success' => true]);
        } catch (\Exception $e) {
            echo json_encode(['message' => $e->getMessage(), 'success' => false]);
        }
        exit;
    }

    /*
     * controller should send POST request with 2 fields
     * latitude
     * longitude
     */
    public function getToken() {
        try {
            $device = new Device();
            $device->token = Device::generateToken();
            $device->latitude = $this->request->get("latitude");
            $device->longitude = $this->request->get("longitude");
            $device->title = !empty($this->request->get("title")) ? $this->request->get("title") . '-' . time() : 'Device-' . time();
            if (!$device->save()) {
                echo '{"success": false, "message": "Could not save device", "token": null}';
                exit;
            } else {
                $response = [
                    'success' => true,
                    'message' => 'Success',
                    'token' => $device->token
                ];
                echo json_encode($response);
                exit;
            }
        } catch (\Exception $e) {
            echo '{"success": false, "message": "Could not save device '.$e->getMessage().'", "token": null}';
            exit;
        }
    }
}
