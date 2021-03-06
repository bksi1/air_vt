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
                <a class="btn btn-primary" href="{{ route('sensor-type-index') }}">Обратно</a>
            </div>
        </div>
    </div>

    {!! Form::model($device, ['method' => 'post','route' => ['sensor-type-update', $device->id]]) !!}

    @include('sensor-type.form', ["device" => $device])

    {!! Form::close() !!}
    </div>
@endsection
