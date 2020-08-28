@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">


        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Редакция на device</h2>
            </div>

            <div class="pull-right">
                <br/>
                <a class="btn btn-primary" href="{{ route('device-index') }}">Обратно</a>
            </div>
        </div>
    </div>

    {!! Form::model($device, ['method' => 'post','route' => ['device-update', $device->id]]) !!}

    @include('device.form', ["device" => $device])

    {!! Form::close() !!}
    </div>
@endsection
