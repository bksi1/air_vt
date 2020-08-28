<?php

namespace App\Http\Controllers;

use App\Device;
use App\Sensor;
use App\SensorType;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sensors = Sensor::paginate(15);
        return view('sensor.index', ['sensors' => $sensors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sensorTypeRows = SensorType::all()->toArray();
        $sensorTypes = ['' => 'Моля изберете'];
        foreach ($sensorTypeRows as $row) {
            $sensorTypes[$row['id']] = $row['title'];
        }
        $deviceRows = Device::all()->toArray();
        $devices = ['' => 'Моля изберете'];
        foreach ($deviceRows as $row) {
            $devices[$row['id']] = $row['title'];
        }

        return view('sensor.create', ['sensorTypes' => $sensorTypes, 'devices' => $devices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
            'sensor_type' => 'required',
        ]);

        $data = $request->all();

        Sensor::query()->create($data);

        return redirect()->route('sensor-index')
            ->with('success','Сензора е добавенo успешно');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor)
    {
        //
    }
}
