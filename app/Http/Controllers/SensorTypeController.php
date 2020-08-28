<?php

namespace App\Http\Controllers;

use App\SensorType;
use HttpException;
use Illuminate\Http\Request;


class SensorTypeController extends Controller
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
        $sensorTypes = SensorType::paginate(15);
        return view('sensor-type.index', ['sensorTypes' => $sensorTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sensor-type.create');
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
            'title' => 'required',
            'min' => 'required',
            'max' => 'required',
            'unit' => 'required'
        ]);

        $data = $request->all();

        SensorType::query()->create($data);

        return redirect()->route('sensor-type-index')
            ->with('success','Типа сензор е добавен успешно');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sensorType = SensorType::query()->find($id);

        return view('sensor-type.edit', ['device' => $sensorType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'latitude' => 'required',
            'longitude' => 'required',
            'token' => 'required'
        ]);
        SensorType::query()->find($id)->update($request->all());
        return redirect()->route('sensor-type-index')
            ->with('success','Типа сензор беше редактиран успешно');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     * @throws HttpException
     */
    public function destroy($id)
    {
        throw new HttpException(501,"Method is not implemented");
    }


}
