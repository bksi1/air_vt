<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeviceController extends Controller
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
        $devices = Device::paginate(15);
        return view('device.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('device.create');
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
            'latitude' => 'required',
            'longitude' => 'required',
            'token' => 'required'
        ]);

        $data = $request->all();

        Device::query()->create($data);

        return redirect()->route('device-index')
            ->with('success','Устройството е добавенo успешно');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $device = Device::query()->find($id);

        return view('device.edit', ['device' => $device]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
        Device::query()->find($id)->update($request->all());
        return redirect()->route('device-index')
            ->with('success','Устройството беше редактирано успешно');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Device $device
     * @return \Illuminate\Http\Response
     * @throws \HttpException
     */
    public function destroy(Device $device)
    {
        throw new HttpException(501,"Method is not implemented");
    }
}
